@extends('backend.layouts.master')
@push('css')
@endpush
@section('content')

<div class="container-fluid">

	<h4 class="page-title text-uppercase mt-3">
		<i class="fab fa-artstation"></i> Categories
		<button type="button" id="add-new-category" class="float-right btn btn-sm btn-primary btn-rounded width-md waves-effect waves-light"><i class="fa fa-plus"></i> ADD NEW CATEGORY</button>
	</h4><br>

	<!-- end page content -->
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body scroll">
                    <table id="categories-table" class="table table-striped table-hover table-bordered text-center nowrap"  cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th>Category Name</th>
                                <th>Category Description</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!is_null($categories) && count($categories)>0)
                                @foreach ($categories as $category)
                                    <tr data-categoryId="{{ $category->id }}" data-status="{{ boolval($category->is_active) ? 'active': 'inactive' }}">
                                        <td>{{ $category->category_title??'' }}</td>
                                        <td>{{ $category->category_description??'' }}</td>
                                        <td>
                                            @if(boolval($category->is_active))
                                            <i class='mdi mdi-record text-success'>Active</i>
                                            @else
                                            <i class='mdi mdi-record text-danger'>Inactive</i>
                                            @endif
                                        </td>
                                        <td class="text-center" data-categoryId="{{ $category->id }}">
                                            <i class="fa fa-edit"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            @else 
                                <tr class="text-bold">
                                    <td colspan="10" class="dataTables_empty">No Data Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- -->
        <div class="col-4">
            <div class="card make-me-sticky">
                <div class="card-body">

                    <form id="categoryForm">
                        <div class="form-group">
                            <label for="category_title">Category Name</label>
                            <input name="category_title" type="text" placeholder="Category Name" id="category_title" class="form-control" required>
						</div>

                        <div class="form-group">
                            <label for="category_description">Category Description (optional)</label>
                            <textarea name="category_description" id="category_description" class="form-control"></textarea>
                        </div>

                        <div class="form-group custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active">
                            <label class="custom-control-label" for="is_active">Status</label>
                        </div>

                        <div class="form-group">
                            <button type="button" id="form-reset" class="btn btn-secondary btn-sm float-left"><i class="fa fa-sync"></i> CLEAR</button>
                            <button type="button" id="form-submit" class="btn btn-success btn-sm float-right"><i class="fa fa-check"></i> SAVE</button>
                        </div>
                    </form>
                        
                </div>
            </div>
        </div>
    </div>
    <!-- end page content -->
</div>

@endsection

@push('js')
<script src="{{ asset('ui/backend/src/js/pages/categories/category.js') }}"></script>
@endpush