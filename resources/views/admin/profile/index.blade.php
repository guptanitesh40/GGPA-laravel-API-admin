@php
	$pagename='profile';
@endphp
@extends('admin.layout.app')
@section('page')
	
    <section class="content-header">
      <h1>
        Update Profile
        <!-- <small>advanced tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Update Profile</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
	            <!-- /.box-header -->
	            <div class="box-body">
	            	<span class="required">Note: Fields marked with * are required</span>
		            @if(session('msg'))
		                  <div class="alert alert-success">
		                  <strong></strong>{{ session('msg') }} 
		                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                </div>
		            @endif  
		            @if(session('error_msg'))
		                  <div class="alert alert-danger">
		                  <strong></strong>{{ session('error_msg') }} 
		                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                </div>
		            @endif  
	              <form role="form" id="update-admin" method="post" enctype="multipart/form-data" action="{{ route('admin.profile.update')}}" >
	              	@csrf
	                <!-- text input -->
	                <div class="form-group">
	                  <label>Name</label><span class="required">*</span>
	                  <input type="text" class="form-control" placeholder="Enter First Name" name="first_name" value="{{ $admin->first_name }}">
						@if ($errors->has('first_name'))
						<span class="text-danger">{{ $errors->first('first_name') }}</span>
						@endif
	                </div>

	                <div class="form-group">
						<label>Last Name</label><span class="required">*</span>
						<input type="text" class="form-control" placeholder="Enter Last Name" name="last_name" value="{{ $admin->last_name }}">
						  @if ($errors->has('last_name'))
						  <span class="text-danger">{{ $errors->first('last_name') }}</span>
						  @endif
					  </div>
  
	                <!-- textarea -->
	                <div class="form-group">
	                  <label>Email</label><span class="required">*</span>
	                  <input type="email" class="form-control" placeholder="Enter Email" name="email" value="{{ $admin->email }}" readonly="readonly">
			        @if ($errors->has('email'))
			          <span class="text-danger">{{ $errors->first('email') }}</span>
			        @endif
	                </div>
	                <div class="form-group">
	                  <label>Profile</label><span class="required">*</span>
	                  <input type="file" class="form-control" name="profile_pic" accept="image/*" id="upload-image">
			        @if ($errors->has('profile_pic'))
			          <span class="text-danger">{{ $errors->first('profile_pic') }}</span>
			        @endif
	                </div>
					@if($admin->profile_photo_path)
						<div class="showImage">
							<img src="{{ asset('uploads/images/'.$admin->profile_photo_path) }}" width="50" id="show-image">
						</div>
					@endif
	                <div class="changePasswordCheckbox form-group">
	                	<input type="checkbox" name="changePassword" value="1" class="minimal changePassword" id="changePassword" checked> Change Password
	                </div>
	                <div class="changePasswordDiv"  >
		                <div class="form-group">
		                  <label>New Password</label><span class="required">*</span>
		                  <input type="password" class="form-control" placeholder="Enter Password" name="new_password" id="new_password" >
				        @if ($errors->has('new_password'))
				          <span class="text-danger">{{ $errors->first('new_password') }}</span>
				        @endif
		                </div>
		                <div class="form-group">
		                  <label>Confirm Password</label><span class="required">*</span>
		                  <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password" >
				        @if ($errors->has('confirm_password'))
				          <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
				        @endif
		                </div>
	                </div>
	                <button type="submit" class="btn btn-primary">Save</button>
	              </form>
	            </div>
	          
          </div>
        </div>
   	  </div>    	
   	</section>

@endsection

@section('js_bottom')
  <script type="text/javascript" src="{{ asset('js/profile.js') }}" ></script>
	{!! JsValidator::formRequest('App\Http\Requests\UpdateAdminRequest','#update-admin'); !!}
@endsection