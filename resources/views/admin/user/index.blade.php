@php
	$pagename='user';
@endphp
@extends('admin.layout.app')
@section('page')
  
    <section class="content-header">
      <h1>
        User Management
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">User Management</li>
         
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
            @if(session('success_msg'))
                  <div class="alert alert-success">
                  <strong></strong>{{ session('success_msg') }} 
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
            @endif

            @if(session('error_msg'))
                  <div class="alert alert-danger">
                  <strong></strong>{{ session('error_msg') }} 
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
            @endif
            <div class="pull-right">
              <a href="{{ route('admin.user.add') }}" class="btn btn-default" role="button">Add User</a>
            </div>  
            </div>
            @csrf
            <!-- /.box-header -->
            <div class="box-body">
              <input type="hidden" id="delete_user_url" value="{{ route('admin.user.delete') }}">
              <table id="example2" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Education Type</th>
                  <th>Job Type</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php $i=0; @endphp
                @foreach($userData as $key=>$value)
                @php
                  $i++;

                @endphp
                <tr style="color:{{ $value->color_code }}" >
                  <td>{{ $i }}</td>
                  <td>{{ $value->first_name }}</td>
                  <td>{{ $value->last_name }}</td>
                  <td>{!! wordwrap($value->address, 30) !!}</td>
                  <td>{{ $value->city }}</td>
                  <td>{{ $value->state }}</td>
                  <td>{{ $value->education_type }}</td>
                  <td>{{ $value->jon_type }}</td>
                  <td> 
                    <a href="{{ route('admin.user.edit',Crypt::encrypt($value->id)) }}" class="actionBtn" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a class="actionBtn deleteUser" data="{{ Crypt::encrypt($value->id) }}" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Education Type</th>
                  <th>Job Type</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection
@section('js_bottom')
<script type="text/javascript" src="{{ asset('admin/customjs/user.js') }}" ></script>
@endsection