@extends('admin.layouts.admin')

@section('title', __('Multiple Images'))

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
								{{ __('Multiple Images') }}
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
							<form novalidate="" data-validate="parsley" id="DataEntry_formId" method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label for="pro_images">{{ __('Images') }}<span class="red">*</span></label>
											<div class="tp-upload-field">
												<input type="file" name="images[]" id="pro_images" class="form-control" multiple>
											</div>
											<input type="file" name="large_image" id="pro_large_image" class="dnone">
											<em>Recommended image size width: 600px and height: 600px.</em>
										</div>
										<div id="imagePreview"></div>
									</div>
								</div>
								<div class="row mt-15">
									<div class="col-lg-12">
										<a id="submit-form" href="javascript:void(0);" class="btn blue-btn">{{ __('Save') }}</a>
									</div>
								</div>
							</form>
							
							<!--/Data Entry Form/-->
							
							<!--Image list-->
							<div id="tp_datalist">
								@include('admin.partials.product_images_list')
							</div>
							<!--/Image list/-->
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
var product_id = "{{ $datalist['id'] }}";
var TEXT = [];
	TEXT['Do you really want to delete this record'] = "{{ __('Do you really want to delete this record') }}";
</script>
<script src="{{asset('admin/pages/product_images.js')}}"></script>
@endpush