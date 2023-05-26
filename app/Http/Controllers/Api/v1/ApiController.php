<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\Blog;
use App\Models\Business;
use App\Models\User;
use App\Models\Notification;
use App\Models\Otp;
use App\Exports\MemberExport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use PDF;

class ApiController extends Controller
{
    public function getState() {
        try {
            $data = State::get();
            return ['status' => true, 'message' => 'success', 'data' => $data];        
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function getCity(Request $request) {
        try {
            $whereArray = [];
            if($request->state_id) {
                $whereArray[] = ['state_id', '=', $request->state_id];
            }
            $data = City::where($whereArray)->get();
            return ['status' => true, 'message' => 'success', 'data' => $data];        
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function login(Request $request) {
        try {
            $user = null;
            if(Auth::attempt(array('mobile_number' => $request->mobile_number, 'password'=> $request->password, 'parent_id' => 0))) {
                $user = Auth::user();
                if($user->utype != 'USR') {
                    return ['status'=> false, 'message' => 'Invalid mobile number and password'];
                }
                addFCMUser($user->id, $request->fcm_id, $request->device_id, $request->type);
                $user['token'] = $user->createToken('authToken')->accessToken;
            }
            else {
                return ['status'=> false, 'message' => 'Invalid mobile number and password'];
            }
            return ['status' => true, 'message' => 'You have successfully logged in', 'data' => $user];        
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function getBlogs(Request $request) {
        try {
            $blogs = Blog::paginate(10);
            return ['status' => true,'message' => 'success', 'data' => $blogs];        
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }
    
    public function getBusiness(Request $request) {
        try {
            $business = Business::paginate(10);
            return ['status' => true,'message' => 'success', 'data' => $business];        
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function myProfile(Request $request) {
        try {
            $user = Auth::user();
            return ['status' => true,'message' => 'success', 'data' => $user];        
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function updateProfile(Request $request) {
        try {
            $objUser = Auth::user();
            $objUser->first_name = $request->first_name;
            $objUser->last_name = $request->last_name;
            $objUser->mobile_number = $request->mobile_number;
            $objUser->dob = $request->dob;
            $objUser->address = $request->address;
            $objUser->city = $request->city;
            $objUser->state = $request->state;
            $objUser->education_type = $request->education_type;
            $objUser->job_type = $request->job_type;
            $objUser->gender = $request->gender;
    
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

            return ['status' => true,'message' => 'success', 'data' => $objUser];        
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }


    public function addMember(Request $request) {
        try {
            $user = Auth::user();
            $objUser = new User();
            $objUser->parent_id = $user->id;
            $objUser->first_name = $request->first_name;
            $objUser->last_name = $request->last_name;
            $objUser->mobile_number = $request->mobile_number;
            $objUser->dob = $request->dob;
            $objUser->address = $request->address;
            $objUser->city = $request->city;
            $objUser->state = $request->state;
            $objUser->education_type = $request->education_type;
            $objUser->job_type = $request->job_type;
            $objUser->gender = $request->gender;
            $objUser->relation = $request->relation;
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
            return ['status' => true,'message' => 'Member added', 'data' => $objUser];        
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function getSubMembers(Request $request) {
        try {
            $user = Auth::user();
            $members = User::where([['parent_id', '=', $user->id], ['utype','=','USR']])->orderBy('created_at', 'DESC')->get();
            return ['status' => true,'message' => 'Get Sub members', 'data' => $members];        
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function getAllMembersWithSubMembers(Request $request) {
        try {
            $whereArray = [];
            $search = $request->search ? $request->search : '';

            $members = User::where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%'.$search.'%')
                      ->orWhere('last_name', 'like', '%'.$search.'%')
                      ->orWhere('city', 'like', '%'.$search.'%');
            })->where([['utype','=','USR']])
            ->orderBy('created_at', 'DESC')
            ->get();
            $data=[];
            $members = $members->jsonserialize();
            foreach($members as $value) {
                if(empty($value['parent_id'])) {
                    $value['members'] = [];
                    $data[$value['id']] = $value;
                }
            }
            foreach($members as $value) {
                if(!empty($value['parent_id'])) {
                    $data[$value['parent_id']]['members'][] = $value;
                }
            }
            $newArray = [];
            foreach($data as $key => $value) {
                $newArray[] = $data[$key];
            }
            return ['status' => true,'message' => 'Get all sub members', 'data' => $newArray];
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function getNotificaion(Request $request) {
        try {
            $user = Auth::user();
            $notifications = Notification::select(['notifications.id as notification_id','notifications.title as notification_title', 'notifications.description as notification_description', 'notifications.*', 'blog.*', 'users.*'])
            ->leftJoin('blog', 'blog.id', '=', 'notifications.blog_id')
            ->leftJoin('users', 'users.id', '=', 'notifications.user_id')
            ->orderBy('notifications.created_at', 'DESC')->paginate(10);

            foreach($notifications as $value) {
                if($value->image) $value->image = asset('blog-images/'.$value->image);
                if($value->profile_pic) $value->profile_pic = asset('uploads/images/'.$value->profile_pic);
            }

            return ['status' => true,'message' => 'Get all notifications', 'data' => $notifications];        
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function changePassword(Request $request) {
        try {
            $user = Auth::user();
            $user->password = bcrypt($request->password);
            $user->save();
            return ['status' => true, 'message' => 'Password changed successfully'];        
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function forgotPassword(Request $request) {
        try {
            $user = User::where([['mobile_number', '=', $request->mobile_number]])->first();
            if(!$user) {
                return ['status'=> false, 'message' => 'Mobile number not found please contact admin to register your self'];
            }
            $otp = generateRandomString(4, true);
            $data = sendSMS($request->mobile_number, $otp." is your OTP for GGPA app. Regards - VPLPTL");
            if($data->ErrorCode != "000") {
                return ['status'=> false, 'message' => 'Sending SMS is failed', 'data' => $data];
            }
            $objOtp = new Otp();
            $objOtp->mobile_number = $request->mobile_number;
            $objOtp->otp = $otp;
            $objOtp->type = 'forgot_password';
            $objOtp->save();
            return ['status' => true, 'message' => 'OTP send to your mobile number'];        
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function resetPassword(Request $request) {
        try {
            $user = User::where([['mobile_number', '=', $request->mobile_number]])->first();
            if(!$user) {
                return ['status'=> false, 'message' => 'Mobile number not found please contact admin to register your self'];
            }
            $otp = Otp::where([['mobile_number','=', $request->mobile_number],['type','=', 'forgot_password']])->orderBy('created_at', 'DESC')->first();
            if(!$otp) {
                return ['status'=> false, 'message' => 'OTP is not valid'];
            }
            if($otp->otp != $request->otp) {
                return ['status'=> false, 'message' => 'OTP is not valid'];
            }
            $user->password = bcrypt($request->password);
            $user->save();
            $otp->delete();
            return ['status'=> true, 'message' => 'Password reset successfully'];   
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function allMembersExcel(Request $request) {
        try {
            $data = Excel::store(new MemberExport, 'members.xlsx','excel');
            if($data) {
                return ['status'=> true, 'message' => 'Excel generated successfully', 'data' => ['downloadUrl' => asset('uploads/excel/members.xlsx')]];
            }
            return ['status'=> false, 'message' => 'Error occurred in generating excel'];
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

    public function generatePDFProfile(Request $request) {
        try {
            $user = User::find($request->user_id);
            $memberData = User::where([['parent_id', '=', $user->id]])->get();
            $fileName = cleanString($user->first_name." ".$user->last_name).'.pdf';
            $filePath = 'uploads/pdf/'.$fileName;
            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ])->loadView('pdf.member-profile', compact('user', 'memberData'))->save($filePath);

            return ['status'=> true, 'message' => 'PDF generated successfully', 'data' => [ 'downloadUrl' => asset($filePath) ]];
        }catch(\Throwable $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }
    
}
