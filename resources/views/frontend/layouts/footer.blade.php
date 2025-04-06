<footer class="main">
    <section class="newsletter mb-15 wow animate__animated animate__fadeIn">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @php $banner = bottombanner() @endphp
                    <div class="position-relative newsletter-inner">
                        <div class="newsletter-content">
                            <h2 class="mb-20">
                                {{$banner->title}}
                            </h2>
                            <p class="mb-45">Start You'r Daily Shopping with <span class="text-brand">sutta Mart</span></p>
                            <form class="form-subcriber d-flex">
                                <input type="email" placeholder="Your emaill address" />
                                <button class="btn" type="submit">Subscribe</button>
                            </form>
                        </div> 
                        {{-- <img src="{{ asset('uploads/offerimages/' . $banner->image) }}" alt="newsletter" /> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="section-padding footer-mid">
        <div class="container pt-15 pb-20">
            <div class="row">
                <div class="col">
                    <div class="widget-about font-md mb-md-3 mb-lg-3 mb-xl-0 wow animate__animated animate__fadeInUp" data-wow-delay="0">
                        <div class="logo mb-20">
                            <a href="{{url('/')}}" class="mb-15"><img class="footer-logo" src="{{ asset('frontend/images/theme/logo.webp')}}" alt="logo" /></a>
                            <p class="font-lg text-heading">Mart Sutta store website</p>
                            <p class="font-sm mt-10">Welcome to Martsutta,your trusted destination for premium tobacco products and unparalleled convenience.Established with them is sion of transforming the way people purchase cigarettes, martsutta combines modern technology,a user-friendly interface, and an extensive selection to create a seamless shopping experience.</p>
                        </div>
                       
                    </div>
                </div>
                <div class="footer-link-widget col wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                    <h4 class="widget-title mb-15">Company</h4>
                    <p class="font-lg text-heading mb-15">Welcome to MartSutta store</p>
                    <ul class="contact-infor">
                        <li><img src="{{ asset('frontend/images/theme/icons/icon-location.svg')}}" alt="" /><strong>Address: </strong> <span>Sec-12 & 22 Noida 201301 India</span></li>
                        <li><img src="{{ asset('frontend/images/theme/icons/icon-contact.svg')}}" alt="" /><strong>Call Us:</strong><span>(+91) - 7827422855</span></li>
                        <li><img src="{{ asset('frontend/images/theme/icons/icon-email-2.svg')}}" alt="" /><strong>Email:</strong><span>martsutta@gmail.com</span></li>
                        <li><img src="{{ asset('frontend/images/theme/icons/icon-clock.svg')}}" alt="" /><strong>Hours:</strong><span>08:00 - 12:00 PM</span></li>
                    </ul>
                </div>
                <div class="footer-link-widget col wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                    <h4 class="widget-title">Account</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="{{url('about-us')}}">About Us</a></li>
                        <li><a href="{{url('team')}}">Our Team</a></li>
                        <li><a href="{{url('condition')}}">Condition</a></li> 
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Sign In</a></li>
                        <li><a href="#">Become a Vendor</a></li>
                        
                    </ul>
                </div>
                <div class="footer-link-widget col wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
                    <h4 class="widget-title">Corporate</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Terms &amp; Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">My account</a></li>
                        <li><a href="#">Help Ticket</a></li>
                    </ul>
                </div>
                <div class="footer-link-widget col wow animate__animated animate__fadeInUp" data-wow-delay=".4s">
                    <h4 class="widget-title">Category</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="#">Cigrate</a></li>
                        <li><a href="#">Gutaka</a></li>
                        <li><a href="#">Pan Masala</a></li>
                        <li><a href="#">Ice</a></li>
                        <li><a href="#">Rajani gandha</a></li>
                        <li><a href="#">Bhola</a></li>
                    </ul>
                </div>
            </div>
    </section>
    <div class="container pb-30 wow animate__animated animate__fadeInUp" data-wow-delay="0">
        <div class="row align-items-center">
            <div class="col-12 mb-30">
                <div class="footer-bottom"></div>
            </div>
            <div class="col-xl-3 col-lg-5 col-md-5">
                <p class="font-sm mb-0">&copy; 2025, <strong class="text-brand">Mart Sutta</strong> -Website <small>All rights reserved</small></p>
            </div>
            <div class="col-xl-3 col-lg-4 text-center d-none d-xl-block">
                <div class="hotline d-lg-inline-flex">
                    <img src="{{ asset('frontend/images/theme/icons/phone-call.svg')}}" alt="hotline" />
                    <p>7827422855<span>24/7 Support Center</span></p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-4 text-center d-none d-xl-block">
                <div>
                    <img class="width:150px" src="{{ asset('frontend/images/theme/payment-method.png')}}" alt="hotline" />
                    <p>Secured Payment Gateways</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-4 text-end d-none d-md-block">
                <div class="mobile-social-icon">
                    <h6>Follow Us</h6>
                    <a href="#"><img src="{{ asset('frontend/images/theme/icons/icon-facebook-white.svg')}}" alt="" /></a>
                    <a href="#"><img src="{{ asset('frontend/images/theme/icons/icon-twitter-white.svg')}}" alt="" /></a>
                    <a href="#"><img src="{{ asset('frontend/images/theme/icons/icon-instagram-white.svg')}}" alt="" /></a>
                    <a href="#"><img src="{{ asset('frontend/images/theme/icons/icon-pinterest-white.svg')}}" alt="" /></a>
                    <a href="#"><img src="{{ asset('frontend/images/theme/icons/icon-youtube-white.svg')}}" alt="" /></a>
                </div>
                <p class="font-sm">Up to 15% discount on your first subscribe</p>
            </div>
        </div>
    </div>
</footer>