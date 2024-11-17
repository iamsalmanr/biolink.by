<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temPaths = array_filter(glob(base_path().'/resources/views/templates/*'), 'is_dir');
        foreach ($temPaths as $key => $temp) {
            $arr = explode('/', $temp);
            $tempname = end($arr);
            $templates[$key]['name'] = $tempname;
            $templates[$key]['image'] = asset('templates/'.$tempname.'/preview.jpg');
        }
        $extra_templates = json_decode(null, true);
        return view('admin.templates.index', compact('templates', 'extra_templates'));
    }

    /**
     * Active template
     *
     * @return \Illuminate\Http\Response
     */
    public function templatesActive(Request $request)
    {
        set_env('THEME_NAME', $request->name);

        quick_alert_success(___('Updated successfully'));
        return back();
    }

}
