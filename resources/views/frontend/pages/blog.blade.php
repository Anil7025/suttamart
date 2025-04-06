@extends('frontend.layouts.master')

@section('title', 'Mart Sutta Blog page')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{url('/')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Pages <span></span> Blog
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
                            Mart Sutta Articles
                        </h2>
                    </div>
                </div>
                <div class="loop-grid pr-30">
                    <div class="row">
                        @if (!empty($datalist) && count($datalist) > 0)
                        @php $i =1;  @endphp
                        @foreach($datalist as $row)
                        <article class="col-xl-4 col-lg-6 col-md-6 text-center hover-up mb-30 animated" data-wow-delay=".{{$i}}s">
                            <div class="post-thumb">
                                <a href="{{url('blogs/'.$row->id.'/'.$row->slug)}}">
                                    <img class="border-radius-15 postBlogImg" src="{{ asset('uploads/blogs/' . $row->image) }}" alt="" />
                                </a>
                                <div class="entry-meta">
                                    <a class="entry-meta meta-2" href="{{url('blogs/'.$row->id.'/'.$row->slug)}}"><i class="fi-rs-link"></i></a>
                                </div>
                            </div>
                            <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                <span class="post-on has-dot mr-50">By {{$row->user_name}}</span>
                                <span class="hit-count has-dot">{{ date('d F Y', strtotime($row->created_at)) }}</span>
                            </div>
                            <div class="entry-content-2">
                                <h4 class="post-title mb-15">
                                    <a href="{{url('blogs/'.$row->id.'/'.$row->slug)}}">{{$row->title}}</a>
                                </h4>
                                
                            </div>
                        </article>
                        @endforeach
                        @else
                        <p class="text-center">No Blog available.</p>
                        @endif
                    </div>
                </div>
                <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                    <nav aria-label="Page navigation example">
                        {{ $datalist->links() }}
                    </nav>
                </div>
            </div>
            <div class="col-lg-3 primary-sidebar sticky-sidebar">
                <div class="widget-area">
                    @include('frontend.pages.blog_sidebar')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection