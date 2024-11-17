<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Language;
use App\Models\MailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $params = $columns = $order = $totalRecords = $data = array();
            $params = $request;

            //define index of column
            $columns = array(
                'position',
                'name',
                'active'
            );

            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $admins = Language::where('name', 'like', '%' . $q . '%')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $admins = Language::orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = Language::count();
            foreach ($admins as $row) {
                $rows = array();

                if($row->active == 1){
                    $status_badge = '<span class="badge bg-success">'.___('Active').'</span>';
                } else{
                    $status_badge = '<span class="badge bg-danger">'.___('Disabled').'</span>';
                }

                if ($row->code != env('DEFAULT_LANGUAGE')) {

                    $delete_button = '<form class="d-inline" action="'.route('admin.languages.destroy', $row->id).'" method="POST" onsubmit=\'return confirm("'.___('Are you sure?').'")\'>
                                    '.method_field('DELETE').'
                                    '.csrf_field().'
                                <button class="btn btn-icon btn-danger ms-1" title="'.___('Delete').'" data-tippy-placement="top"><i class="icon-feather-trash-2"></i ></button>
                            </form>';

                }else{
                    $delete_button = '';
                }

                $default = env('DEFAULT_LANGUAGE') == $row->code ? ___('(Default)') : "";

                $rows[] = '<td><i class="icon-feather-menu quick-reorder-icon"
                                       title="' . ___('Reorder') . '"></i> <span class="d-none">' . $row->id . '</span></td>';
                $rows[] = '<td><img class="flag" src="'.asset('storage/flags/'.$row->flag).'" alt="'.$row->name.'" width="25" height="25">
                            '.$row->name.'
                            <small class="text-muted">'.$default.'</small>
                            </td>';
                $rows[] = '<td>'.$status_badge.'</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                <a href="#" data-url="'.route('admin.languages.edit', $row->id).'" data-toggle="slidePanel" title="'.___('Edit').'" class="btn btn-default btn-icon me-1" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                <a href="'.route('admin.languages.translates', $row->code).'"
                            class="btn btn-icon btn-info" title="'.___('Translate').'" data-tippy-placement="top"><i class="icon-feather-globe"></i></a>
                                    '.$delete_button.'
                                </div>

                            </td>';
                $rows['DT_RowId'] = $row->id;
                $data[] = $rows;
            }

            $json_data = array(
                "draw"            => intval( $params['draw'] ),
                "recordsTotal"    => intval( $totalRecords ),
                "recordsFiltered" => intval($totalRecords),
                "data"            => $data   // total data array
            );
            return response()->json($json_data, 200);
        }

        return view('admin.languages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.languages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:10', 'min:2', 'unique:languages'],
            'direction' => ['required', 'integer', 'max:2'],
            'flag' => ['required', 'image', 'mimes:png,jpg,jpeg'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $request->code = trim($request->code);

        $error = false;

        /* Create language file */
        try {
            $defaultLanguage = env('DEFAULT_LANGUAGE');
            $langPath = base_path('lang/');
            if (!File::exists($langPath . $request->code)) {

                File::makeDirectory($langPath . $request->code);
                $defaultFiles = File::allFiles($langPath . $defaultLanguage);
                foreach ($defaultFiles as $file) {
                    $newFile = $langPath . $request->code . '/' . $file->getFilename();
                    if (!File::exists($newFile)) {
                        File::copy($file, $newFile);
                    }
                }
            }
        } catch (\Exception$e) {
            $error = $e->getMessage();
        }

        if (!$error) {
            $icon = image_upload($request->file('flag'), 'storage/flags/', null, $request->code);
            if ($icon) {

                $language = Language::create([
                    'name' => $request->name,
                    'code' => $request->code,
                    'direction' => $request->direction,
                    'flag' => $icon,
                    'position' => Language::get()->count() + 1,
                ]);

                if ($language) {
                    if ($request->get('is_default')) {
                        set_env('DEFAULT_LANGUAGE', $language->code);
                    }

                    /* Create mail templates for the new language */
                    $emails = MailTemplate::where('lang', env('DEFAULT_LANGUAGE'))->get();
                    foreach ($emails as $email) {
                        $create = new MailTemplate();
                        $create->key = $email->key;
                        $create->name = $email->name;
                        $create->subject = $email->subject;
                        $create->body = $email->body;
                        $create->shortcodes = $email->shortcodes;
                        $create->status = $email->status;
                        $create->lang = $language->code;
                        $create->save();
                    }

                    $result = array('success' => true, 'message' => ___('Created Successfully'));
                    return response()->json($result, 200);
                }
            }
        } else {
            quick_alert_error($error);
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Blog $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        return view('admin.languages.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Language $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:150'],
            'direction' => ['required', 'integer', 'max:2'],
            'flag' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'active' => ['required', 'boolean'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        if (!$request->get('is_default') || !$request->get('active')) {
            if ($language->code == env('DEFAULT_LANGUAGE')) {
                $result = array('success' => false, 'message' => $language->name . ' ' . ___('is the default language'));
                return response()->json($result, 200);
            }
        }

        if ($request->has('flag') && $request->flag != null) {
            $icon = image_upload($request->file('flag'), 'storage/flags/', null, $language->code, $language->flag);
        } else {
            $icon = $language->flag;
        }

        if ($icon) {
            $update = $language->update([
                'name' => $request->name,
                'direction' => $request->direction,
                'active' => $request->active,
                'flag' => $icon,
            ]);
            if ($update) {
                if ($request->get('is_default') && $request->get('active')) {
                    set_env('DEFAULT_LANGUAGE', $language->code);
                }

                $result = array('success' => true, 'message' => ___('Updated Successfully'));
                return response()->json($result, 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Language $language
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy(Language $language)
    {
        if ($language->code == env('DEFAULT_LANGUAGE')) {
            quick_alert_error(___('You can not delete the default language.'));
            return back();
        }

        /* Delete articles of this language */
        $articles = Blog::where('lang', $language->code)->get();
        foreach ($articles as $article) {
            remove_file('storage/blog/'.$article->image);
            $article->delete();
        }

        if (File::deleteDirectory(base_path('lang/' . $language->code))) {
            $language->delete();
            quick_alert_success(___('Deleted Successfully'));
            return back();
        }
    }

    /**
     * Reorder resources
     *
     * @param  \App\Models\PlanOption $planoption
     * @return \Illuminate\Http\Response
     */
    public function reorder(Request $request)
    {
        $position = $request->position;
        if (is_array($request->position)) {
            $count = 0;
            foreach($position as $id){
                $update = Language::where('id',$id)->update([
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
    }

    /**
     * Display translate page
     *
     * @param Request $request
     * @param $code
     * @return \Illuminate\Http\Response
     */
    public function translate(Request $request, $code)
    {
        $language = Language::where('code', $code)->firstOrFail();

        $lang = array_map(function ($file) {
            return pathinfo($file)['filename'];
        }, File::files(base_path('lang/' . $language->code)));

        $translates = $defaultLanguage = [];
        foreach ($lang as $l_file){
            $trans = [];
            $trans = array_merge($trans, trans($l_file, [], $language->code));

            $defaultTrans = [];
            $defaultTrans = array_merge($defaultTrans, trans($l_file, [], env('DEFAULT_LANGUAGE')));

            $translates[$l_file] = $trans;
            $defaultLanguage[$l_file] = $defaultTrans;
        }

        return view('admin.languages.translate', compact('translates', 'language', 'defaultLanguage'));
    }

    /**
     * Update translation
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function translateUpdate(Request $request, $id)
    {
        $language = Language::where('id', $id)->firstOrFail();

        foreach ($request->translates as $file => $trans) {

            $languageFile = base_path('lang/' . $language->code . '/' . $file . '.php');
            if (!file_exists($languageFile)) {
                quick_alert_error(___('Language file not exists'));
                return back();
            }

            $fileContent = "<?php \n return " . var_export($trans, true) . ";";
            File::put($languageFile, $fileContent);
        }

        quick_alert_success(___('Updated Successfully'));
        return back();
    }
}
