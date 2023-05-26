<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog;
use App\Models\BlogContent;
use App\Jobs\SendPushNotificationJob;

class BlogController extends Controller
{
    //

    public function index() {

        $blogData = Blog::get();
        return view('admin.blog.index', compact('blogData'));

    }

    public function add() {

        return view('admin.blog.add');
    }

    public function store(Request $request) {
        try {
            $existing = false;
            if($request->id) {
                $objBlog = Blog::find($request->id);
                $existing = true;
            }
            else {
                $objBlog = new Blog();
            }

            if(empty($request->start_time)) $request->start_time = '';
            if(empty($request->end_time)) $request->end_time = '';

            $objBlog->title = $request->title;
            $objBlog->sub_title = $request->sub_title;
            $objBlog->description = $request->description;
            $objBlog->start_time = $request->start_time;
            $objBlog->end_time = $request->end_time;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $objBlog->image = time() . md5(rand(100,999)) . '.' . $image->getClientOriginalExtension();
                $image->move('blog-images', $objBlog->image);
            }

            $objBlog->save();

            if($existing == false) {
                $title = "We have a new update for you";
                $description = $objBlog->title . " is new update you can view this detail by clicking here";
                addNotification(0, $objBlog->id, $title, $description, "new_blog");
                dispatch(new SendPushNotificationJob($title, $description, 'blog'))->delay(now()->addSeconds(2));
            }

            $message = 'Blog added successfully';
            if($request->id) $message = 'Blog updated successfully';
            return redirect()->back()->with('success_msg', $message);            
        }catch(\Throwable $e) {
            return redirect()->back()->with('error_msg', $e->getMessage());            
        }

    }

    public function edit(Request $request) {
        $blogDetails = Blog::find(decrypt($request->id));
        return view('admin.blog.edit', compact('blogDetails'));
    }

    public function delete(Request $request) {
        Blog::find(decrypt($request->id))->delete();
        return ['success' => 1];
    }
}
