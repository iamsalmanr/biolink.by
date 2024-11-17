<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostLink;
use App\Models\PostOption;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class PostController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activeTheme = active_theme();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $biopage_limit = request()->user()->plan_settings->biopage_limit;

        $biopage_count = Post::where('user_id', request()->user()->id)->count();
        if ($biopage_limit != -1 && $biopage_count >= $biopage_limit) {
            quick_alert_error(___("Bio page limit exceed upgrade your plan."));
            return back();
        } else {
            return view($this->activeTheme . '.user.posts.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $biopage_limit = request()->user()->plan_settings->biopage_limit;

        $biopage_count = Post::where('user_id', request()->user()->id)->count();
        if ($biopage_limit != -1 && $biopage_count >= $biopage_limit) {
            quick_alert_error(___("Bio page limit exceed upgrade your plan."));
            return back()->withInput();
        }

        $validator = Validator::make($request->all(), [
            'logo' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'name' => ['required', 'string', 'max:50'],
            'bio' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'unique:posts', 'alpha_dash'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                quick_alert_error($error);
            }
            return back()->withInput();
        }

        if ($request->has('logo')) {
            $avatar = image_upload($request->file('logo'), 'storage/post/logo/', '150x150');
        }

        $create = Post::create([
            'user_id' => request()->user()->id,
            'title' => $request->name,
            'content' => $request->bio,
            'slug' => !empty($request->slug)
                ? $request->slug
                : SlugService::createSlug(Post::class, 'slug', $request->name),
            'image' => $avatar,
        ]);

        if ($create) {
            /* Adding Default Post Options */
            PostOption::updatePostOption($create->id, 'biotheme', 'basic');
            PostOption::updatePostOption($create->id, 'bio_credit', 1);
            PostOption::updatePostOption($create->id, 'bio_share', 1);
            PostOption::updatePostOption($create->id, 'seo_title', $request->name);
            PostOption::updatePostOption($create->id, 'seo_desc', $request->bio);

            quick_alert_success(___('Created Successfully'));
            return redirect()->route('biolinks.edit', $create->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     */
    public function publicView($slug)
    {
        $post = Post::where('slug', $slug)->first();
        if ($post) {

            /* check user's plan is enabled */
            if ($post->user->plan()->status) {

                $post->increment('views');

                $postOptions = post_options($post->id);
                if (empty($postOptions->biotheme)) {
                    $postOptions->biotheme = 'basic';
                }

                $bioLinks = PostLink::where([['post_id', $post->id], ['active', 1]])->orderBy('position', 'ASC')->get();

                /* generate the qr code svg */
                $renderer = new ImageRenderer(
                    new RendererStyle(200),
                    new SvgImageBackEnd()
                );
                $writer = new Writer($renderer);
                $qr_image = $writer->writeString(url()->current());

                $theme = $postOptions->biotheme;

                return view('post_templates.' . $postOptions->biotheme . '.index', compact(
                    'post',
                    'bioLinks',
                    'theme',
                    'postOptions',
                    'qr_image',
                ));
            }
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $biolink
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $biolink)
    {
        $user = request()->user();
        if ($biolink->user_id == $user->id) {
            $postOptions = post_options($biolink->id);

            $bioLinks = PostLink::where('post_id', $biolink->id)->orderBy('position', 'ASC')->get();

            $templates = [];
            $temPaths = array_filter(glob(base_path() . '/resources/views/post_templates/*'), 'is_dir');
            foreach ($temPaths as $key => $temp) {
                $arr = explode('/', $temp);
                $tempname = end($arr);
                $templates[$key]['name'] = $tempname;
                $templates[$key]['image'] = asset('post_templates/' . $tempname . '/preview.png');
            }
            $post = $biolink;

            return view($this->activeTheme . '.user.posts.edit', compact(
                'user',
                'post',
                'bioLinks',
                'postOptions',
                'templates'
            ));
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $biolink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $biolink)
    {
        if ($biolink->user_id == request()->user()->id) {
            if ($request->has('type')) {
                if ($request->type == 'settings') {
                    $validator = Validator::make($request->all(), [
                        'cover' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
                        'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
                        'name' => ['required', 'string', 'max:50'],
                        'bio' => ['required', 'string', 'max:255'],
                        'slug' => ['nullable', 'alpha_dash', 'unique:posts,slug,' . $biolink->id],
                    ]);
                    $errors = [];
                    if ($validator->fails()) {
                        foreach ($validator->errors()->all() as $error) {
                            $errors[] = $error;
                        }
                        $result = array('success' => false, 'message' => implode('<br>', $errors));
                        return response()->json($result, 200);
                    }

                    $postOptions = post_options($biolink->id);
                    $coverImage = @$postOptions->cover_image;

                    if ($request->has('cover') && !empty($request->cover)) {
                        $coverImage = image_upload($request->file('cover'), 'storage/post/logo/', null, null, $coverImage);
                    }

                    if ($request->has('logo') && !empty($request->logo)) {
                        $avatar = image_upload($request->file('logo'), 'storage/post/logo/', null, null, $biolink->image);
                    } else {
                        $avatar = $biolink->image;
                    }

                    $slug = !empty($request->slug) ? $request->slug : $biolink->slug;
                    $update = $biolink->update([
                        'title' => $request->name,
                        'content' => $request->bio,
                        'slug' => $slug,
                        'image' => $avatar,
                    ]);

                    if ($update) {
                        PostOption::updatePostOption($biolink->id, 'cover_image', $coverImage);
                        PostOption::updatePostOption($biolink->id, 'seo_title', $request->seo_title);
                        PostOption::updatePostOption($biolink->id, 'seo_desc', $request->seo_desc);

                        $result = array('success' => true, 'message' => ___('Updated Successfully'));
                        return response()->json($result, 200);
                    } else {
                        $result = array('success' => false, 'message' => ___('Something went wrong please try again'));
                        return response()->json($result, 200);
                    }

                } elseif ($request->type == 'design') {
                    $bio_credit = ($request->has('bio_credit')) ? 1 : 0;
                    $bio_share = ($request->has('bio_share')) ? 1 : 0;

                    PostOption::updatePostOption($biolink->id, 'biotheme', $request->biotheme);
                    PostOption::updatePostOption($biolink->id, 'bio_credit', $bio_credit);
                    PostOption::updatePostOption($biolink->id, 'bio_share', $bio_share);

                    $result = array('success' => true, 'message' => ___('Updated Successfully'));
                    return response()->json($result, 200);
                }
            }
        }

        $result = array('error' => true, 'message' => ___('Unexpected Error'));
        return response()->json($result, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $biolink
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $biolink)
    {
        if ($biolink->user_id == request()->user()->id) {
            $links = PostLink::where('post_id', $biolink->id)->get();
            foreach ($links as $link) {
                if ($link->type == "link") {
                    if ($link->settings->logo != '') {
                        remove_file('storage/post/biolink/' . $link->settings->logo);
                    }
                }
                $link->delete();
            }

            if(!empty($biolink->image)) {
                remove_file('storage/post/logo/' . $biolink->image);
            }

            $postOptions = post_options($biolink->id);
            $coverImage = @$postOptions->cover_image;
            if(!empty($coverImage)) {
                remove_file('storage/post/logo/' . $coverImage);
            }

            $biolink->delete();
        }
        quick_alert_success(___('Deleted Successfully'));
        return redirect()->route('dashboard', $biolink->id);

    }

    /**
     * Reorder
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function reorder(Request $request, Post $post)
    {
        if ($post->user_id == request()->user()->id) {
            $position = $request->position;
            if (is_array($request->position)) {
                $count = 0;
                foreach ($position as $id) {
                    $update = PostLink::where('id', $id)->update([
                        'position' => $count,
                    ]);

                    $count++;
                }
                if ($update) {
                    $result = array('success' => true, 'message' => ___('Updated Successfully'));
                    return response()->json($result, 200);
                }
            }

            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        } else {
            $result = array('success' => false, 'message' => ___('Unexpected Error'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addheader(Request $request, Post $post)
    {
        if ($post->user_id == request()->user()->id) {
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255']
            ]);
            $errors = [];
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            $settings = array();
            $settings['title'] = $request->title;

            $create = PostLink::create([
                'post_id' => $post->id,
                'type' => "header",
                'settings' => $settings
            ]);
            if ($create) {
                $result = array(
                    'success' => true,
                    'message' => ___('Added Successfully'),
                    'id' => $create->id,
                    'type' => "header",
                    'settings' => $settings,
                );
                return response()->json($result, 200);
            }
        } else {
            $result = array('success' => false, 'message' => ___('Unexpected Error'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editHeader(Request $request, Post $post)
    {
        if ($post->user_id == request()->user()->id) {

            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255']
            ]);
            $errors = [];
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            $settings = array();
            $settings['title'] = $request->title;
            $active = ($request->has('active')) ? 0 : 1;
            $update = PostLink::where([['id', $request->id], ['post_id', $post->id]])->update(['settings' => $settings, 'active' => $active]);
            if ($update) {
                $result = array(
                    'success' => true,
                    'message' => ___('Updated Successfully'),
                    'type' => "header",
                    'id' => $request->id,
                    'active' => $active,
                    'settings' => $settings,
                );
                return response()->json($result, 200);
            } else {
                $result = array('success' => false, 'message' => ___('Something went wrong please try again'));
                return response()->json($result, 200);
            }
        } else {
            $result = array('success' => false, 'message' => ___('Unexpected Error'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addlink(Request $request, Post $post)
    {
        if ($post->user_id == request()->user()->id) {

            $biolink_limit = request()->user()->plan_settings->biolink_limit;

            $biolink_count = PostLink::where([['type', 'link'], ['post_id', $post->id]])->count();
            if ($biolink_limit != -1 && $biolink_count >= $biolink_limit) {
                $result = array('success' => false, 'message' => ___("Add link limit exceed upgrade your plan."));
                return response()->json($result, 200);
            }

            $validator = Validator::make($request->all(), [
                'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
                'title' => ['required', 'string', 'max:255'],
                'url' => ['required', 'string', 'max:255']
            ]);
            $errors = [];
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            $avatar = "";
            if ($request->has('logo') && !empty($request->logo)) {
                $avatar = image_upload($request->file('logo'), 'storage/post/biolink/');
            }

            $settings = array();
            $settings['title'] = $request->title;
            $settings['url'] = $request->url;
            $settings['logo'] = $avatar;
            $settings['highlight'] = ($request->has('highlight') ? 1 : 0);

            $create = PostLink::create([
                'post_id' => $post->id,
                'type' => "link",
                'settings' => $settings
            ]);
            if ($create) {
                $result = array(
                    'success' => true,
                    'message' => ___('Added Successfully'),
                    'id' => $create->id,
                    'type' => "link",
                    'settings' => $settings,
                );
                return response()->json($result, 200);
            }
        } else {
            $result = array('success' => false, 'message' => ___('Unexpected Error'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editLink(Request $request, Post $post)
    {
        if ($post->user_id == request()->user()->id) {
            $validator = Validator::make($request->all(), [
                'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
                'title' => ['required', 'string', 'max:255'],
                'url' => ['required', 'string', 'max:255']
            ]);
            $errors = [];
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            $postlink = PostLink::where([['id', $request->id], ['post_id', $post->id]])->first();
            if ($request->has('logo') && !empty($request->logo)) {
                $avatar = image_upload($request->file('logo'), 'storage/post/biolink/', null, null, $postlink->settings->logo);
            } else {
                $avatar = $postlink->settings->logo;
            }

            $settings = array();
            $settings['title'] = $request->title;
            $settings['url'] = $request->url;
            $settings['logo'] = $avatar;
            $settings['highlight'] = ($request->has('highlight') ? 1 : 0);
            $active = ($request->has('active')) ? 0 : 1;

            $update = $postlink->update(['settings' => $settings, 'active' => $active]);
            if ($update) {
                $result = array(
                    'success' => true,
                    'message' => ___('Updated Successfully'),
                    'type' => "link",
                    'id' => $request->id,
                    'active' => $active,
                    'settings' => $settings,
                );
                return response()->json($result, 200);
            } else {
                $result = array('success' => false, 'message' => ___('Something went wrong please try again'));
                return response()->json($result, 200);
            }
        } else {
            $result = array('success' => false, 'message' => ___('Unexpected Error'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addsocial(Request $request, Post $post)
    {
        if ($post->user_id == request()->user()->id) {
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:10'],
                'url' => ['required', 'string', 'max:255']
            ]);
            $errors = [];
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            $settings = array();
            $settings['title'] = $request->title;
            $settings['url'] = $request->url;

            $create = PostLink::create([
                'post_id' => $post->id,
                'type' => "social",
                'settings' => $settings
            ]);
            if ($create) {
                $result = array(
                    'success' => true,
                    'message' => ___('Added Successfully'),
                    'id' => $create->id,
                    'type' => "social",
                    'settings' => $settings,
                );
                return response()->json($result, 200);
            }
        } else {
            $result = array('success' => false, 'message' => ___('Unexpected Error'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSocial(Request $request, Post $post)
    {
        if ($post->user_id == request()->user()->id) {
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:10'],
                'url' => ['required', 'string', 'max:255']
            ]);
            $errors = [];
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            $settings = array();
            $settings['title'] = $request->title;
            $settings['url'] = $request->url;
            $active = ($request->has('active')) ? 0 : 1;
            $update = PostLink::where([['id', $request->id], ['post_id', $post->id]])->update(['settings' => $settings, 'active' => $active]);
            if ($update) {
                $result = array(
                    'success' => true,
                    'message' => ___('Updated Successfully'),
                    'type' => "social",
                    'id' => $request->id,
                    'active' => $active,
                    'settings' => $settings,
                );
                return response()->json($result, 200);
            } else {
                $result = array('success' => false, 'message' => ___('Something went wrong please try again'));
                return response()->json($result, 200);
            }
        } else {
            $result = array('success' => false, 'message' => ___('Unexpected Error'));
            return response()->json($result, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteLink(Request $request, Post $post)
    {
        if ($post->user_id == request()->user()->id) {
            $link = PostLink::where([['id', $request->id], ['post_id', $post->id]])->first();
            if ($link->type == "link") {
                if ($link->settings->logo != '') {
                    remove_file('storage/post/biolink/' . $link->settings->logo);
                }
            }
            $link->delete();
            $result = array('success' => true, 'message' => ___('Deleted Successfully'));
            return response()->json($result, 200);
        }

    }
}
