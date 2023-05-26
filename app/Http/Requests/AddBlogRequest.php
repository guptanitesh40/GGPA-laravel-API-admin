<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 
 */
class AddBlogRequest extends FormRequest
{
	
	public function authorize() {
		return true;
	}	

	public function rules() {
		$rules = [
			"title" => "required",
			"sub_title" => "required",
			"description" => "required"		
		];

		return $rules;
	}

	public function messages () {
		return [

		];
	}

}

?>