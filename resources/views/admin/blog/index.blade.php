@php
	$pagename='blog';
@endphp
@extends('admin.layout.app')
@section('page')
  
    <section class="content-header">
      <h1>
        Blog Management
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Blog Management</li>
         
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
            <div class="pull-right">
              <a href="{{ route('admin.blog.add') }}" class="btn btn-default" role="button">Add Blog</a>
            </div>  
            </div>
            @csrf
            <!-- /.box-header -->
            <div class="box-body">
              <input type="hidden" id="delete_blog_url" value="{{ route('admin.blog.delete') }}">
              <table id="example2" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Sub Title</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php $i=0; @endphp
                @foreach($blogData as $key=>$value)
                @php
                  $i++;

                @endphp
                <tr style="color:{{ $value->color_code }}" >
                  <td>{{ $i }}</td>
                  <td>{{ $value->title }}</td>
                  <td>{{ $value->sub_title }}</td>
                  <td>
                    <img src="{{ $value->image }}" width="50" />
                  </td>
                  <td> 
                    <a href="{{ route('admin.blog.edit',Crypt::encrypt($value->id)) }}" class="actionBtn" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a class="actionBtn deleteBlog" data="{{ Crypt::encrypt($value->id) }}" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Sub Title</th>
                    <th>Image</th>
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
<script type="text/javascript" src="{{ asset('admin/customjs/blog.js') }}" ></script>
@endsection