@extends('frontend.layouts.master')

@section('title', 'Mart Sutta About Us Page')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{url('/')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Pages <span></span> Client
        </div>
    </div>
</div>
<div class="page-content pt-50">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <section class="text-center mb-50">
                    <h2 class="title style-3 mb-40">What do our client say?</h2>
                    <div class="row">
                        @if (!empty($testimonials) && count($testimonials) > 0)
                            @foreach($testimonials as $row)
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">
                                    <img src="{{ asset('uploads/testimonials/' . $row->image) }}" alt="" />
                                    <h4>{{ucfirst($row->name)}}</h4>
                                    <h6>{{ucfirst($row->designation)}}</h6>
                                    <p>{{ ucfirst(substr($row->description, 0, 150)) }}...</p>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <p class="text-center">No testimonials available.</p>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection