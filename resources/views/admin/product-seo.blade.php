@extends('admin.layouts.admin')

@section('title', __('SEO'))

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
								{{ __('SEO') }}
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
							<form novalidate="" data-validate="parsley" id="DataEntry_formId">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="og_title">{{ __('SEO Title') }}</label>
											<input value="{{ $datalist['og_title'] }}" type="text" name="og_title" id="og_title" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="og_keywords">{{ __('SEO Keywords') }}</label>
											<input value="{{ $datalist['og_keywords'] }}" type="text" name="og_keywords" id="og_keywords" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">	
									<div class="col-md-12">
										<div class="form-group">
											<label for="og_description">{{ __('SEO Description') }}</label>
											<textarea name="og_description" id="og_description" class="form-control" rows="2">{{ $datalist['og_description'] }}</textarea>
										</div>
									</div>
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
<script src="{{asset('admin/pages/product_seo.js')}}"></script>
@endpush