<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class MemberExport implements FromCollection
{

    public function headings():array{
        return [
            'Id',
            'First Name',
            'Last Name',
            'Gender',
            'Date of Birth',
            'Mobile Number',
            'State',
            'City',
            'Address',
            'Education Type',
            'Job Type',
            'Created at'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $allUser =  User::select(['id', 'first_name', 'last_name', 'gender', 'dob', 'mobile_number', 'state', 'city', 'address', 'education_type', 'job_type', 'created_at'])->where([['parent_id','<',1], ['utype','=','USR']])->get();
        
        foreach($allUser as $value) {
            $value->created_at = date('d-M-Y H:i:s', strtotime($value->created_at));
        }
        return $allUser;
    }
}
