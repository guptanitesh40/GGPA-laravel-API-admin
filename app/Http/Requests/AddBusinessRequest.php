<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 
 */
class AddBusinessRequest extends FormRequest
{
	
	public function authorize() {
		return true;
	}	

	public function rules() {
		$rules = [
			"title" => "required",
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