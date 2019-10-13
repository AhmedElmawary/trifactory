<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="shortcut icon" href="/images/favicon.png" type="image/png" />
        <title>@yield('title') | The TriFactory</title>
        <meta
            name="description"
            content="The home of triathlon in Egypt. All the information about upcoming events, trips and training services."
        />
        <!-- CSS -->
        <link rel="stylesheet" href="/css/main.css?v1.1" />
        <link rel="stylesheet" href="/css/override.css" />
        <link rel="stylesheet" href="/css/font-awesome.min.css" />
    </head>

    <body class="{{ $body_class }}">
        <!-- Start Header -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img
                        src="/images/logo.png"
                        class="d-inline-block"
                        alt="logo"
                    />
                </a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0 left-nav">
                        <li
                            class="nav-item  {{ Request::path() == '/' ? 'active' : '' }} "
                        >
                            <a class="nav-link" href="/"><span>Home</span></a>
                        </li>
                        <li
                            class="nav-item {{ Request::path() == 'events' ? 'active' : '' }}"
                        >
                            <a class="nav-link" href="/events">
                                <span>Events</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav my-2 my-lg-0 right-nav">
                        <li class="nav-item cart-item">
                            <a
                                class="nav-link"
                                style="display:inline;line-height:40px;"
                                href="/cart"
                                ><i
                                    color="#E21C21"
                                    class="fas fa-shopping-cart"
                                ></i
                                >Cart ({{ $cart_items_count }})</a
                            >
                            @auth
                            <a
                                class="nav-link"
                                style="display:inline;line-height:40px;"
                                href="#"
                                ><i
                                    color="#E21C21"
                                    class="fas fa-credit-card"
                                ></i
                                >EGP {{ $credit }}</a
                            >
                            @endauth
                        </li>
                        <li class="nav-item login-item">
                            @auth
                            <a
                                class="nav-link "
                                style="display:inline"
                                href="/profile"
                                >Profile</a
                            >
                            <span
                                class="nav-link "
                                style="display:inline;line-height:40px;"
                            >
                                |
                            </span>
                            <a
                                class="nav-link "
                                style="display:inline;cursor:pointer;"
                                onclick="showlogoutmodal()"
                                >Logout</a
                            >
                            @endauth @guest
                            <a
                                class="nav-link "
                                style="display:inline"
                                href="{{ route('login') }}"
                                >Login</a
                            >
                            <span
                                class="nav-link "
                                style="display:inline;line-height:40px;"
                            >
                                |
                            </span>
                            <a
                                class="nav-link "
                                style="display:inline"
                                href="{{ route('register') }}"
                                >Sign up</a
                            >
                            @endguest
                            <!-- <a class="nav-link d-none" href="/profile.html"><i class="fas fa-user-circle"></i>Profile</a> -->
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="modal fade custom-modal" id="logout_modal" tabindex="-1" role="dialog"
                            aria-labelledby="phone_verify_modal" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="header">
                                <!-- <h3 class="modal-title">Verification code sent to this number:</h3> -->
                                <img src="/images/success-icon.svg" class="modal-icon">
                                <span class="modal-sub-title">Logout</span>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <img src="/images/close-icon.svg" alt="close icon">
                                </button>
                                </div>
                                <div class="content">
                                <p class="modal-text">Are you sure you want to logout?</p>
                                <a href="/logout" class="btn btn-dark light">Proceed to Logout</a>
                                </div>
                                <br>
                            </div>
                            </div>
                            </div>

        <!-- End Header -->

        @yield('content')

        <!-- Start Footer -->
        <footer>
            <div class="container">
                <div class="row">
                   
                    <div class="col-lg-3 col-12">
                        <img
                            width="100%"
                            src="/images/logo.png"
                            alt="TriFactory Logo"
                            class="logo"
                            style="margin-bottom:20px"
                        />
                    </div>
                    <div class="col-lg-6 col-6">
                
                    </div>
                    <div class="col-lg-3 col-6 text-left">
                            <span class="contact-item">
                                    <img
                                        src="/images/location-icon.svg"
                                        alt="Location Icon"
                                        class="icon"
                                    />
                                    <p>
                                        17, Al Mansour Mohamed Street, Zamalek, Cairo,
                                        Egypt
                                    </p>
                                </span>
                                <span class="contact-item">
                                    <img
                                        src="/images/email-icon.svg"
                                        alt="email Icon"
                                        class="icon"
                                    />
                                    <a href="mailto:info@thetrifactory.com"
                                        >info@thetrifactory.com</a
                                    >
                                </span>
                                <br>
                  
                        <a style="margin-right:5%;"
                            target="_blank"
                            href="https://www.facebook.com/thetrifactory"
                            >
                        
                            <i style="color: red; font-size: 125%;" class="fab fa-facebook-f"></i>
                        </a>
                        <a
                            target="_blank"
                            href="https://www.instagram.com/thetrifactory"
                            >
                        
                            <i style="color: red; font-size: 152%; margin-top: 4%; position: relative; top: 2px;" class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-12 text-lg-left text-center">
                        <p class="footer-text" style="text-align: center;">Copyright 2019 The TriFactory</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- End Footer -->
        <!-- Start JS -->
        <script src="/js/font-awesome.js"></script>
        <script src="/js/jquery-3.2.1.slim.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/slick.min.js"></script>
        <!-- <script src="/js/app.js"></script>-->
        <script src="/js/main.js?v1.14"></script>

        <!-- End JS -->
    </body>
</html>
