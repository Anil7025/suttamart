@extends('frontend.layouts.master')

@section('title', 'Mart Sutta Blog Category Details page')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{url('/')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Pages <span></span> Blog Category Details: {{$metadata->name}}
        </div>
    </div>
</div>
<div class="page-content mt-30 mb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="shop-product-fillter mb-50 pr-30">
                    <div class="totall-product">
                        <h2>
                            <img class="w-36px mr-10" src="{{ asset('frontend/images/theme/icons/category-1.svg')}}" alt="" />
                            {{$metadata->name}}
                        </h2>
                    </div>
                </div>
                <div class="loop-grid pr-30">
                    <div class="row">
                        @if (!empty($datalist) && count($datalist) > 0)
                        @php $i =1;  @endphp
                        @foreach($datalist as $data)
                            <article class="col-xl-4 col-lg-6 col-md-6 text-center hover-up mb-30 animated" data-wow-delay=".{{$i}}s">
                                <div class="post-thumb">
                                    <a href="{{url('blogs/'.$data->id.'/'.$data->slug)}}">
                                        <img class="border-radius-15 postBlogImg" src="{{ asset('uploads/blogs/' . $data->image) }}" alt="" />
                                    </a>
                                    <div class="entry-meta">
                                        <a class="entry-meta meta-2" href="{{url('blogs/'.$data->id.'/'.$data->slug)}}"><i class="fi-rs-link"></i></a>
                                    </div>
                                </div>
                                <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                    <span class="post-on has-dot mr-50">By {{$data->user_name}}</span>
                                    <span class="hit-count has-dot">{{ date('d F Y', strtotime($data->created_at)) }}</span>
                                </div>
                                <div class="entry-content-2">
                                    <h4 class="post-title mb-15">
                                        <a href="{{url('blogs/'.$data->id.'/'.$data->slug)}}">{{$data->title}}</a>
                                    </h4>
                                    
                                </div>
                            </article>
                        @endforeach
                        @else
                        <p class="text-center">No Blog Details available.</p>
                        @endif
                    </div>
                </div>
                <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                    <nav aria-label="Page navigation example">
                       <div class="col-lg-12 users_pagination">
                            {{ $datalist->links() }}
                        </div>
                    </nav>
                </div>
            </div>
            <div class="col-lg-3 primary-sidebar sticky-sidebar">
                @include('frontend.pages.blog_sidebar_deteils')
            </div>
        </div>
    </div>
</div>
@endsection