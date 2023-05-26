<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Mail\SendForgotPasswordEmail;
use App\Mail\SendNewPassword;
use App\Models\User;
use App\Models\Blog;
use App\Models\Notification;
use Crypt;
use Auth;
use Mail;
use DB;

class AdminAuthController extends Controller
{
    //

    public function showLoginPage() {
        $user = Auth::user();
        if(isset($user) && $user->utype == 'ADM') {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }

    public function login(Request $request) {
        if(Auth::attempt(array('email' => $request->email, 'password'=> $request->password))) {
            if(Auth::user()->utype == 'ADM') {
                return redirect()->route('admin.dashboard');
            }
        }        
        return redirect()->route('admin.login')->with('error', 'Login email and password do not match with your database credentials');
    }


    public function showForgotPasswordPage() {

        $user = Auth::user();
        if(isset($user) && $user->utype == 'ADM') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.forgot-password');
    }

    public function dashboard(Request $request) {

        try {
            $data['total_users'] = User::where([['utype', '=','USR'],['parent_id','=',0]])->count();
            $data['total_blogs'] = Blog::count();;
            $data['total_members'] = User::where([['utype', '=','USR'],['parent_id','>',0]])->count();;
            $data['total_notifications'] = Notification::count();
            
            $toDoList=DB::table('to_do_list')->whereIn('active_flag',[0,1])->orderBy('order_by','ASC')->orderBy('due_time','ASC')->get();
            return view('admin.dashboard.index',compact('data','toDoList'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('admin.error'));
        }

    }

    public function showProfilePage(Request $request) {

        $admin = User::find(Auth::user()->id);

        return view('admin.profile.index', compact('admin'));

    }

    public function updateProfile(Request $request) {
        DB::beginTransaction();
        try {
            
            $admin = Auth::user();
            $admin = User::find($admin->id);
            $admin->first_name = $request->first_name;
            $admin->last_name = $request->last_name;
            if ($request->hasFile('profile_pic')) {
                $image = $request->file('profile_pic');
                $admin->profile_photo_path = uploadImage("uploads/images",$image);
            }
            if ($request->changePassword == 1 && !empty($request->new_password) && !empty($request->confirm_password)) {
                
                if ($request->new_password == $request->confirm_password) {

                    $admin->password = bcrypt($request->new_password); 
                    $admin->save();
                    DB::commit(); 
                    return redirect()->back()->with('msg',"User Profile and password updated successfully"); 
                }
                else {
                    DB::rollBack();
                    return redirect()->back()->with('error_msg',"Error occurred while changing password, Please try again later"); 
                }
            }
            DB::commit();
            $admin->save();
            return redirect()->back()->with('msg',"Profile updated successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('admin.error'));   
        }
    }

	public function sendResetLink(Request $request) {
		DB::beginTransaction();
		try {
			
			$email = $request->email;

			$user = User::select('id','name','email','code')->where([
				['email','=',$request->email]
			])->first();
			if (!$user) {
				return redirect()->back()->with('error_msg', "Reset link has been send to your email address");
			}

            $emailStatus = \Mail::to($user->email)
            ->send(new SendForgotPasswordEmail($user->name, $user->email, $user->code));
            
            if(!Mail::failures()) {
	        	DB::commit();
	        	return redirect()->back()->with('success',"Reset link has been send to your email address");
	        }
	        else {
	        	DB::rollBack();
	        	return redirect()->back()->with('error',"Error occurred, Please try again later");
	        }
		} catch (\Exception $e) {
			DB::rollBack();
			return redirect()->back()->with('error', 'Error occurred, Please try again later');		
		}
	}

    public function generatePassword(Request $request) {

		DB::beginTransaction();
		// try {
			$email = Crypt::decrypt($request->email);
			$code = Crypt::decrypt($request->code);
			
			$user = User::select('id','name','email','password','code')->where([
				[ 'email', '=', $email ],
				[ 'code', '=', $code ],
			])->first();

			if ($user) {
				
				$new_password = generateRandomString($length=8);	
		        $code = md5(generateRandomString($length=8));

                $emailStatus = \Mail::to($user->email)
                ->send(new SendNewPassword($user->name, $user->email, $new_password));
                
                if(!Mail::failures()) {
			        User::where('id',$user->id)->update([
			        	'password'=>bcrypt($new_password),
			        	'code'=>$code,
			        ]);	
			        DB::commit();
			        echo "New password has been send your email address";
		    	}
		    	else {
		    		DB::rollBack();
		    		echo "New password is cannot send, Please try again later";
		    	}
			}
			else {
				DB::rollBack();
				echo "Your password link has been expire please try again";
			}
			
		// } catch (\Exception $e) {
		// 	DB::rollBack();
		// 	return "Error occurred, Please try again later";			
		// }
	}


    public function pageNotFound() {

        return view('admin.layout.404');

    }

    public function error() {

        return view('admin.layout.500');

    }

    public function logout() {
        Auth::logout();
        return redirect()->back();
    }

}
