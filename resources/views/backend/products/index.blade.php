@extends('backend.layouts.master')

@push('css')
<link rel="stylesheet" href="{{ asset('ui/backend/src/js/pages/items/items.css') }}">
@endpush


@section('content')
<div class="container-fluid">
    
    <h4 class="page-title text-uppercase mt-3">
        <i class="fas fa-box-open"></i> Products
        <button type="button" id="add-product" class="float-right btn btn-sm btn-primary btn-rounded width-md waves-effect waves-light"><i class="fa fa-plus"></i> ADD ITEM</button>
    </h4><br>

    <div class="row" id="list-row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">Products List</h2>
                    <table class="table table-bordered table-hover table-striped" id="itemsListTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Serial No</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Product Title</th>
                                <th class="text-center">Product image</th>
                                <th>Unit price</th>
                                <th>Created By</th>
                                <th class="text-center">#</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if(!is_null($products) && count($products)>0)
                                @php 
                                    $products = collect($products)->reverse();
                                @endphp 

                                @foreach ($products as $item)

                                    <tr data-row="{{ $item->id }}" data-json="{{ $item }}" data-itemId="{{ $item->id }}" data-categoryId="{{ $item->category_id }}" data-subcategoryId="{{ $item->subcategory_id }}">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->category->category_title ?? '' }}</td>
                                        <td>{{ $item->subcategory->subcategory_title?? ''}}</td>
                                        <td>{{ $item->title ?? '' }}</td>
                                        <td class="text-center">
                                            <img style="width: 80px; height: 80px;" src="{{ asset('/products/'.$item->image ) }}" alt="product image">
                                        </td>
                                        <td>{{ $item->unit_price ?? '' }}</td>
                                        <td>{{ $item->created_by->name ?? '' }}</td>
                                        <td class="text-center" data-itemId="{{ $item->id }}" data-categoryId="{{ $item->category_id }}" data-subcategoryId="{{ $item->subcategory_id }}"><i class="fa fa-edit" style="color: #ac4c05;"></i></td>
                                    </tr>
                                @endforeach
                            @else 
                            <tr>
                                <td colspan="8" class="text-center text-danger" style="font-size: 40px"><b>NO DATA FOUND!</b></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end page content -->
</div>


<div id="product-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content" style="width: 1000px;">

			<div class="modal-header" style="background: #212d6f">
				<h5 class="modal-title text-white">Product Form</h5>
                <span aria-hidden="true" class="fa fa-times text-white" style="cursor: pointer" data-dismiss="modal"></span>
            </div>
            
			<div class="modal-body">
                <form id="product-form">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control" required></select>
                    </div>

                    <div class="form-group">
                        <label for="subcategory_id">Subcategory</label>
                        <select name="subcategory_id" id="subcategory_id" class="form-control" required></select>
                    </div>

                    <div class="form-group">
                        <label for="title">Product Title</label>
                        <input name="title" type="text" placeholder="Product Title" id="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Product Description</label>
                        <textarea name="description" type="text" placeholder="Product Description" id="description" class="form-control" required></textarea>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-7">
                            <label> Product Image</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <button title="Image Preview" class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-image fa-lg"></i></button>
                                </div>
                                <input name="image" type="file" accept="image/*" id="image" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group col-md-5">
                            <div class="collapse" id="collapseExample" style="">
                                <img title="Click to upload image" src="{{ asset('/images/blank-user.jpg') }}" alt="PRODUCT PHOTO" onclick="javascript: document.getElementById('image').click()" id="product-img-preview" class="img-fluid img-responsive img-thumbnail" ondragstart="javascript: return false;" style="cursor:pointer;width:100%; height: 400px !important;">
                            </div>
                        </div>
                    </div> 

                    <div class="form-group d-none">
                        <input id="product-img-b64" type="hidden">
                    </div>

                    <div class="form-group">
                        <label for="unit_price">Unit Price</label>
                        <input name="unit_price" type="text" id="unit_price" placeholder="Unit Price" class="form-control" required>
                    </div>

                    <div class="form-group custom-control custom-switch">
                        <input type="checkbox" checked class="custom-control-input" id="is_active" name="is_active">
                        <label class="custom-control-label" for="is_active">Status</label>
                    </div>

                    <div class="form-group">
                        <button type="button" id="form-reset" class="btn btn-secondary btn-sm float-left"><i class="fa fa-sync"></i> CLEAR</button>
                        <button type="button" id="form-submit" class="btn btn-success btn-sm float-right"><i class="fa fa-save"></i> SAVE</button>
                    </div>
                    
                </form>
            </div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

@endsection

@push('js')
<script src="{{ asset('ui/backend/src/js/pages/items/items.js') }}"></script>
<script>
    // $( "#itemsListTable tbody").sortable();
</script>
@endpush