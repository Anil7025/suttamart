<div class="sidebar-wrapper">
	<div class="logo">
		<a href="{{ route('admin.dashboard') }}">
			<img src="{{ $gtext['back_logo'] ? asset('media/'.$gtext['back_logo']) : asset('frontend/images/theme/logo.webp	') }}" alt="logo" style="width: 70%">
		</a>
	</div>
	<div class="version text-center">Sutta Mart 1.1</div>
	<ul class="left-navbar">
		@if (Auth::user()->id == 1)
		<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-tachometer"></i>{{ __('Dashboard') }}</a></li>
		<li><a href="{{ route('admin.page') }}"><i class="fa fa-clipboard"></i>{{ __('Pages') }}</a></li>
		<li><a href="{{ route('admin.orders') }}" id="select_orders"><i class="fa fa-rocket"></i>{{ __('Orders') }}</a></li>
		<li class="dnone"><a href="{{ route('admin.transactions') }}"><i class="fa fa-credit-card"></i>{{ __('Transactions') }}</a></li>
		<li class="dropdown"><a class="nav-link has-dropdown" href="#" data-toggle="dropdown"><i class="fa fa-shopping-cart"></i>{{ __('eCommerce') }}</a>
			<ul class="dropdown-menu">
				<li><a href="{{ route('admin.products') }}">{{ __('Products') }}</a></li>
				<li><a href="{{ route('admin.manage-stock') }}">{{ __('Manage Stock') }}</a></li>
				<li><a href="{{ route('admin.product-categories') }}">{{ __('Product Categories') }}</a></li>
				<li><a href="{{ route('admin.brands') }}">{{ __('Brands') }}</a></li>
				<li><a href="{{ route('admin.shops') }}">{{ __('shops') }}</a></li>
				<li><a href="{{ route('admin.shipping') }}">{{ __('Shipping') }}</a></li>
				<li class="dnone"><a href="{{ route('admin.collections') }}">{{ __('Collections') }}</a></li>
				<li><a href="{{ route('admin.attributes') }}">{{ __('Unit') }}</a></li>
				<li class="dnone"><a href="{{ route('admin.labels') }}">{{ __('Labels') }}</a></li>
				<li class="dnone"><a href="{{ route('admin.coupons') }}">{{ __('Coupons') }}</a></li>
				<li><a href="{{ route('admin.tax') }}">{{ __('Tax') }}</a></li>
				<li><a href="{{ route('admin.payment-methods') }}">{{ __('Payment Methods') }}</a></li>
				<li><a href="{{ route('admin.slider') }}">{{ __('Home Slider') }}</a></li>
				<li><a href="{{ route('admin.offer-ads') }}">{{ __('Offer & Ads') }}</a></li>
			</ul>
		</li>
		<li class="dropdown"><a class="nav-link has-dropdown" href="#" data-toggle="dropdown"><i class="fa fa-pencil-square-o"></i>{{ __('Blog') }}</a>
			<ul class="dropdown-menu">
				<li><a href="{{ route('admin.blog') }}">{{ __('Posts') }}</a></li>
				<li><a href="{{ route('admin.blog-categories') }}">{{ __('Categories') }}</a></li>
			</ul>
		</li>
		<li class="dropdown"><a class="nav-link has-dropdown" href="#" data-toggle="dropdown"><i class="fa fa-wrench"></i>{{ __('Appearance') }}</a>
			<ul class="dropdown-menu">
				<li><a href="{{ route('admin.menu') }}">{{ __('Menu') }}</a></li>
				<li><a href="{{ route('admin.theme-options') }}">{{ __('Theme Options') }}</a></li>
				<li><a href="{{ route('admin.testimonials') }}">{{ __('Testimonial') }}</a></li>
				<li><a href="{{ route('admin.teams') }}">{{ __('Teams') }}</a></li>
				<li><a href="{{ route('admin.conditions') }}">{{ __('Conditions') }}</a></li>
			</ul>
		</li>
		<li class="dropdown"><a class="nav-link has-dropdown" href="#" data-toggle="dropdown"><i class="fa fa-sitemap"></i>{{ __('Marketplace') }}</a>
			<ul class="dropdown-menu">
				<li><a href="{{ route('admin.sellers') }}">{{ __('Sellers') }}</a></li>
			</ul>
		</li>
		<li><a href="{{ route('admin.customers') }}"><i class="fa fa-users"></i>{{ __('Customers') }}</a></li>
		<li><a href="{{ route('admin.review') }}"><i class="fa fa-recycle"></i>{{ __('Review & Ratings') }}</a></li>
		<li><a href="{{ route('admin.contact') }}"><i class="fa fa-envelope"></i>{{ __('Contact') }}</a></li>
		<li><a id="active-settings" href="{{ route('admin.general') }}"><i class="fa fa-cogs"></i>{{ __('Settings') }}</a></li>
		<li><a href="{{ route('admin.users') }}"><i class="fa fa-user-plus"></i>{{ __('Users') }}</a></li>
		@elseif (Auth::user()->role_id == 3)
		<li><a href="{{ route('seller.dashboard') }}"><i class="fa fa-tachometer"></i>{{ __('Dashboard') }}</a></li>
		<li><a href="{{ route('seller.products') }}" id="select_product"><i class="fa fa-product-hunt"></i>{{ __('Products') }}</a></li>
		<li><a href="{{ route('seller.orders') }}" id="select_order"><i class="fa fa-rocket"></i>{{ __('Orders') }}</a></li>
		<li><a href="{{ route('seller.withdrawals') }}"><i class="fa fa-rocket"></i>{{ __('Withdrawals') }}</a></li>
		<li><a href="{{ route('seller.review') }}"><i class="fa fa-recycle"></i>{{ __('Review & Ratings') }}</a></li>
		<li><a href="{{ route('seller.settings') }}"><i class="fa fa-cogs"></i>{{ __('Settings') }}</a></li>
		<li><a href="{{ route('frontend.my-dashboard') }}"><i class="fa fa-bandcamp"></i>{{ __('Customer Dashboard') }}</a></li>
		@endif
	</ul>
</div>