<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\Notification;
use App\Jobs\SendPushNotificationJob;

class UserController extends Controller
{
    public function index() {
        $userData = User::where([['utype', '=', 'USR'], ['parent_id', '<', 1]])->get();
        return view('admin.user.index', compact('userData'));
    }

    public function add() {
        $states = State::get();
        $cities = City::get();
        return view('admin.user.add', compact('states', 'cities'));
    }

    public function store(Request $request) {
        $existing = false;
        if($request->id) {
            $objUser = User::find(decrypt($request->id));
            $existing = true;
        }
        else {
            if(User::where(['mobile_number'=> $request->mobile_number])->first()) {
                return redirect()->back()->with('error_msg', 'This mobile number already exists');
            }

            $objUser = new User();
        }

        $objUser->parent_id = 0;
        $objUser->first_name = $request->first_name;
        $objUser->last_name = $request->last_name;
        $objUser->mobile_number = $request->mobile_number;
        $objUser->dob = $request->dob;
        if($request->password) {
            $objUser->password = bcrypt($request->password);
        }
        $objUser->address = $request->address;
        $objUser->city = $request->city;
        $objUser->state = $request->state;
        $objUser->education_type = $request->education_type;
        $objUser->job_type = $request->job_type;
        $objUser->gender = $request->gender;
        $objUser->utype = 'USR';

        if ($request->hasFile('profile_pic')) {
            $profile_pic = $request->file('profile_pic');
            $objUser->profile_pic = time() . md5(rand(100,999)) . '.' . $profile_pic->getClientOriginalExtension();
            $profile_pic->move('uploads/images/', $objUser->profile_pic);
        }

        if ($request->hasFile('additional_attachment')) {
            $additional_attachment = $request->file('additional_attachment');
            $objUser->additional_attachment = time() . md5(rand(100,999)) . '.' . $additional_attachment->getClientOriginalExtension();
            $additional_attachment->move('uploads/images/', $objUser->additional_attachment);
        }

        $objUser->save();
        if($existing == false) {
            $description = $objUser->first_name . " is new member of GGPA you can view this detail by clicking here";
            $title = "New Member has been added";
            addNotification($objUser->id, 0, $title, $description, "new_user");
            dispatch(new SendPushNotificationJob($title, $description, 'user'))->delay(now()->addSeconds(2));
        }

        $message = 'User added successfully';
        if($request->id) $message = 'User updated successfully';
        return redirect()->back()->with('success_msg', $message);
    }

    public function edit(Request $request) {
        $userDetail = User::find(decrypt($request->id));
        $states = State::get();
        $cities = City::get();
        return view('admin.user.add', compact('userDetail', 'states', 'cities'));
    }

    public function delete(Request $request) {
        User::find(decrypt($request->id))->delete();
        return ['success' => 1];
    }
}
