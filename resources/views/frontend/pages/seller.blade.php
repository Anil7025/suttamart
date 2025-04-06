@extends('frontend.layouts.master')

@section('title', 'Mart Sutta Seller Page')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{url('/')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Pages <span></span>Seller List
        </div>
    </div>
</div>
<div class="page-content pt-50">
    <div class="container">
        <div class="archive-header-2 text-center">
            <h1 class="display-2 mb-50">Seller List</h1>
        </div>
        <div class="row vendor-grid">
            @if (!empty($datalist) && count($datalist) > 0)
            @foreach($datalist as $row)
            <div class="col-lg-6 col-md-6 col-12 col-sm-6">
                <div class="vendor-wrap style-2 mb-40">
                    <div class="vendor-img-action-wrap">
                        <div class="vendor-img">
                            <a href="vendor-details-1">
                                <img class="default-img" src="{{ asset('uploads/sellers/'.$row->image)}}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="vendor-content-wrap">
                        <div class="mb-30">
                            <div class="product-category">
                                <span class="text-muted">Join Date : {{ date('d F Y', strtotime($row->created_at)) }}</span>
                            </div>
                            <h4 class="mb-5">{{ucfirst($row->name)}}</h4>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"> <h6 class="mt-5">{{ucfirst($row->shopName)}}</h6></div>
                                </div>
                            </div>
                            <div class="vendor-info d-flex justify-content-between align-items-end mt-30">
                                <ul class="contact-infor text-muted">
                                    <li><img src="{{ asset('frontend/images/theme/icons/icon-location.svg')}}" alt=""><strong>Address: </strong> <span>{{ ucfirst($row->address) }}, {{ ucfirst($row->district) }}, {{ ucfirst($row->state) }}, {{ $row->pincode }},</span></li>
                                    <li><img src="{{ asset('frontend/images/theme/icons/icon-contact.svg')}}" alt=""><strong>Call Us:</strong><span>{{$row->mobile}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <p class="text-center">No seller available.</p>
             @endif
        </div>
        <div class="pagination-area mt-20 mb-20">
            <nav aria-label="Page navigation example">
                {{ $datalist->links() }}
            </nav>
        </div>
    </div>
</div>
@endsection