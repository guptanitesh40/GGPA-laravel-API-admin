<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * 
 */
class UpdateAdminRequest extends FormRequest
{
	
	public function authorize() {
		return true;
	}

	public function rules() {
		return [
			'name'=>'required',
			'email'=>'required|email',
			'profile_pic'=>'mimes:jpeg,jpg,bmp,png',
			'changePassword'=>'sometimes',
			'new_password'=>'required_with:changePassword,on',
			'confirm_password'=>'same:new_password',

		];
	}

	public function messages() {
		return  [
			'new_password.required_if'=>'This field is required'
		];
	}


}

?>