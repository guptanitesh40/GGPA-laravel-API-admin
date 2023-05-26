<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * 
 */
class AddUserRequest extends FormRequest
{
	
	public function authorize() {
		return true;
	}

	public function rules() {
		return [
			'first_name'=>'required',
			'last_name'=>'required',
			'mobile_number'=>'required',
			// 'password'=>'required',
			'password'=>'required_if:id,==,',
			'address'=>'required',
			'gender'=>'required',
			'city'=>'required',
			'state'=>'required',
			'education_type'=>'nullable',
			'job_type'=>'nullable',
			'profile_pic'=>'nullable',
			'additional_attachment'=>'nullable'
		];
	}

	public function messages() {
		return  [
		];
	}

}

?>