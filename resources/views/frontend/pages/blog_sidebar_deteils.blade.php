<div class="widget-area">
	<!-- Product sidebar Widget -->
	<div class="sidebar-widget product-sidebar mb-50 p-30 bg-grey border-radius-10">
		<h5 class="section-title style-1 mb-30">{{ __('Blog Categories Details') }}</h5>
		@php $cat_id = $metadata->id; $BlogCategoryDeleteForFilter = BlogCategoryDeleteForFilter($cat_id); @endphp
		@foreach ($BlogCategoryDeleteForFilter as $row)
			<div class="single-post clearfix">
				<div class="image">
					<img src="{{ asset('uploads/blog-cat/'.$row->image) }}" alt="#" />
				</div>
				<div class="content pt-10">
					<h5><a href="{{ route('frontend.blog-category', [$row->id, $row->slug]) }}">{{ $row->name }}</a></h5>
					<div class="product-rate">
						<div class="product-rating" style="width: 90%">{{ $row->TotalProduct }}</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>