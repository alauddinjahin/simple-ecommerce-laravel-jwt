@extends('backend.layouts.master')

@section('title', '403-page')

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
		<div class="logo-403">
			<div class="error-text-box ">
				<svg viewBox="0 0 600 200"  style="width: 400px;">
					<!-- Symbol-->
					<symbol id="s-text">
						<text text-anchor="middle" x="50%" y="50%" dy=".35em">403!</text>
					</symbol>
					<!-- Duplicate symbols-->
					<use class="text" xlink:href="#s-text"></use>
					<use class="text" xlink:href="#s-text"></use>
					<use class="text" xlink:href="#s-text"></use>
					<use class="text" xlink:href="#s-text"></use>
					<use class="text" xlink:href="#s-text"></use>
				</svg>
			</div>
		</div>
		<div class="content-404">
			<h1><b>OPPS!</b> You are Unauthorized.</h1>
			<h4 class="text-muted">You don't have permission to view this page!</h4>
			<button class="btn btn-lg btn-danger" onclick="javascript:window.history.back()">Bring me Back</button>
		</div>
	</div>
</div>

@endsection

@push('js')

@endpush