@php
	$pagename='blog'
@endphp
@extends('admin.layout.app')
@section('page')

    <section class="content-header">
      <h1>
        {{ !empty($blogDetails) ? 'Edit' : 'Add' }} Blog 
        <!-- <small>advanced tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="{{ route('admin.blog') }}">Blog Management</a></li>
         <li class="active">{{ !empty($blogDetails) ? 'Edit' : 'Add' }} Blog</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
	            <!-- /.box-header -->

	            <div class="box-body">

                @if(session('error_msg'))
                      <div class="alert alert-danger">
                      <strong></strong>{{ session('error_msg') }} 
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>
                @endif

                @if(session('success_msg'))
                      <div class="alert alert-success">
                      <strong></strong>{{ session('success_msg') }} 
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>
                @endif

	            	<span class="required">Note: Fields marked with * are required</span>
	              <form role="form" id="add-blog" method="post" enctype="multipart/form-data" action="{{ route('admin.blog.add.store')}}"  >
	              	@csrf
                  <input type="hidden" name="delete_content_id" id="delete_content_id" value="">
                  <input type="hidden" name="id" value="{{ $blogDetails->id }}">
                  <div class="form-group">
                        <label>Title </label><span class="required">*</span>
                        <input type="text" class="form-control" placeholder="Title" name="title" value="{{ $blogDetails->title }}" >
                            @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                    </div>

                    <div class="form-group">
                        <label>Sub Title </label><span class="required">*</span>
                        <input type="text" class="form-control" placeholder="Sub Title" name="sub_title" value="{{ $blogDetails->sub_title }}" >
                            @if ($errors->has('sub_title'))
                            <span class="text-danger">{{ $errors->first('sub_title') }}</span>
                            @endif
                    </div>

                    <div class="form-group date">
                      <label>Start Time </label>
                      <input type="text" class="form-control" placeholder="Start Time" name="start_time" id="start_time" value="{{ $blogDetails->start_time }}" >
                          @if ($errors->has('start_time'))
                          <span class="text-danger">{{ $errors->first('start_time') }}</span>
                          @endif
                    </div>

                    <div class="form-group date">
                      <label>End Time </label>
                      <input type="text" class="form-control" placeholder="End Time" name="end_time" id="end_time" value="{{ $blogDetails->end_time }}" >
                          @if ($errors->has('end_time'))
                          <span class="text-danger">{{ $errors->first('end_time') }}</span>
                          @endif
                    </div>

                    <div class="form-group">
                        <label>Description </label><span class="required">*</span>
                        <textarea type="text" class="form-control" placeholder="Description" name="description" >{{ $blogDetails->description }}</textarea>
                            @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                    </div>

                    <div class="form-group">
                        <label>Image </label>
                        <input type="file" class="form-control" name="image" >
                        @if ($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                        @if($blogDetails->image)
                            <img class="showUploadedImage" src="{{ asset('blog-images/' . $blogDetails->image) }}" width="50"  />
                        @endif
                    </div>

                  <button type="submit" class="btn btn-primary float-left w-100 ">Save</button>
	              </form>
	            </div>      
          </div>
        </div>
   	  </div>    	
   	</section>	
@endsection
@section('js_bottom')
  <script type="text/javascript" src="{{ asset('admin/customjs/blog.js') }}" ></script>
  {!! JsValidator::formRequest('App\Http\Requests\AddBlogRequest','#add-blog'); !!}
<script >
$("#start_time").datetimepicker({
  format:'YYYY-MM-DD hh:MM',
});
$("#end_time").datetimepicker({
  format:'YYYY-MM-DD hh:MM',
});
    
</script>
@endsection