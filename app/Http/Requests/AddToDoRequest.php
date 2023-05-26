<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * 
 */
class AddToDoRequest extends FormRequest
{
	
	public function authorize() {
		return true;
	}

	public function rules() {
		return [
			'to_do_text'=>'required',
			'due_time'=>'required',
		];
	}

	public function messages() {
		return  [
		];
	}

}

?>