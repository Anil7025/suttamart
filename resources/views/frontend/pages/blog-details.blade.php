@extends('frontend.layouts.master')

@section('title', 'blog details')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{url('/')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Pages <span></span> Blog-details : {{$data->title}}
        </div>
    </div>
</div>
<div class="page-content mb-50">
    <div class="container">
        <div class="row">
            <div class="col-xl-11 col-lg-12 m-auto">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="single-page pt-50 pr-30">
                            <div class="single-header style-2">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <h2 class="mb-10">{{$data->title}}</h2>
                                        <div class="single-header-meta">
                                            <div class="entry-meta meta-1 font-xs mt-15 mb-15">
                                                <span class="post-by">By {{$data->user_name}} </span>
                                                <span class="post-on has-dot">{{ date('d F Y', strtotime($data->created_at)) }}</span>
                                            </div>
                                            <div class="social-icons single-share">
                                                <ul class="text-grey-5 d-inline-block">
                                                    <li class="mr-5">
                                                        <a href="#"><img src="{{asset('frontend/images/theme/icons/icon-bookmark.svg')}}" alt="" /></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="{{asset('frontend/images/theme/icons/icon-heart-2.svg')}}" alt="" /></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <figure class="single-thumbnail">
                                <img src="{{ asset('uploads/blogs/' . $data->image) }}" alt="" />
                            </figure>
                            <div class="single-content">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <p>{{ strip_tags($data->description) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 primary-sidebar sticky-sidebar pt-50">
                        @include('frontend.pages.blog_sidebar')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection