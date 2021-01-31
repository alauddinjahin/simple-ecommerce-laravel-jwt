@extends('backend.layouts.master')

@section('title', '404-page')

@push('css') 
<style>
	.centerize{
		position:absolute;
		top:0;
		left:0;
		transform:translate(50%,50%);
	}
</style>
@endpush


@section('content')
<!-- ===================================== -->
<div class="container text-center mt-5" style="position: relative">
	<div class="centerize">
		<div class="logo-404">
			<a href="javascript:void(0)">
				<img width="200" class=" img-responsive" src="{{asset('ui/backend/dist/assets/images/error.svg')}}" alt="404-Page" />
			</a>
		</div>
		<div class="content-404">
			<h1><b>OPPS!</b> We Couldn’t Find this Page</h1>
			<p>Uh... So it looks like you brock something. The page you are looking for has up and Vanished.</p>
			<button class="btn btn-lg btn-danger" onclick="javascript:window.history.back()">Bring me Back</button>
		</div>
	</div>
</div>

@endsection

@push('js')

@endpush