@extends('layout')

@section('body')

<section class="hero_500">
	 <span class="hero_500_send">
	    <h1>500</h1>
	    <h3>SORRY</h3>
	    <h4>The page was not found</h4>
	    <button class="gnrl_green_btn float-none" onclick="location.href='{{ route('index') }}'"  >GO TO HOMEPAGE</button>
	 </span>
</section>	
@endsection
