@extends('frontend.layouts.master')

@section('title', 'Mart Sutta contact page')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{url('/')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Pages <span></span> Contact
        </div>
    </div>
</div>
<div class="page-content pt-50">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <section class="row align-items-end mb-50">
                    <div class="col-lg-12 mb-lg-0 mb-md-5 mb-sm-5">
                        <h4 class="mb-20 text-brand">How can help you ?</h4>
                        <h1 class="mb-30">Let us know how we can help you</h1>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <section class="mb-50">
                    <div class="row mb-60">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <h4 class="mb-15 text-brand">Office</h4>
                            Sector 62, Noida
                            Uttar Pradesh, 201301, India<br />
                            <abbr title="Phone">Phone:</abbr> 89324243242<br />
                            <abbr title="Email">Email: </abbr>martsutta@gmail.com<br /></div>
                        <div class="col-md-6">
                            <h4 class="mb-15 text-brand">Shop</h4>
                            Sector 62, Noida
                            Uttar Pradesh, 201301, India<br />
                            <abbr title="Phone">Phone:</abbr> 89324243242<br />
                            <abbr title="Email">Email: </abbr>martsutta@gmail.com<br /></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="contact-from-area padding-20-row-col">
                                <h5 class="text-brand mb-10">Contact form</h5>
                                <h2 class="mb-10">Drop Us a Line</h2>
                                <p class="text-muted mb-30 font-sm">Your email address will not be published. Required fields are marked *</p>
                                <form class="contact-form-style mt-30" id="contact-form" action="#" method="post">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="input-style mb-20">
                                                <input name="name" placeholder="First Name" type="text" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="input-style mb-20">
                                                <input name="email" placeholder="Your Email" type="email" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="input-style mb-20">
                                                <input name="telephone" placeholder="Your Phone" type="tel" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="input-style mb-20">
                                                <input name="subject" placeholder="Subject" type="text" />
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="textarea-style mb-30">
                                                <textarea name="message" placeholder="Message"></textarea>
                                            </div>
                                            <button class="submit submit-auto-width" type="submit">Send message</button>
                                        </div>
                                    </div>
                                </form>
                                <p class="form-messege"></p>
                            </div>
                        </div>
                        <div class="col-lg-4 pl-50 d-lg-block d-none">
                            <img class="border-radius-15 mt-50" src=" {{ asset('frontend/images/page/contact-2.png')}}" alt="" />
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection