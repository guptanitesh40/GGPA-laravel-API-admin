<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Business;
use App\Jobs\SendPushNotificationJob;

class BusinessController extends Controller
{
    //

    public function index() {

        $businessData = Business::get();
        return view('admin.business.index', compact('businessData'));

    }

    public function add() {

        return view('admin.business.add');
    }

    public function store(Request $request) {
        try {
            $existing = false;
            if($request->id) {
                $objBusiness = Business::find($request->id);
                $existing = true;
            }
            else {
                $objBusiness = new Business();
            }

            if(empty($request->title)) $request->title = '';
            if(empty($request->description)) $request->description = '';

            $objBusiness->title = $request->title;
            $objBusiness->description = $request->description;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $objBusiness->image = time() . md5(rand(100,999)) . '.' . $image->getClientOriginalExtension();
                $image->move('business-images', $objBusiness->image);
            }

            $objBusiness->save();


            $message = 'Business added successfully';
            if($request->id) $message = 'Business updated successfully';
            return redirect()->back()->with('success_msg', $message);            
        }catch(\Throwable $e) {
            return redirect()->back()->with('error_msg', $e->getMessage());            
        }

    }

    public function edit(Request $request) {
        $businessDetails = Business::find(decrypt($request->id));
        return view('admin.business.edit', compact('businessDetails'));
    }

    public function delete(Request $request) {
        Business::find(decrypt($request->id))->delete();
        return ['success' => 1];
    }
}
