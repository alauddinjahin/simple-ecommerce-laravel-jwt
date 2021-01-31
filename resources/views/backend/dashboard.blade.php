@extends('backend.layouts.master')

@section('title', 'Dashboard')
@push('css') 
<link rel="stylesheet" href="{{ asset('ui/backend/dist/assets/css/dashboard.css') }}">
@endpush


@section('content')
<div class="container-fluid">

	<div class="row mt-3 mb-3">

        <div class="col animate">
            <div class="card-box shadow text-center dashboard-link h-100">
                <i class="fas fa-box-open"></i>
                <span class="h3 d-block text-uppercase">Total Item</span>
                <span class="h4 d-block text-uppercase">{{ check_helper() }}</span>
            </div>
        </div> <!-- .col-md-3 -->
        
        <div class="col animate">
            <div class="card-box shadow text-center dashboard-link h-100">
                <i class="mdi mdi-medical-bag  text-muted dashboard-icon"></i>
                <span class="h3 d-block text-uppercase">Total Sell</span>
                <span class="h4 d-block text-uppercase">500</span>
            </div>
        </div> <!-- .col-md-3 -->
        
        <div class="col animate">
            <div class="card-box shadow text-center dashboard-link h-100">
                <i class=" mdi mdi-download-outline dashboard-icon"></i>
                <span class="h3 d-block text-uppercase">Total Receive</span>
                <span class="h4 d-block text-uppercase">500</span>
            </div>
        </div> <!-- .col-md-3 -->
        

        <div class="col animate">
            <div class="card-box shadow text-center dashboard-link h-100">
                <i class=" mdi mdi-upload-outline dashboard-icon"></i>
                <span class="h3 d-block text-uppercase">Total Delivery</span>
                <span class="h4 d-block text-uppercase">500</span>
            </div>
        </div> <!-- .col-md-3 -->
        
    </div>
</div>

@endsection



@push('js')
<script src="{{ asset('ui/backend/dist/assets/js/animate.js') }}"></script>
<script src="{{ asset('ui/backend/dist/assets/js/dashboard.js') }}"></script>
@endpush
