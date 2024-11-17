<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
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
                'id',
                'name',
                'email',
                'email_verified_at',
                'status'
            );

            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $users = User::where('id', 'like', '%' . $q . '%')
                    ->OrWhere('firstname', 'like', '%' . $q . '%')
                    ->OrWhere('lastname', 'like', '%' . $q . '%')
                    ->OrWhere('email', 'like', '%' . $q . '%')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $users = User::orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = User::count();
            foreach ($users as $row) {

                if ($row->email_verified_at)
                    $email_badge = '<span class="badge bg-success">'.___('Verified').'</span>';
                else
                    $email_badge = '<span class="badge bg-warning">'.___('Unverified').'</span>';

                if ($row->status)
                    $status_badge = '<span class="badge bg-success">'.___('Active').'</span>';
                else
                    $status_badge = '<span class="badge bg-danger">'.___('Banned').'</span>';

                $action_btn = "";

                $rows = array();
                $rows[] = '<td>'.$row->id.'</td>';
                $rows[] = '<td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2">
                                        <a href="'.route('admin.users.edit', $row->id).'">
                                            <img class="rounded-circle" alt="'.$row->username.'" src="'.asset('storage/users/'.$row->avatar).'" />
                                        </a>
                                    </div>
                                    <div>
                                        <a class="text-body fw-semibold text-truncate"
                                            href="'.route('admin.users.edit', $row->id).'">'.$row->name.'</a>
                                        <p class="text-muted mb-0">@'.$row->username.'</p>
                                    </div>
                                </div>
                            </td>';
                $rows[] = '<td><span class="text-truncate">'.$row->email.'</span></td>';
                $rows[] = '<td>'.$email_badge.'</td>';
                $rows[] = '<td>'.$status_badge.'</td>';
                $rows[] = '<td>'.datetime_formating($row->created_at).'</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                    <a href="'.route('admin.users.edit', $row->id).'" title="'.___('Edit').'" class="btn btn-icon btn-default me-1" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                    '.$action_btn.'
                                </div>
                            </td>';
                $rows[] = '<td>
                                <div class="checkbox">
                                <input type="checkbox" id="check_'.$row->id.'" value="'.$row->id.'" class="quick-check">
                                <label for="check_'.$row->id.'"><span class="checkbox-icon"></span></label>
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

        /* Mark users as viewed */
        $rows = User::where('is_viewed', 0)->get();
        foreach ($rows as $row) {
            $row->is_viewed = 1;
            $row->save();
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'email' => ['required', 'email', 'string', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'country' => ['required', 'integer', 'exists:countries,id'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        if ($request->has('avatar')) {
            $avatar = image_upload($request->file('avatar'), 'storage/users/', '150x150');
        } else {
            $avatar = "default.png";
        }

        $country = Country::find($request->country);

        $user = User::create([
            'user_type' => 'user',
            'name' => $request->firstname . ' ' . $request->lastname,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatar,
            'address' => ['address' => '', 'city' => '', 'state' => '', 'zip' => '', 'country' => $country->name],
            'plan_id' => 'free',
            'plan_settings' => config('settings.free_membership_plan')->settings,
        ]);
        if ($user) {
            $user->markEmailAsVerified();

            $result = array('success' => true, 'message' => ___('Created Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     */
    public function show(User $user)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'user_type' => ['required', 'string', 'max:5'],
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'string', 'max:100', 'unique:users,email,' . $user->id],
            'address' => ['nullable', 'max:255'],
            'city' => ['nullable', 'max:150'],
            'state' => ['nullable', 'max:150'],
            'zip' => ['nullable', 'max:100'],
            'country' => ['required', 'integer', 'exists:countries,id'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            quick_alert_error(implode('<br>', $errors));
            return back();
        }

        $avatar = $user->avatar;
        if ($request->has('avatar')) {
            if ($user->avatar == 'default.png') {
                $avatar = image_upload($request->file('avatar'), 'storage/users/', '150x150');
            } else {
                $avatar = image_upload($request->file('avatar'), 'storage/users/', '150x150', null, $user->avatar);
            }
        }

        $country = Country::find($request->country);

        $update = $user->update([
            'user_type' => $request->user_type,
            'avatar' => $avatar,
            'name' => $request->firstname . ' ' . $request->lastname,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'status' => $request->status,
            'address' => [
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'country' => $country->name,
            ],
        ]);
        if ($update) {
            $user->forceFill([
                'email_verified_at' => ($request->email_status) ? Carbon::now() : null,
            ])->save();

            quick_alert_success(___('Updated Successfully'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     */
    public function destroy(User $user)
    {
        abort(404);
    }

    /**
     * Remove the multiple resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        $users = User::whereIn('id',$ids)->get();
        foreach($users as $user){
            if ($user->avatar != "default.png") {
                remove_file('storage/users/'.$user->avatar);
            }

            if($user->posts){
                foreach ($user->posts as $post){
                    $post->delete();
                }
            }

            /* remove admin notifications of this user */
            $notifications = Notification::where('link', route('admin.users.edit', $user->id))->get();
            foreach ($notifications as $notification) {
                $notification->delete();
            }
        }
        User::whereIn('id',$ids)->delete();

        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }

    /**
     * Remove user's avatar
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function deleteAvatar(User $user)
    {
        $avatar = "default.png";
        if ($user->avatar != "default.png") {
            remove_file('storage/users/'.$user->avatar);
        }

        $update = $user->update([
            'avatar' => $avatar,
        ]);
        if ($update) {
            quick_alert_success(___('Removed Successfully'));
            return back();
        }
    }

    /**
     * Display password form
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function password(User $user)
    {
        return view('admin.users.password', compact('user'));
    }

    /**
     * Update password
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            quick_alert_error(implode('<br>', $errors));
            return back();
        }

        $update = $user->update([
            'password' => Hash::make($request->password),
        ]);
        if ($update) {
            quick_alert_success(___('Password changed successfully'));
            return back();
        }
    }

    /**
     * Send user email
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function sendMail(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
            'reply_to' => ['required', 'email'],
        ]);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            quick_alert_error(implode('<br>', $errors));
            return back();
        }

        try {
            $email = $user->email;
            $subject = $request->subject;
            $replyTo = $request->reply_to;
            $msg = $request->message;

            \Mail::send([], [], function ($message) use ($msg, $email, $subject, $replyTo) {
                $message->to($email)
                    ->replyTo($replyTo)
                    ->subject($subject)
                    ->html($msg);
            });
            quick_alert_success(___('Sent successfully'));
            return back();
        } catch (\Exception $e) {
            quick_alert_error(___('Error in sending email') . ' ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Display user logs
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function logs(User $user)
    {
        if (request()->ajax()) {
            $params = $columns = $order = $totalRecords = $data = array();
            $params = request();

            //define index of column
            $columns = array(
                'ip',
                'browser',
                'os',
                'location',
                'timezone',
                'latitude',
                'longitude'
            );

            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $logs = UserLog::where('user_id', $user->id)
                    ->where(function ($query) use ($q) {
                        return $query->where('ip', 'like', '%' . $q . '%')
                            ->orWhere('browser', 'like', '%' . $q . '%')
                            ->orWhere('os', 'like', '%' . $q . '%')
                            ->orWhere('location', 'like', '%' . $q . '%')
                            ->orWhere('timezone', 'like', '%' . $q . '%')
                            ->orWhere('latitude', 'like', '%' . $q . '%')
                            ->orWhere('longitude', 'like', '%' . $q . '%');
                    })
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $logs = UserLog::where('user_id', $user->id)
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = UserLog::where('user_id', $user->id)->count();
            foreach ($logs as $log) {
                $rows = array();
                $rows[] = '<td><a href="'.route('admin.users.logsbyip', $log->ip).'">'.$log->ip.'</a></td>';
                $rows[] = '<td>'.$log->browser.'</td>';
                $rows[] = '<td>'.$log->os.'</td>';
                $rows[] = '<td>'.$log->location.'</td>';
                $rows[] = '<td>'.$log->timezone.'</td>';
                $rows[] = '<td>'.$log->latitude.'</td>';
                $rows[] = '<td>'.$log->longitude.'</td>';
                $rows['DT_RowId'] = $log->id;
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

        return view('admin.users.userlogs', compact('user'));
    }

    /**
     * Display logs by ip
     *
     * @param $ip
     * @return \Illuminate\Http\Response
     */
    public function logsByIp($ip)
    {
        if (request()->ajax()) {
            $params = $columns = $order = $totalRecords = $data = array();
            $params = request();

            //define index of column
            $columns = array(
                'ip',
                'user',
                'browser',
                'os',
                'location',
                'timezone',
                'latitude',
                'longitude'
            );

            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $logs = UserLog::with('user')
                    ->where('ip', $ip)
                    ->where(function ($query) use ($q) {
                        return $query->orWhere('browser', 'like', '%' . $q . '%')
                            ->orWhere('os', 'like', '%' . $q . '%')
                            ->orWhere('location', 'like', '%' . $q . '%')
                            ->orWhere('timezone', 'like', '%' . $q . '%')
                            ->orWhere('latitude', 'like', '%' . $q . '%')
                            ->orWhere('longitude', 'like', '%' . $q . '%');
                    })
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $logs = UserLog::with('user')
                    ->where('ip', $ip)
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = UserLog::where('ip', $ip)->count();
            foreach ($logs as $log) {
                $rows = array();
                $rows[] = '<td>'.$log->ip.'</td>';
                $rows[] = '<td><a href="'.route('admin.users.edit', $log->user->id).'">'.$log->user->username.'</a></td>';
                $rows[] = '<td>'.$log->browser.'</td>';
                $rows[] = '<td>'.$log->os.'</td>';
                $rows[] = '<td>'.$log->location.'</td>';
                $rows[] = '<td>'.$log->timezone.'</td>';
                $rows[] = '<td>'.$log->latitude.'</td>';
                $rows[] = '<td>'.$log->longitude.'</td>';
                $rows['DT_RowId'] = $log->id;
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

        return view('admin.users.logs', compact('ip'));
    }
}
