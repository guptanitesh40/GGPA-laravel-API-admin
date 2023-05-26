@php
	$pagename='user'
@endphp
@extends('admin.layout.app')
@section('page')

    <section class="content-header">
      <h1>
        {{ !empty($userDetail) ? 'Edit' : 'Add' }} User 
        <!-- <small>advanced tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="{{ route('admin.user') }}">User  Management</a></li>
         <li class="active">{{ !empty($userDetail) ? 'Edit' : 'Add' }} User </li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
	            <!-- /.box-header -->

	            <div class="box-body">

                    @if(session('error_msg'))
                        <div class="alert alert-error">
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
	              <form role="form" id="add-user" method="post" enctype="multipart/form-data" action="{{ route('admin.user.add.store')}}"  >
	              	@csrf
                  @if(isset($userDetail)) 
                    <input type="hidden" name="id" value="{{ encrypt($userDetail->id) }}" > 
                  @endif
                    <div class="form-group">
                      <label>First Name </label><span class="required">*</span>
                      <input type="text" class="form-control" placeholder="First Name " name="first_name" value="{{ isset($userDetail) ? $userDetail->first_name : '' }}" >
                        @if ($errors->has('first_name'))
                          <span class="text-danger">{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                      <label>Last Name </label><span class="required">*</span>
                      <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ isset($userDetail) ? $userDetail->last_name : '' }}" >
                        @if ($errors->has('last_name'))
                          <span class="text-danger">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                      <label>Gender </label><span class="required">*</span>
                        <select  class="form-control" name="gender" >
                          <option value="">----Select----</option>
                          <option value="male" @if(isset($userDetail) && $userDetail->gender == 'male') selected @endif >Male</option>
                          <option value="female" @if(isset($userDetail) && $userDetail->gender == 'female') selected @endif >Female</option>
                        </select>
                        @if ($errors->has('last_name'))
                          <span class="text-danger">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                      <label>Date of Birth </label><span class="required">*</span>
                      <input type="text" class="form-control" placeholder="Date of Birth" name="dob" id="dob" value="{{ isset($userDetail) ? $userDetail->dob : '' }}" >
                        @if ($errors->has('dob'))
                          <span class="text-danger">{{ $errors->first('dob') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                      <label>Mobile Number </label><span class="required">*</span>
                      <input type="text" class="form-control" placeholder="Mobile Number" name="mobile_number" value="{{ isset($userDetail) ? $userDetail->mobile_number : '' }}" >
                        @if ($errors->has('mobile_number'))
                          <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                      <label>Password  
                        @if(empty($userDetail))
                          </label><span class="required">*</span>
                        @else
                          </label><span class="required"> (Only enter if you want to change password)</span>
                        @endif
    
                    <input type="text" class="form-control" placeholder="Password" name="password" >
                        @if ($errors->has('password'))
                          <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                      <label>State </label><span class="required">*</span>
                      <select  class="form-control" name="state" >
                          <option value="">----Select----</option>
                          @foreach($states as $value)
                            <option value="{{ $value->name }}" @if(isset($userDetail) && $userDetail->state == $value->name) selected @endif >{{ $value->name }}</option>
                          @endforeach
                        </select>
                        @if ($errors->has('state'))
                          <span class="text-danger">{{ $errors->first('state') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                      <label>City </label><span class="required">*</span>
                      <select  class="form-control" name="city" >
                        <option value="">----Select----</option>
                        @foreach($cities as $value)
                          <option value="{{ $value->name }}" @if(isset($userDetail) && $userDetail->city == $value->name) selected @endif >{{ $value->name }}</option>
                        @endforeach
                      </select>
                        @if ($errors->has('city'))
                          <span class="text-danger">{{ $errors->first('city') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                      <label>Address</label><span class="required">*</span>
                      <div>
                        <textarea type="input" name="address" class="form-control"  >{{ isset($userDetail) ? $userDetail->address : '' }}</textarea>
                      </div>
                      @if ($errors->has('address'))
                        <span class="text-danger">{{ $errors->first('address') }}</span>
                      @endif
                    </div>

                    <div class="form-group">
                      <label>Education Type </label>
                      <input type="text" class="form-control" placeholder="Education Type" name="education_type" value="{{ isset($userDetail) ? $userDetail->education_type : '' }}" >
                        @if ($errors->has('education_type'))
                          <span class="text-danger">{{ $errors->first('education_type') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                      <label>Job Type </label>
                      <input type="text" class="form-control" placeholder="Job Type" name="job_type" value="{{ isset($userDetail) ? $userDetail->job_type : '' }}" >
                        @if ($errors->has('job_type'))
                          <span class="text-danger">{{ $errors->first('job_type') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                      <label>Profile Pic </label>
                      <input type="file" class="form-control" placeholder="Profile Pic" name="profile_pic" >
                        @if ($errors->has('profile_pic'))
                          <span class="text-danger">{{ $errors->first('profile_pic') }}</span>
                        @endif
                        @if(isset($userDetail) && $userDetail->profile_pic)
                            <img class="showUploadedImage" src="{{ $userDetail->profile_pic }}" width="50"  />
                        @endif
                    </div>

                    <div class="form-group">
                      <label>Additional Attachment </label>
                      <input type="file" class="form-control" placeholder="Profile Pic" name="additional_attachment" >
                        @if ($errors->has('additional_attachment'))
                          <span class="text-danger">{{ $errors->first('additional_attachment') }}</span>
                        @endif
                        @if(isset($userDetail) && $userDetail->additional_attachment)
                            <img class="showUploadedImage" src="{{ $userDetail->additional_attachment }}" width="50"  />
                        @endif
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
  <script type="text/javascript" src="{{ asset('admin/customjs/user.js') }}" ></script>
  {!! JsValidator::formRequest('App\Http\Requests\AddUserRequest','#add-user'); !!}
<script>
  $("#dob").datetimepicker({
    format:'DD-MM-YYYY',
  });
</script>
@endsection