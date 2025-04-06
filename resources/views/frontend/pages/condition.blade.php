@extends('frontend.layouts.master')

@section('title', 'Mart Sutta Conditions Us Page')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{url('/')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Pages <span></span> Conditions
        </div>
    </div>
</div>
<div class="page-content pt-50">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <section class="text-center mb-50">
                    <h2 class="title style-3 mb-40">What We Provide?</h2>
                    <div class="row">
                        @if (!empty($conditions) && count($conditions) > 0)
                            @foreach($conditions as $row)
                                <div class="col-lg-4 col-md-6 mb-24">
                                    <div class="featured-card">
                                        <img src="{{ asset('uploads/conditions/'.$row->icon)}}" alt="" />
                                        <h4>{{ ucfirst($row->title)}}</h4>
                                        <p>{{ ucfirst(substr($row->description, 0, 150)) }}...</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center">No conditions available.</p>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection