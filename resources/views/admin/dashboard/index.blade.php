@php
  $pagename='dashboard';
@endphp
@extends('admin.layout.app')
@section('page')

    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Item</h4>
          </div>
          <form method="post" id="add-to-do" action="{{ route('admin.todo.add') }}">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <div class="form-group">
                  <label for="to_do_text">To Do Task</label>
                  <input type="text" class="form-control" id="to_do_text" name="to_do_text" placeholder="Your task">
                </div>
                <label for="due_time">Due Time</label>
                <input type="hidden" name="id" id="id" value="">
                  <div class="form-group">
                      <div class='input-group datetimepicker' >
                          <input type='text' class="form-control" id="due_time" placeholder="Due Time" name="due_time" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                  </div>
              </div>
              <button type="submit" class="btn btn-primary" >Save</button>
              <div class="pull-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>

    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-book"></i></span>
            
            <div class="info-box-content">
              <span class="info-box-text">TOTAL BLOGS</span>
              <span class="info-box-number">{{ $data['total_blogs'] }}<small></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL USERS</span>
              <span class="info-box-number">{{ $data['total_users'] }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL MEMBERS</span>
              <span class="info-box-text"></span>
              <span class="info-box-number">{{ $data['total_members'] }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-bell"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL NOTIFICATIONS</span>
              <span class="info-box-text"></span>
              <span class="info-box-number">{{ $data['total_notifications'] }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>

      <div class="row">
        @csrf
        <input type="hidden" id="change_order_url" value="{{ route('change.item.controller') }}">
      </div>

            @if(session('msg'))
                  <div class="alert alert-success">
                  <strong></strong>{{ session('msg') }} 
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
            @endif 
            @if(session('error_msg'))
                  <div class="alert alert-success">
                  <strong></strong>{{ session('error_msg') }} 
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
            @endif 

          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">To Do List</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <input type="hidden" id="change_task_status_url" value="{{ route('admin.change.todo.status') }}">
              @csrf
              <ul class="todo-list connectedSortable" id="sortable">
                @foreach($toDoList as $key => $value)
                @php
                  $dealLineTime = strtotime($value->due_time);
                  $value->remain_time = time_elapsed_string($dealLineTime,$withoutAgo=true);
                  $time = $dealLineTime - time();
                @endphp
                  <li id="{{ 'item-'.$value->id }}" @if($value->active_flag==0) class="done" @endif >
                    <span class="handle">
                          <i class="fa fa-ellipsis-v"></i>
                          <i class="fa fa-ellipsis-v"></i>
                        </span>
                    <input type="hidden" id="to_do_id_old" value="{{ Crypt::encrypt($value->id) }}">
                    <input type="hidden" id="due_time_old" value="{{ date('d-m-Y h:i A', strtotime($value->due_time)) }}">
                    <input type="checkbox" value="{{ Crypt::encrypt($value->id) }}" @if($value->active_flag==0) checked @endif>
                    <span class="text toDoText">{{ $value->to_do_text }}</span>
                    @if($time<3600)
                      <small class="label label-danger"><i class="fa fa-clock-o"></i> {{ $value->remain_time }}</small>
                    @endif
                    @if($time>3600 && $time<86400)
                      <small class="label label-info"><i class="fa fa-clock-o"></i> {{ $value->remain_time }}</small>
                    @endif
                    @if($time>86400 && $time<604800)
                      <small class="label label-warning"><i class="fa fa-clock-o"></i> {{ $value->remain_time }}</small>
                    @endif
                    @if($time>604800 && $time<2592000)
                        <small class="label label-success"><i class="fa fa-clock-o"></i> {{ $value->remain_time }}</small>
                    @endif
                    @if($time>2592000)
                      <small class="label label-primary"><i class="fa fa-clock-o"></i> {{ $value->remain_time }}</small>
                    @endif
                    

                    <div class="tools">
                      <i class="fa fa-edit editFromToDoList"></i>
                      <i class="fa fa-trash-o deleteFromToDoList"></i>
                    </div>
                  </li>
                  @endforeach
              </ul>
            </div>
            <div class="box-footer clearfix no-border">
              <button type="button" class="btn btn-default pull-right openModelBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add item</button>
            </div>
          </div>

    </section>

@endsection
@section('js_bottom')
  <script type="text/javascript" src="{{ asset('admin/js/dashboard.js') }}" ></script>
  {!! JsValidator::formRequest('App\Http\Requests\AddToDoRequest','#add-to-do'); !!}

@endsection