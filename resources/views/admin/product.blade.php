@extends('admin.layouts.admin')

@section('title', __('Product'))

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
								{{ __('Product') }}
							</div>
							<div class="col-lg-6">
								<div class="float-right">
									<a href="{{ route('admin.products') }}" class="btn warning-btn"><i class="fa fa-reply"></i> {{ __('Back to List') }}</a>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body tabs-area p-0">
						@include('admin.partials.product_tabs_nav')
						<div class="tabs-body">
							<!--Data Entry Form-->
							<form novalidate="" data-validate="parsley" id="DataEntry_formId" method="post" enctype="multipart/form-data">@csrf
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="product_name">{{ __('Product Name') }}<span class="red">*</span></label>
											<input value="{{ $datalist['title'] }}" type="text" name="title" id="product_name" class="form-control parsley-validated" data-required="true">
										</div>
									</div>
								</div>
								<div class="row">	
									<div class="col-lg-12">
										<div class="form-group">
											<label for="slug">{{ __('Slug') }}<span class="red">*</span></label>
											<input value="{{ $datalist['slug'] }}" type="text" name="slug" id="slug" class="form-control parsley-validated" data-required="true">
										</div>
									</div>
								</div>
								<div class="row">	
									<div class="col-lg-12">
										<div class="form-group">
											<label for="short_desc">{{ __('Short Description') }}</label>
											<textarea name="short_desc" id="short_desc" class="form-control" rows="2">{{ $datalist['short_desc'] }}</textarea>
										</div>
									</div>
								</div>
								<div class="row">	
									<div class="col-lg-12">
										<div class="form-group tpeditor">
											<label for="description">{{ __('Description') }}</label>
											<textarea name="description" id="description" class="form-control" rows="4">{{ $datalist['description'] }}</textarea>
										</div>
									</div>
								</div>

								<div class="row">	
									<div class="col-lg-6">
										<div class="form-group">
											<label for="tax_id">{{ __('Tax') }}<span class="red">*</span></label>
											<select name="tax_id" id="tax_id" class="chosen-select form-control">
											@foreach($taxlist as $row)
												<option {{ $row->id == $datalist['tax_id'] ? "selected=selected" : '' }} value="{{ $row->id }}">
													{{ $row->title }}
												</option>
											@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="sale_price">{{ __('Sale Price') }}<span class="red">*</span></label>
											<input value="{{ $datalist['sale_price'] }}" name="sale_price" id="sale_price" type="text" class="form-control parsley-validated" data-required="true">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="storeid">{{ __('Store') }}<span class="red">*</span></label>
											<select name="storeid" id="storeid" class="chosen-select form-control">
											@foreach($storeList as $row)
												<option {{ $row->id == $datalist['shop_id'] ? "selected=selected" : '' }} value="{{ $row->id }}">
													{{ $row->name }}
												</option>
											@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="variation_size">{{ __('Unit') }}<span class="red">*</span></label>
											<select name="variation_size" id="variation_size" class="chosen-select form-control">
											@foreach($unitlist as $row)
												<option {{ $row->name == $datalist['variation_size'] ? "selected=selected" : '' }} value="{{ $row->name }}">
													{{ $row->name }}
												</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="is_featured">{{ __('Is Popular') }}</label>
											<select name="is_featured" id="is_featured" class="chosen-select form-control">
												<option {{ 1 == $datalist['is_featured'] ? "selected=selected" : '' }} value="1">{{ __('YES') }}</option>
												<option {{ 0 == $datalist['is_featured'] ? "selected=selected" : '' }} value="0">{{ __('NO') }}</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="collection_id">{{ __('Is Trending') }}</label>
											<select name="collection_id" id="collection_id" class="chosen-select form-control">
												<option {{ 1 == $datalist['collection_id'] ? "selected=selected" : '' }} value="1">{{ __('YES') }}</option>
												<option {{ 0 == $datalist['collection_id'] ? "selected=selected" : '' }} value="0">{{ __('NO') }}</option>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="featured_image">{{ __('Product image') }}</label>
											<div class="tp-upload-field">
												<input type="file" name="image" id="featured_image" class="form-control">
											</div>
											<em>Recommended image size: 500px × 500px.</em>
									
											<!-- Image Preview Section -->
											<div id="remove_featured_image" class="select-image" style="display:none;">
												<div class="inner-image" id="view_featured_image"></div>
												<a href="javascript:void(0);" id="removeImageBtn" class="media-image-remove">
													<i class="fa fa-remove"></i>
												</a>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="featured_image2">{{ __('Product image 2') }}</label>
											<div class="tp-upload-field">
												<input type="file" name="imagess" id="featured_image2" class="form-control">
											</div>
											<em>Recommended image size: 500px × 500px.</em>
									
											<!-- Image Preview Section -->
											<div id="remove_featured_image2" class="select-image" style="display:none;">
												<div class="inner-image" id="view_featured_image2"></div>
												<a href="javascript:void(0);" id="removeImageBtn2" class="media-image-remove">
													<i class="fa fa-remove"></i>
												</a>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<label for="is_publish">{{ __('Status') }}<span class="red">*</span></label>
											<select name="is_publish" id="is_publish" class="chosen-select form-control">
											@foreach($statuslist as $row)
												<option {{ $row->id == $datalist['is_publish'] ? "selected=selected" : '' }} value="{{ $row->id }}">
													{{ $row->status }}
												</option>
											@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-9"></div>
								</div>
								<input value="{{ $datalist['id'] }}" type="text" name="RecordId" id="RecordId" class="dnone">
								<div class="row tabs-footer mt-15">
									<div class="col-lg-12">
										<a id="submit-form" href="javascript:void(0);" class="btn blue-btn">{{ __('Save') }}</a>
									</div>
								</div>
							</form>
							<!--/Data Entry Form/-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /main Section -->

@endsection

@push('scripts')
<!-- css/js -->
<script type="text/javascript">

var TEXT = [];
	TEXT['Select Category'] = "{{ __('Select Category') }}";

</script>
<link href="{{asset('admin/editor/summernote-lite.min.css')}}" rel="stylesheet">
<script src="{{asset('admin/editor/summernote-lite.min.js')}}"></script>
<script src="{{asset('admin/pages/product.js')}}"></script>
@endpush