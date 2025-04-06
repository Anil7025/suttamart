@extends('frontend.layouts.master')

@section('title', 'Mart Sutta About Us Page')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{url('/')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Pages <span></span> Teams
        </div>
    </div>
</div>
<div class="page-content pt-50">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <section class="mb-50">
                    <h2 class="title style-3 mb-40 text-center">Our Team</h2>
                    <div class="row">
                        <div class="col-lg-12 mb-lg-0 mb-md-5 mb-sm-5">
                            <h6 class="mb-5 text-brand">Our Team</h6>
                            <h1 class="mb-30">Meet Our Expert Team</h1>
                            <p class="mb-30">Proin ullamcorper pretium orci. Donec necscele risque leo. Nam massa dolor imperdiet neccon sequata congue idsem. Maecenas malesuada faucibus finibus.</p>
                            <p class="mb-30">Proin ullamcorper pretium orci. Donec necscele risque leo. Nam massa dolor imperdiet neccon sequata congue idsem. Maecenas malesuada faucibus finibus.</p>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                @if (count($teams)>0)
                                @foreach($teams as $team)
                                <div class="col-lg-4 col-md-4">
                                    <div class="team-card">
                                        <img src="{{ asset('uploads/teams/' . $team->image) }}" alt="" />
                                        <div class="content text-center">
                                            <p>{{ucfirst(substr($team->description, 0, 70))}}...</p>
                                            <h4 class="mb-5">{{ucfirst($team->name)}}</h4>
                                            <span>{{ucfirst($team->designation)}}</span>
                                            <div class="social-network mt-20">
                                                <a href="{{url($team->facebook ?? '#')}}"><img src="{{ asset('frontend/images/theme/icons/icon-facebook-brand.svg')}}" alt="" /></a>
                                                <a href="{{url($team->twitter ?? '#')}}"><img src="{{ asset('frontend/images/theme/icons/icon-twitter-brand.svg')}}" alt="" /></a>
                                                <a href="{{url($team->instagram ?? '#')}}"><img src="{{ asset('frontend/images/theme/icons/icon-instagram-brand.svg')}}" alt="" /></a>
                                                <a href="{{url($team->youtube ?? '#')}}"><img src="{{ asset('frontend/images/theme/icons/icon-youtube-brand.svg')}}" alt="" /></a>
                                            </div>
                                            {{-- <a href="{{url('team/'.$team->slug)}}">Details</a> --}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection