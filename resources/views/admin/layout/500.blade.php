@php
	$pagename='500';
@endphp
@extends('admin.layout.app')
@section('page')
	
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-red"> 500</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Error occurred.</h3>

          <p>
            We could not perform the action you were looking for.
            Meanwhile, you may <a href="{{ route('admin.dashboard') }}">return to dashboard</a>.
          </p>

          <form class="search-form">
            <div class="input-group">

              <div class="input-group-btn">
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>

@endsection