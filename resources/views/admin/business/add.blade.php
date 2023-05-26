@php
	$pagename='business'
@endphp
@extends('admin.layout.app')
@section('page')

    <section class="content-header">
      <h1>
        {{ !empty($businessDetails) ? 'Edit' : 'Add' }} Business 
        <!-- <small>advanced tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="{{ route('admin.business') }}">Business Management</a></li>
         <li class="active">{{ !empty($businessDetails) ? 'Edit' : 'Add' }} Business</li>
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
	              <form role="form" id="add-business" method="post" enctype="multipart/form-data" action="{{ route('admin.business.add.store')}}"  >
	              	@csrf
	                <!-- text input -->
                    <div class="form-group">
                        <label>Title </label><span class="required">*</span>
                        <input type="text" class="form-control" placeholder="Title" name="title" >
                            @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                    </div>

                    <div class="form-group">
                        <label>Description </label><span class="required">*</span>
                        <textarea type="text" class="form-control" placeholder="Description" name="description" ></textarea>
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
  <script type="text/javascript" src="{{ asset('admin/customjs/business.js') }}" ></script>
  {!! JsValidator::formRequest('App\Http\Requests\AddBusinessRequest','#add-business'); !!}
<script >

$("#start_time").datetimepicker({
  format:'DD-MM-YYYY hh:MM',
});
$("#end_time").datetimepicker({
  format:'DD-MM-YYYY hh:MM',
});
</script>
@endsection