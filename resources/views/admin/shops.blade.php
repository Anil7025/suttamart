@extends('admin.layouts.admin')

@section('title', __('Shops'))

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
								<span>{{ __('Shops') }}</span>
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
							@include('admin.partials.shops_table')
						</div>
					</div>
					<!--/Data grid/-->
					<!--Data Entry Form-->
					<div id="form-panel" class="card-body dnone"  >
						<form method="POST" data-validate="parsley" id="DataEntry_formId" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="name">{{ __('Name') }}<span class="red">*</span></label>
										<input type="text" name="name" id="name" class="form-control parsley-validated" required>
									</div>
								</div>
							</div>
						
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="email">{{ __('Email') }}<span class="red">*</span></label>
										<input type="email" name="email" id="email" class="form-control parsley-validated" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="mobile">{{ __('Phone') }}<span class="red">*</span></label>
										<input type="text" name="mobile" id="mobile" maxlength="10" pattern="^\d{10}$" class="form-control parsley-validated" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="address">{{ __('Address') }}<span class="red">*</span></label>
										<input type="text" name="address" id="address" class="form-control parsley-validated" required>
									</div>
								</div>
							</div>
						
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="shop_logo">{{ __('Shop Logo') }}</label>
										<div class="tp-upload-field">
											<input type="file" name="shop_logo" id="shop_logo" class="form-control">
										</div>
										<em>Recommended image size: 500px × 300px.</em>
								
										<!-- Image Preview Section -->
										<div id="remove_shop_logo" class="select-image" style="display:none;">
											<div class="inner-image" id="view_shop_logo"></div>
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
												<option value="{{ $row->id }}">{{ $row->status }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<input type="hidden" name="RecordId" id="RecordId">
						
							<div class="row tabs-footer mt-15">
								<div class="col-lg-12">
									<button id="submit-form" type="submit" class="btn blue-btn mr-10">{{ __('Save') }}</button>
									<a onclick="onListPanel()" href="javascript:void(0);" class="btn danger-btn">{{ __('Cancel') }}</a>
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


@endsection

@push('scripts')
<!-- css/js -->
<script type="text/javascript">
var TEXT = [];
	TEXT['Do you really want to edit this record'] = "{{ __('Do you really want to edit this record') }}";
	TEXT['Do you really want to delete this record'] = "{{ __('Do you really want to delete this record') }}";
	TEXT['Do you really want to publish this records'] = "{{ __('Do you really want to publish this records') }}";
	TEXT['Do you really want to draft this records'] = "{{ __('Do you really want to draft this records') }}";
	TEXT['Do you really want to delete this records'] = "{{ __('Do you really want to delete this records') }}";
	TEXT['Please select action'] = "{{ __('Please select action') }}";
	TEXT['Please select record'] = "{{ __('Please select record') }}";
</script>
<script src="{{asset('admin/pages/shops.js')}}"></script>
@endpush