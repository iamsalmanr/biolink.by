<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Page;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Validator;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('lang')) {
            $language = Language::where('code', $request->lang)->firstOrFail();
            $current_language = $language->code;

            $pages = Page::where('lang', $language->code)->with('language')->get();

            return view('admin.pages.index', compact('pages', 'current_language'));
        } else {
            return redirect(url()->current() . '?lang=' . env('DEFAULT_LANGUAGE'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'min:2', 'max:255'],
            'content' => ['required', 'min:2'],
            'short_description' => ['required', 'min:2', 'max:200'],
            'slug' => ['nullable', 'unique:pages', 'alpha_dash'],
            'lang' => ['required', 'string',  'exists:languages,code'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $create = Page::create([
            'title' => $request->title,
            'slug' => !empty($request->slug)
                        ? $request->slug
                        : SlugService::createSlug(Page::class, 'slug', $request->title),
            'content' => $request->content,
            'short_description' => $request->short_description,
            'lang' => $request->lang,
        ]);
        if ($create) {
            $result = array('success' => true, 'message' => ___('Created Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'min:2', 'max:255'],
            'content' => ['required', 'min:2'],
            'short_description' => ['required', 'min:2', 'max:200'],
            'slug' => ['nullable', 'alpha_dash', 'unique:pages,slug,' . $page->id],
            'lang' => ['required', 'string',  'exists:languages,code'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $response = $page->update([
            'title' => $request->title,
            'slug' => !empty($request->slug)
                ? $request->slug
                : SlugService::createSlug(Page::class, 'slug', $request->title),
            'content' => $request->content,
            'short_description' => $request->short_description,
            'lang' => $request->lang,
        ]);

        if ($response) {
            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        quick_alert_success(___('Deleted Successfully'));
        return back();
    }
}
