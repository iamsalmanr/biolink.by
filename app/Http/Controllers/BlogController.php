<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Methods\ReCaptchaValidation;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class BlogController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        abort_if(!config('settings.blog')->status, 404);
        $this->activeTheme = active_theme();
    }

    /**
     * Display the page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $page_limit = config('settings.blog')->page_limit;

        if ($search = request()->input('search')) {
            $blogs = Blog::where([['title', 'like', '%' . $search . '%'], ['lang', get_lang()]])
                ->OrWhere([['tags', 'like', '%' . $search . '%'], ['lang', get_lang()]])
                ->orderbyDesc('id')
                ->paginate($page_limit);

            $blogs->appends(['search' => $search]);
        } else {
            $blogs = Blog::where('lang', get_lang())->orderbyDesc('id')->paginate($page_limit);
        }

        return view($this->activeTheme . '.blog.index', compact('blogs'));
    }

    /**
     * Display single blog page
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function single($slug)
    {
        $blog = Blog::where([['lang', get_lang()], ['slug', $slug]])->with(['user', 'blogCategory'])->first();
        if ($blog) {
            $next_record = Blog::where('id', '>', $blog->id)->orderBy('id')->first();
            $previous_record = Blog::where('id', '<', $blog->id)->orderBy('id', 'desc')->first();
            $blogComments = BlogComment::where([['article_id', $blog->id], ['status', 1]])->get();

            $blog->tags = explode(',', $blog->tags);

            return view($this->activeTheme . '.blog.single', compact(
                'blog',
                'blogComments',
                'next_record',
                'previous_record',
            ));
        } else {
            abort(404);
        }
    }

    /**
     * Display the tag page
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function tag($slug)
    {
        $page_limit = config('settings.blog')->page_limit ?? 8;

        $blogs = Blog::where([['tags', 'like', '%' . $slug . '%'], ['lang', get_lang()]])
            ->orderbyDesc('id')
            ->paginate($page_limit);
        $blogTag = $slug;

        return view($this->activeTheme . '.blog.tag', compact(
            'blogTag',
            'blogs'
        ));
    }

    /**
     * Display the category page
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function category($slug)
    {
        $page_limit = config('settings.blog')->page_limit;
        $category = BlogCategory::where([['lang', get_lang()], ['slug', $slug]])->first();
        if ($category) {

            $blogs = Blog::where('category_id', $category->id)->orderbyDesc('id')->paginate($page_limit);

            return view($this->activeTheme . '.blog.category', compact(
                'category',
                'blogs'
            ));
        } else {
            abort(404);
        }
    }

    /**
     * Handle comment
     *
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function comment(Request $request, $slug)
    {
        if (!Auth::check()) {
            quick_alert_error(___('Please login to post a comment.'));
            return back();
        }

        /* Check if comment enabled */
        if (config('settings.blog')->commenting) {

            $validator = Validator::make($request->all(), [
                    'comment' => ['required', 'string'],
                ] + validate_recaptcha());
            if ($validator->fails()) {
                $errors = [];
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                quick_alert_error(implode('<br>', $errors));
                return back()->withInput();
            }

            $blog = Blog::where('slug', $slug)->with('user')->firstOrFail();

            $create = BlogComment::create([
                'article_id' => $blog->id,
                'user_id' => request()->user()->id,
                'comment' => $request->comment,
            ]);

            if ($create) {

                /* add admin notification */
                create_notification(___('New comment received'), 'new_comment', route('admin.comments.index'));

                quick_alert_success(___('Comment is posted, wait for the reviewer to approve.'));
                return back();
            }
        } else {
            quick_alert_error(___('Unexpected error'));
            return back();
        }
    }
}
