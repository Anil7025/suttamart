@extends('admin.layouts.admin')

@section('title', __('Product Categories'))

@section('content')
<!-- main Section -->
<div class="main-body">
	<div class="container-fluid">
		<div class="row mt-25">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-lg-6">
								<span>{{ __('Product Categories') }}</span>
							</div>
							<div class="col-lg-6">
								<div class="float-right">
									<a onClick="onFormPanel()" href="javascript:void(0);" class="btn blue-btn btn-form float-right"><i class="fa fa-plus"></i> {{ __('Add New') }}</a>
									<a onClick="onListPanel()" href="javascript:void(0);" class="btn warning-btn btn-list float-right dnone"><i class="fa fa-reply"></i> {{ __('Back to List') }}</a>
								</div>
							</div>
						</div>
					</div>

					<!--Data grid-->
					<div id="list-panel" class="card-body">
						
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group bulk-box">
									<select id="bulk-action" class="form-control">
										<option value="">{{ __('Select Action') }}</option>
										<option value="publish">{{ __('Publish') }}</option>
										<option value="draft">{{ __('Draft') }}</option>
										<option value="delete">{{ __('Delete Permanently') }}</option>
									</select>
									<button type="submit" onClick="onBulkAction()" class="btn bulk-btn">{{ __('Apply') }}</button>
								</div>
							</div>
							<div class="col-lg-3"></div>
							<div class="col-lg-5">
								<div class="form-group search-box">
									<input id="search" name="search" type="text" class="form-control" placeholder="{{ __('Search') }}...">
									<button type="submit" onClick="onSearch()" class="btn search-btn">{{ __('Search') }}</button>
								</div>
							</div>
						</div>
						<div id="tp_datalist">
							@include('admin.partials.product_categories_table')
						</div>
					</div>
					<!--/Data grid/-->
					<!--Data Entry Form-->
					<div id="form-panel" class="card-body dnone">
						<form novalidate="" data-validate="parsley" id="DataEntry_formId" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">{{ __('Category Name') }}<span class="red">*</span></label>
										<input type="text" name="name" id="name" class="form-control parsley-validated" data-required="true">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="slug">{{ __('Slug') }}<span class="red">*</span></label>
										<input type="text" name="slug" id="slug" class="form-control parsley-validated" data-required="true">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="sortdescription">{{ __('Sort Description') }}</label>
										<textarea name="sortdescription" id="sortdescription" class="form-control" rows="2"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group tpeditor">
										<label for="content">{{ __('Description') }}</label>
										<textarea name="description" id="content" class="form-control parsley-validated" rows="3"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="photo_thumbnail">{{ __('Profile Photo') }}</label>
										<div class="tp-upload-field">
											<input type="file" name="image" id="photo_thumbnail" class="form-control">
										</div>
										<em>Recommended image size: 400px × 400px.</em>
								
										<!-- Image Preview Section -->
										<div id="remove_photo_thumbnail" class="select-image" style="display:none;">
											<div class="inner-image" id="view_photo_thumbnail"></div>
											<a href="javascript:void(0);" id="removeImageBtn" class="media-image-remove">
												<i class="fa fa-remove"></i>
											</a>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="is_publish">{{ __('Status') }}<span class="red">*</span></label>
										<select name="is_publish" id="is_publish" class="chosen-select form-control">
										@foreach($statuslist as $row)
											<option value="{{ $row->id }}">
												{{ $row->status }}
											</option>
										@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="divider_heading">{{ __('Subheader') }}</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="is_subheader">{{ __('Subheader') }}</label>
										<select name="is_subheader" id="is_subheader" class="chosen-select form-control">
											<option value="0">{{ __('NO') }}</option>
											<option value="1">{{ __('YES') }}</option>
										</select>
									</div>
								</div>
								<div class="col-md-6"></div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="cat_photo_thumbnail">{{ __('Sub Header Image') }}</label>
										<div class="tp-upload-field">
											<input type="file" name="subheader_image" id="cat_photo_thumbnail" class="form-control">
										</div>
										<em>Recommended image size: 1920px × 200px.</em>
								
										<!-- Image Preview Section -->
										<div id="cat_remove_photo_thumbnail" class="select-image" style="display:none;">
											<div class="inner-image" id="cat_view_photo_thumbnail"></div>
											<a href="javascript:void(0);" id="view_subheader_image" class="media-image-remove">
												<i class="fa fa-remove"></i>
											</a>
										</div>
									</div>
								</div>
								<div class="col-md-6"></div>
							</div>
							
							<div class="divider_heading">{{ __('SEO') }}</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="og_title">{{ __('SEO Title') }}</label>
										<input type="text" name="og_title" id="og_title" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="og_keywords">{{ __('SEO Keywords') }}</label>
										<input type="text" name="og_keywords" id="og_keywords" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="og_description">{{ __('SEO Description') }}</label>
										<textarea name="og_description" id="og_description" class="form-control" rows="3"></textarea>
									</div>
								</div>
							</div>
							<input type="text" name="RecordId" id="RecordId" class="dnone">
							<div class="row tabs-footer mt-15">
								<div class="col-lg-12">
									<a id="submit-form" href="javascript:void(0);" class="btn blue-btn mr-10">{{ __('Save') }}</a>
									<a onClick="onListPanel()" href="javascript:void(0);" class="btn danger-btn">{{ __('Cancel') }}</a>
								</div>
							</div>
						</form>
					</div>
					<!--/Data Entry Form/-->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /main Section -->

<!--Global Media-->
@endsection

@push('scripts')
<!-- css/js -->
<script type="text/javascript">
	var media_type = 'Product_Thumbnail';
	var TEXT = [];
		TEXT['Do you really want to edit this record'] = "{{ __('Do you really want to edit this record') }}";
		TEXT['Do you really want to delete this record'] = "{{ __('Do you really want to delete this record') }}";
		TEXT['Do you really want to publish this records'] = "{{ __('Do you really want to publish this records') }}";
		TEXT['Do you really want to draft this records'] = "{{ __('Do you really want to draft this records') }}";
		TEXT['Do you really want to delete this records'] = "{{ __('Do you really want to delete this records') }}";
		TEXT['Please select action'] = "{{ __('Please select action') }}";
		TEXT['Please select record'] = "{{ __('Please select record') }}";
	</script>
<link href="{{asset('admin/editor/summernote-lite.min.css')}}" rel="stylesheet">
<script src="{{asset('admin/editor/summernote-lite.min.js')}}"></script>
<script src="{{asset('admin/pages/product-categories.js')}}"></script>
@endpush