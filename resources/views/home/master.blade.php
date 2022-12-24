<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-title" content="QazvinMarket">
    <meta name="mobile-web-app-title" content="QazvinMarket">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="apple-touch-icon" sizes="128x128" href="{{asset('web-app/128.png?v=2')}}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{asset('web-app/192.png?v=2')}}">
    <link rel="apple-touch-icon" sizes="512x512" href="{{asset('web-app/512.png?v=2')}}">
    <link rel="manifest" href="{{asset('web-app/manifest.json?v=4')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta property="og:image" content="https://qazvinmarket.com/images/theme1/qazvinmarket.png" />
    <meta property="og:image:type" content="image/jpg">
    <?
    $market=get_market(1);

    $uri=\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri();
    //    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"  and $uri!='voting/{orderId}' and $uri!='order_track/{order_id}' and $_SERVER['HTTP_HOST']!='pwa.qazvinmarket.local'){
    //        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    //        header('HTTP/1.1 301 Moved Permanently');
    //        header('Location: ' . $redirect);
    //        exit();
    //    }
    $detect = new Mobile_Detect;
    $android=$detect->isAndroidOS();
    ?>
    <script>
        let android ='<? echo $android ?>';
        function isIOS() {
            let userAgent = window.navigator.userAgent.toLowerCase();
            return /iphone|ipad|ipod/.test( userAgent ); //return true
        }
        function isStandalone() {
            return (isIOS() && (('standalone' in window.navigator) && (window.navigator.standalone)) ); //return undefine
        }
        window.onload = function () {
            let banner_c = '<? echo isset($_COOKIE['banner-close'])?>';
            let uri_banner ='{{$uri}}';
            if(isIOS()){
                if( isIOS() &&  !isStandalone() ) {
                    if (!banner_c && uri_banner != 'download/IOS'){
                        $('#banner-show').show();
                    }
                }
                else{
                    if (isIOS() &&  isStandalone()){
                        $('.button-show').show();
                    }
                    $('#banner-show').hide();
                }
            }
            if(android){
                if( android &&  !window.matchMedia('(display-mode: standalone)').matches){
                    if (!banner_c && uri_banner != 'download/Android'){
                        $('#banner-show').show();
                    }
                }
                else{
                    if (android &&  window.matchMedia('(display-mode: standalone)').matches){
                        $('.button-show').show();
                    }
                    $('#banner-show').hide();
                }
            }
        }
    </script>
    <!BEGIN RAYCHAT CODE--> <script type="text/javascript">!function(){function t(){let t=document.createElement("script");t.type="text/javascript",t.async=!0,localStorage.getItem("rayToken")?t.src="https://app.raychat.io/scripts/js/"+o+"?rid="+localStorage.getItem("rayToken")+"&href="+window.location.href:t.src="https://app.raychat.io/scripts/js/"+o;let e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(t,e)}let e=document,a=window,o="368fb28e-375b-4066-828f-94714178ff12";"complete"==e.readyState?t():a.attachEvent?a.attachEvent("onload",t):a.addEventListener("load",t,!1)}();</script> <!END RAYCHAT CODE-->
    <meta property="og:title" content="{{$market->site_title}} | {{$market->name}}  " />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="سوپر مارکت اینترنتی قزوین مارکت" />
    <meta property="og:url" content="https://{{$market->url}}" />
    <meta property="og:site_name" content="سفارش اینترنتی از سوپرمارکت {{$market->name}}" />
    <title>{{$market->site_title}} | {{$market->name}}
        @if(isset($contactUs))- {{$contactUs}}
        @elseif(isset($aboutUs))- {{$aboutUs}}
        @elseif(isset($paypage))- {{$paypage}} @elseif(isset($guide))- {{$guide}} @endif
    </title>
    <meta name="description" content="سوپر مارکت اینترنتی قزوین مارکت" />
    <meta name="keywords" content=" سوپر مارکت اینترنتی قزوین مارکت {{$market->name}}" />
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('fonts/fontawesome5.14.0/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/flexslider.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/pricing.css?v=2')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/jquery.contactus.min.css?v=2')}}" rel="stylesheet" media="all">
    <link href="{{asset('assets/css/generated-desktop.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('assets/css/main.css?v=64')}}" rel="stylesheet" type="text/css">
    @if($uri != 'pay')
        <link href="{{asset('assets/css/style_modal.css')}}" rel="stylesheet" type="text/css">
    @endif
    <link href="{{asset('assets/css/bootstarp-select.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/toastr.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/isotope.pkgd.js')}}"></script>
    @stack('style')
    @if($detect->isMobile())
        <link href="{{asset('UI/mainMobile.css?v=12')}}" rel="stylesheet" type="text/css">
    @endif
    @if($detect->isMobile())
        <link href="{{asset('UI/mainLangMobile.css?v=1')}}" rel="stylesheet" type="text/css">
    @endif
    <style>
        .favorite-default{
            color: white
        }
        .favorite-selected{
            color: red
        }

    </style>
</head>
<body data-spy="scroll" data-target="#template-navbar">
<div class="loader" style="visibility: hidden"></div>
<div id="content">
    <div class="banner-wrapper js__banner-wrapper" style="display: none;" id="banner-show">
        <div class="ios-banner js__ios-banner" style="display: block;">
            <ul class="banner-item">
                <li>
                    <div class="banner-close-wrapper" id="close-banner">
				   <span class="banner-close js__banner-close">
					  <span class="svg-icon-wrapper is-icon-close ">
            <svg xmlns="http://www.w3.org/2000/svg" style="  " viewBox="0 0 32 32">
                <use xlink:href="#icon-close">
                    <path d="M25.344 8.544l-1.888-1.888L16 14.112 8.544 6.656 6.656 8.544 14.112 16l-7.456 7.456 1.888 1.888L16 17.888l7.456 7.456 1.888-1.888L17.888 16z" id="icon-close" ></path>
                </use>
            </svg>
                     </span>
				   </span>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- start of Navigation-->
    <div class="nav-script">
        <nav id="template-navbar" class="navbar navbar-default custom-navbar-default " >
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#Food-fair-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    @if($uri != 'pay')
                        <button class="mobileCartButton hidden-sm hidden-md hidden-lg cartButton cartClass">
                            <span>
                            <i class="fa fa-cart-plus"></i>سبد خرید
                            <span class="badge badge-danger cartNumber">0</span>
                            </span>
                        </button>
                    @else
                        <button class="mobileCartButton hidden-sm hidden-md hidden-lg cartClass " id="emptyCart">
                            <span>خالی کردن سبد خرید</span>
                        </button>
                    @endif
                    <a href="{{route('home.index')}}" >
                        <img id="logo" src='{{url("images/ui_images/Logo_qazvinMarket.png")}}' class="logo-size" alt="logo">
                    </a>
                    <a href="{{url('/')}}" class="button-show" style="display: none;"><span class="back-button button js__ios-banner-trigger">صفحه اول</span></a>
                </div>

                <div class="collapse navbar-collapse" id="Food-fair-toggle">
                    <ul class="nav navbar-nav ">
                        @if($uri != 'pay')
                            <li>
                                <button class="cartButton cartClass hidden-xs">
                                    <span>
                                    <i class="fa fa-cart-plus"></i>سبد خرید
                                    <span class="badge badge-danger cartNumber">0</span>
                                    <span class="badge badge-danger totalPrice">0</span>
                                    تومان
                                    </span>
                                </button>
                            </li>
                        @else
                            <li>
                                <button class="cartClass emptyCart hidden-xs" id="emptyCart" >
                                    <span>خالی کردن سبد خرید</span>
                                </button>
                            </li>
                        @endif
                        <li>
                            <a href="{{route('home.index')}}" style="border: 1px solid #eaeaea;border-radius: 5px;padding: 10px;">
                                صفحه نخست
                            </a>
                        </li>
                        @auth('user')
                            <li>
                                <a style="border: 1px solid #eaeaea;border-radius: 5px;padding: 10px;" href="{{route('dashboard')}}">
                                    <i class="glyphicon glyphicon-user"></i> تنظیمات حساب کاربری
                                </a>
                            </li>
                        @endauth
                        @guest('user')
                            <li>
                                <a style="border: 1px solid #eaeaea;border-radius: 5px;padding: 10px;" class="loginButton" href="" data-check="0" data-toggle="modal"  data-target="#login" id="loginModal">
                                    <i class="glyphicon glyphicon-log-in"></i> ورود
                                </a>
                            </li>
                        @endguest
                        @if($uri != 'contactUs')
                            <li>
                                <a href="{{route('home.ContactUs')}}" style="border: 1px solid #eaeaea;border-radius: 5px;padding: 10px;"> تماس با ما</a>
                            </li>
                        @endif
                        <li>
                            <a href="{{route('home.guideSite')}}" style="border: 1px solid #eaeaea;border-radius: 5px;padding: 10px;"> راهنمای سایت</a>
                        </li>
                    </ul>
                </div>

                <!-- Login -->
                <div class="modal fade " id="login" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;margin-top: 50px;">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h6 class="modal-title" id="exampleModalLabel">ورود به حساب کاربری</h6>
                            </div>
                            <div class="modal-body">
                                <div id="error_login" class="row col-md-12 error-log"></div>
                                <div id="success_login" class="row col-md-12 success-log"></div>
                                <div class="row mtop26">
                                    <div class="col-md-12">
                                        <input required maxlength="11" oninput="maxLengthCheck(this)" id="username" name="username" class="full inputstyle font-ios" type="text" placeholder="تلفن همراه">
                                    </div>
                                </div><br>

                                <div class="form-group btn_loader_o formGroup">
                                    <input class="shadow font-ios" id="btn-login" type="button" value="ارسال کد فعالسازی">
                                    <div class="loader_abs">
                                        <div class="loader">Loading...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Confirm -->
                <div class="modal fade " id="confirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;margin-top: 50px;">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h6 class="modal-title" id="exampleModalLabel">تایید شماره موبایل</h6>
                            </div>
                            <div class="modal-body">
                                <div id="message" class="row col-md-12 error-log"></div>
                                <div id="success_confirm" class="row col-md-12 success-log"></div>
                                <div class="row mtop26">
                                    <div class="col-md-12">
                                        <input required maxlength="11" oninput="maxLengthCheck(this)" id="code" name="code" class="full inputstyle font-ios" type="text" placeholder="کد چهار رقمی">
                                    </div>
                                </div><br>

                                <div class="form-group btn_loader_o formGroup">
                                    <input class="shadow font-ios" id="btn-confirm" type="button" value="ورود">
                                    <div class="loader_abs">
                                        <div class="loader">Loading...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- End of Navigation -->
    @yield('header')
    @yield('content')
    {{--start of footer--}}


    <footer class="footer-bs footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-brand animated fadeInUp">
                    <h2>درباره {{$market->name}}</h2>
                    <p>{{$market->footer_description}}</p>
                </div>
                <div class="col-md-4 footer-nav animated fadeInUp ">
                    <h2>دسترسی سریع به پرتال</h2>
                    <p ><a href="{{route('home.rules')}}"> قوانین و مقررات </a></p>
                    <a href="{{route('home.aboutUs')}}"> | درباره ما</a>
                    <a href="{{route('home.ContactUs')}}"> | تماس با ما</a>
                    <a href="{{route('home.guideSite')}}"> | تلفن همراه</a>
                    <div style="margin-top: 110px;@if ($detect->isMobile()) margin-right: -90px @endif">
                        <div class="col-md-6 styleEnamad " style="@if (!$detect->isMobile()) margin-right: -200px @endif">
                            <img data-original="{{url('/images/ui_images/enamad.png')}}" alt="نماد اعتماد الکترونیکی" onclick="{{$market->enamad_link}}" style="cursor:pointer" @if ( $detect->isMobile() ) class="XWhwiU0zbkTH3qzg1" @else class="XWhwiU0zbkTH3qzg" @endif src="/images/ui_images/enamad.png" id="XWhwiU0zbkTH3qzg">
                        </div>
                        <div class="col-md-6 styleEtehadNamad ">
                            <img data-original="{{url('/images/ui_images/etehadieLogo.png')}}" alt="نماد مجوز کسب و کار مجازی" onclick="{{$market->etehadiye_link}}" style="cursor:pointer" @if ( $detect->isMobile() ) class="XWhwiU0zbkTH3qzg1" @else class="XWhwiU0zbkTH3qzg" @endif id="XWhwiU0zbkTH3qzg" src="/images/ui_images/etehadieLogo.png">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-social animated fadeInDown">
                    <h2>ارتباط با ما</h2>
                    <p class="txt-align-f">{{$market->address}}</p>
                    @if( $market->email != null)
                        <br>
                        <p class="footer-ltr txt-l col-xs-12"><i class="fa fa-envelope"></i> | {{$market->email}}</p><br>
                    @endif
                    @if ( $detect->isMobile()  )
                        <p class="footer-ltr  font-f col-xs-12">
                            <a href="tel:{{$market->tel[0]}}">
                                <i class="fa fa-phone-square"></i> | {{$market->tel[0]}}
                            </a>
                        </p>
                        <br>
                    @else
                        <p class="footer-ltr  font-f col-xs-12" ><i class="fa fa-phone-square"></i> | {{implode(' - ',$market->tel)}}</p><br>
                    @endif

                </div>
            </div>
        </div>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163995311-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-163995311-1');
        </script>
    </footer>

    {{--    <script src="{{asset('assets/js/jquery.min.js')}}"></script>--}}
    <script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script>
    {{--    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>--}}

    <script src="{{url('assets/js/jquery.lazyload.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/typeahead.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/Carousel.js')}}"></script>
    <script src="{{asset('assets/js/slide.js')}}"></script>
    <script src="{{asset('assets/js/jquery.mixitup.min.js')}}"></script>
    <script src="{{asset('assets/js/wow.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.flexslider.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.hoverdir.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jQuery.scrollSpeed.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/enscroll-0.6.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery-validate.bootstrap-tooltip.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery-scrolltofixed-min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap-select.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.sticky-kit.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap-rating-input.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.mobile-1.4.5.js')}}"></script>
    <script src="{{asset('assets/js/jquery.contactus.min.js')}}"></script>
    <script src="{{asset('assets/js/script.js')}}">  scroll_it = scroll_it_wobble </script>
    @stack('script')
    <script>
        $(document).on("click","#q",function () {
            $(".search-box-opacity").show();
            $('body').css({'overflow':'hidden'});
            $("#search").focus();
        });
        $(document).ready(function() {
            $("img").lazyload({
                effect: "fadeIn"
            });
            let scroll_start = 0;
            let startchange = $('#startchange');
            let offset = startchange.offset();
            if (startchange.length) {
                $(document).scroll(function () {
                    scroll_start = $(this).scrollTop();
                    if (scroll_start > offset.top) {
                        $(".navbar-default").css('background-color', '#ffffffe6').addClass("scrolled");
                    } else {
                        $('.navbar-default').css('background-color', '#fff').removeClass("scrolled");
                    }
                });
            }

            $('#username').on('keyup', function (e) {
                if (e.keyCode === 13) {
                    $('#btn-login').click();
                }
            });

            $('#password').on('keyup', function (e) {
                if (e.keyCode === 13) {
                    $('#btn-login').click();
                }
            });

            $("#a_login_submit").click(function () {
                $('#myModal').modal('hide');
//            document.body.style.overflowY = 'hidden';
                setTimeout(function () {
                    $('#login').modal('show');
                }, 500)
            });




            $("#setCity").click(function () {
                $.ajax({
                    type: "GET",
                    url: "{{url('setCity')}}" + '/' +$('#city_id').val(),
                    success: function (data) {
                        $('#mycity').modal('hide');
                        location.reload();
                    }
                });
            });

            $("#btn-login").click(function () {
                let username = $("#username").val();
                if ((username.length<11 ) ) {
                    $("#error_login").html("موبایل را بدرستی وارد نمایید.");
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{url('api/v1/register')}}",
                        data: {username: username},
                        success: function (data) {
                            $('#login').modal('hide');
                            $('#confirm').modal('show')
                            localStorage.setItem('mobile',username)
                        },
                        error:function (response) {
                            $('#error_login').show().text(response.responseJSON.message);

                        }
                    });
                }
            });
            $("#btn-confirm").click(function () {
                let code = $("#code").val();
                if ((code.length!==4)) {
                    $("#error_login").html("کد فعالسازی را بدرستی وارد نمایید.");
                } else {
                    let addresses=[];
                    if(localStorage.getItem('addresses')!=null)
                        addresses=JSON.parse(localStorage.getItem('addresses'))
                    $.ajax({
                        type: "POST",
                        url: "{{url('api/v1/verify_activation_code')}}",
                        data: {confirm_code: code,
                            username:localStorage.getItem('mobile'),
                            "_token": "{{ csrf_token() }}",
                            addresses
                        },
                        success: function (data) {
                            if (data.status === "ok") {
                                $("#code").val('');
                                localStorage.setItem('token',data.data.token)
                                localStorage.setItem('wallet',data.data.wallet)
                                localStorage.setItem('birthday',data.data.birthday)
                                localStorage.setItem('points',data.data.points)
                                localStorage.setItem('username',data.data.username)
                                localStorage.setItem('mobile',data.data.mobile)
                                localStorage.setItem('addresses',JSON.stringify(data.data.addresses));
                                localStorage.setItem('favorites',JSON.stringify(data.data.favorites));
                                localStorage.setItem('orderCount',(data.data.orderCount));
                                localStorage.setItem('transactionCount',(data.data.transactionCount));
                                localStorage.setItem('wallet_amount',(data.data.wallet));
                                localStorage.setItem('cargos',JSON.stringify(data.data.cart));
                                _cartCount();
                                $.ajax({
                                    type: "POST",
                                    url: "{{url('userLogin')}}",
                                    data: {username: data.data.mobile,password:code,"_token": "{{ csrf_token() }}"},
                                    success: function (result) {
                                        window.location.reload();
                                    },
                                    error:function(result){
                                        $('#message').html('خطایی رخ داد. لطفاً مجدداً تماش نمایید.')
                                    }
                                });
                                $('#confirm').modal('hide')

                            }else {
                                for (let key in data.message) {
                                    $('#success_login').hide();
                                    $('#error_login').show().text(data.message[key]);
                                }

                            }
                        },
                        error:function (response) {
                            $('#message').html(response.responseJSON.message)
                        }
                    });
                }
            });
            function loginButton(check) {
                if (check===1){
                    $("#error_login").html('شما ابتدا باید وارد سایت شوید.');
                    $('#giftModal').modal('hide');
                    setTimeout(function () {
                        $('#login').modal('show');
                    }, 500);
                }
                else {
                    $("#error_login").html('');
                }

            }
            _cartCount();

        });
        function maxLengthCheck(object) {
            if (object.value.length > object.maxLength)
                object.value = object.value.slice(0, object.maxLength)
        }


        $('#register_phone').keypress(function (event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57) && (event.which < 1776 || event.which > 1785)) {
                event.preventDefault();
            }
        });

        $('#username').keypress(function (event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57) && (event.which < 1776 || event.which > 1785)) {
                event.preventDefault();
            }
        });

        $('.cartButton').click(function () {
            if ($('.cartNumber').text()>0)
                window.location = "{{route('pay.index')}}";
            else
                toastr.error( 'سبد خرید شما خالی است.','',{timeOut:5});
        });

        $('#closeElement').click(function () {
            $('#delayLinkContent').remove();
            document.cookie = "delay_order=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

        });
        $(document).on('click','#emptyCart',function(e) {
            e.preventDefault();
            Swal({
                title: 'آیا مطمئن هستید؟',
                text: '',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'بله',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.value) {
                    let token=localStorage.getItem('token');
                    localStorage.setItem('cargos','[]');
                    if(token!==null){
                        $.ajax({
                            type: "POST",
                            url: "/api/v1/empty_cart",
                            data:{'token':token,'_method':'DELETE'},
                            success: function (response) {
                                window.location.replace('/')
                            }
                        });
                    }
                    window.location.replace('/')


                }
            })


        });


        function formatPrice(num)
        {
            let num_parts = num.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return num_parts.join(".");
        }
        function truncate(str, n){
            return (str.length > n) ? str.substr(0, n-1) + '&hellip;' : str;
        }

        function _remove(id) {
            if(confirm('آیا از حذف این مورد اطمینان دارید؟')){
                let cargos=JSON.parse(localStorage.getItem('cargos'));
                let token=localStorage.getItem('token')
                cargos.splice(cargos.findIndex(x=>x.id===id),1)
                localStorage.setItem('cargos',JSON.stringify(cargos));
                $.ajax({
                    headers:{"Authorization":"Bearer "+localStorage.getItem('token')},
                    type: "Post",
                    url: "{{url('/api/v1/remove_from_cart')}}",
                    data: {cargo:id , token,count:0},
                    success: function (response) {
                        if (response.status==='ok'){
                            toastr.error($('#f'+id).text() + ' از سبد خرید شما حذف شد.','',{timeOut:2000});
                            _cartCount();
                            _calculateShipment()
                            render_cargos_pay()
                            if(JSON.parse(localStorage.getItem('cargos')).length<1)
                                window.location.replace('/')
                        }
                        else{
                            toastr.error(response.message,'',{timeOut:500});
                        }
                    },
                    error:function () {
                        alert('خطایی رخ داد! لطفاً با پشتیبانی تماس بگیرید')
                    }
                });
            }
        }
        $(document).on('click','.decrease',function () {
            let id=$(this).data("id")
            let max=parseInt($('#max'+id).val());
            let count=Number($(this).next().first().text())-1;
            if ($(this).data("dir")==="rtl"){
                count=Number($(this).prev().first().text())-1
            }
            let token=localStorage.getItem('token')
            if((isNaN(count) ||( max===0 && count<0)))
                toastr.error('موجودی کالا، '+max+' عدد است.','',{timeOut:500});
            else{
                $.ajax({
                    headers:{"Authorization":"Bearer "+localStorage.getItem('token')},
                    type: "Post",
                    url: "{{url('/api/v1/remove_from_cart')}}",
                    data: {cargo:id , token,count:1},
                    success: function (response) {
                        if (response.status==='ok'){
                            let removed=response.data;
                            if(localStorage.getItem('cargos')!== null){
                                let cargos=JSON.parse(localStorage.getItem('cargos'));
                                let exists = cargos.filter(cargo => (cargo.id === removed.id));
                                if(exists.length===1){
                                    if(exists[0].count===1){
                                        cargos.splice(cargos.findIndex(x=>x.id===removed.id),1)
                                    }else if(exists[0].count>1){
                                        removed.count=exists[0].count-1;
                                        cargos[cargos.findIndex(x=>x.id===removed.id)]=removed;
                                    }
                                }
                                localStorage.setItem('cargos',JSON.stringify(cargos));
                            }
                            toastr.error($('#f'+id).text() + ' از سبد خرید شما حذف شد.','',{timeOut:2000});
                            if(count>=0)
                                $(".cargo_"+id).text(count);
                            _cartCount();
                            _calculateShipment()
                            render_cargos_pay()
                            if(JSON.parse(localStorage.getItem('cargos')).length<1)
                                window.location.replace('/')
                        }
                        else{
                            toastr.error(response.message,'',{timeOut:500});
                        }
                    },
                    error:function () {
                        alert('خطایی رخ داد! لطفاً با پشتیبانی تماس بگیرید')
                    }
                });
            }
        })
        $(document).on('click','.increase',function () {
            let cargo=$(this).data("id")
            let max=parseInt($('#max'+cargo).val());
            let count=Number($(this).prev().first().text())+1;
            if ($(this).data("dir")==="rtl"){
                count=Number($(this).next().first().text())+1
            }
            let token=localStorage.getItem('token');
            if((isNaN(count) && max===0) || count>max)
                toastr.error('موجودی کالا، '+max+' عدد است.','',{timeOut:500});
            else{
                $.ajax({
                    headers:{"Authorization":"Bearer "+localStorage.getItem('token')},
                    type: "Post",
                    url: "{{url('/api/v1/add_to_cart')}}",
                    data: {cargo,token,count},
                    success: function (response) {
                        if (response.status==='ok'){
                            let added=response.data;
                            if(localStorage.getItem('cargos')=== null){
                                let cargos=[];
                                added.count=1;
                                cargos.push(added)
                                localStorage.setItem('cargos',JSON.stringify(cargos));
                            }else{
                                let cargos=JSON.parse(localStorage.getItem('cargos'));
                                let exists = cargos.filter(cargo => (cargo.id === added.id));
                                if(exists.length===1){
                                    added.count=exists[0].count+1;
                                    cargos[cargos.findIndex(x=>x.id===added.id)]=added;
                                }else{
                                    added.count=1;
                                    cargos.push(added)
                                }
                                localStorage.setItem('cargos',JSON.stringify(cargos));
                            }
                            toastr.success($('#f'+cargo).text() + ' به سبد خرید شما اضافه شد.','',{timeOut:2000});
                            $(".cargo_"+cargo).text(count);
                            _cartCount();
                            render_cargos_pay()
                            _calculateShipment()
                            _wallet()
                        }
                        else{
                            toastr.error(response.message,'',{timeOut:500});
                        }
                    },
                    error:function (response) {
                        toastr.warning(response.responseJSON.message,'',{timeOut:500});
                    }
                });
            }
        })

        function _wallet() {
            if(localStorage.getItem('token')!=null){
                let token=localStorage.getItem('token');
                $.ajax({
                    type: "GET",
                    url: "/api/v1/profile",
                    data:{'token':token},
                    success: function (response) {
                        if(response.status==='ok'){
                            localStorage.setItem('wallet',response.user.wallet);
                            let invoicePrice=parseInt(localStorage.getItem('totalPrice'))+parseInt($('#peyk_price').text())+parseInt($('#tower').val()==="0"?0:1000)
                            $('#wallet').text(formatPrice(response.user.wallet))
                            if(invoicePrice>parseInt(response.user.wallet)){
                                $('#walletMethod').prop('disabled',true);
                            }else{
                                $('#walletMethod').prop('disabled',false);
                            }
                        }
                    }
                })
            }
        }
        function _cartCount() {
            if(localStorage.getItem('cargos')!==null){
                let cargos=JSON.parse(localStorage.getItem('cargos'))
                let totalPrice=0;
                let totalLength=0;
                $.each(cargos,function (key,item) {
                    totalPrice+=parseInt(item.main_price)*parseInt(item.count);
                    totalLength+=parseInt(item.count);

                })
                localStorage.setItem('totalPrice',totalPrice);

                $('.cartNumber').html(totalLength)
                $('.totalPrice').html(totalPrice)

            }
        }
        function render_cargos_pay(){
            if(localStorage.getItem('cargos')!=null) {
                let cargos = JSON.parse(localStorage.getItem('cargos'));
                $.ajax({
                    headers:{"Authorization":"Bearer "+localStorage.getItem('token')},
                    url:"/api/v1/sync_cart",
                    data:{cargos},
                    method:"POST",
                    success:function (response) {
                        localStorage.setItem('cargos',JSON.stringify(response.cart))
                        let data = '';
                        let totalPrice_without_saleoff=0;
                        let totalPrice=0;
                        cargos=response.cart;
                        $.each(cargos, function (key, item) {
                            data+=`<div class="col-lg-3 col-sm-3 col-xs-6 ${item.max_count=== 0?' finished-p-visibility':''}">`;
                            data+=`<div class="product-box border-rad-img" style="${item.main_price !==item.price?'background-color: #f5d8d891;box-shadow: 0px 3px 16px 7px #948e8e82':'background-color:#ffefc1;box-shadow: 0px 3px 16px 7px #948e8e82;'}">`;
                            data+=`<div class="label-danger" style="font-size:20px;position: absolute;top: 1px;transform: rotate(20deg);padding: 4px;border-radius: 10px 10px 10px 10px;visibility: ${item.saleOff>0?'visible':'hidden'}">${item.saleOff>0?item.saleOff+'%':''}</div>`;
                            data+=`<div class="favorite ${item.is_favorite?'favorite-selected':'favorite-default'}" style="position: absolute;top: 8px;left: 30px;font-size: 30px;text-shadow: 0 0 3px #000;stroke: black;stroke-width: 2px;" title="افزودن به علاقه مندی ها" data-cargo="${item.id}"><span class="fa fa-heart"></span></div>`;
                            data+=`<img src="${item.image}" alt="${item.name}"/>`;
                            data+=`<div class="product-name text-center">`;
                            data+=`<span id="f${item.id}">${item.name}</span><br>`;
                            data+=`</div>`;
                            data+=`<div class="text-nowrap text-center priceDiscount">`;
                            data+=`<div class="pricemenu">${item.price!==item.price?formatPrice(item.price)+' '+'تومان':''}</div>`;
                            data+=`<div dir="rtl">${item.saleOff>0?'<span class="pricemenu">'+formatPrice(item.price)+' '+'تومان'+'</span>':''} ${formatPrice(item.main_price)}${' '+'تومان'}</div>`;
                            data+=`</div>`;
                            data+=` <div class="text-center" style="font-size: 18px;margin-bottom: 15px">`;
                            data+=`${item.max_count>0?'<a class="increase" data-dir="rtl" data-id="'+item.id+'"><i class="fa fa-plus-square fa-lg" style="cursor: pointer; font-size:1.5em;margin-left: 5px"></i></a><span style="font-size: 30px;" class="cargo_'+item.id+'">'+item.count+'</span><a class="decrease" data-dir="rtl"  data-id="'+item.id+'"><i class="fa fa-minus-square fa-lg" style="cursor: pointer; font-size:1.5em;margin-right: 5px;"></i></a>':'<div class="finish-product">تمام شده!</div>'}`;
                            data+=`</div>`;
                            data+=`<div class="label-success" style="margin: 0 auto;">جمع کل: ${formatPrice(item.count*item.main_price)} تومان</div>`;
                            data+=`<div class="btn btn-sm btn-danger" onclick="_remove(${item.id})" style="margin: 0 auto;"><i class="fas fa-trash" ></i></div>`;
                            data+=`</div></div>`;
                            totalPrice_without_saleoff+=item.price*item.count;
                            totalPrice+=item.main_price*item.count
                        });
                        $('#cargo_list').html(data)
                        localStorage.setItem('totalPrice',totalPrice)
                        $('#totalPrice').html(totalPrice)
                        $('#totalPrice_without_saleoff').html(totalPrice_without_saleoff)
                        $('#total_dicount').html(totalPrice_without_saleoff-totalPrice)
                        $('#priceUnit').html(localStorage.getItem('priceUnit'))
                    },
                    error:function (response) {
                        alert(response.responseText.message)
                    }
                })
                if (JSON.parse(localStorage.getItem('cargos')).length<1){
                    window.location.replace('/')
                }
            }else{
                window.location.replace('/')
            }
        }
        function _calculateShipment() {
            let url = window.location.href;
            let a = $('<a>', {
                href: url
            });
            let menu_id=a.prop("pathname").split("/");
            if (menu_id[1]==='pay'){
                let peyk_id=0;
                $('.addressColor').removeStyle('background-color')
                $("input:radio[name=address]:checked").each(function () {
                    peyk_id= $(this).data('zones');
                    $(this).parent().parent().find("input:nth-child(2)").css('background-color','#a7eea0');

                });
                let sendMethod='express';
                $("input:radio[name=sendMethod]:checked").each(function () {
                    sendMethod= $(this).data('type');
                });
                // let tower=$("#tower").is(":checked");
                if (peyk_id===14){
                    $('#addressDiv').hide();
                    $('#addressHozuri').show();
                    $('#peyk_time_show').hide();
                }
                else
                {
                    if(peyk_id === 0 || sendMethod){
                        $('#peyk_time_show').hide();
                        $('#addressHozuri').hide();
                        $('#addressDiv').show();
                    }
                    else{
                        $('#addressHozuri').hide();
                        $('#addressDiv').show();
                        $('#peyk_time_show').show();
                    }
                }
                let totalPrice=Number(localStorage.getItem('totalPrice'))

                $.ajax({
                    type: "GET",
                    data: { peyk_id,totalPrice,
                        // tower:tower ,
                        totalPrice_without_saleoff: Number($('#totalPrice_without_saleoff').html()),sendMethod},
                    url: "{{url('/api/v1/calculateShipment')}}",
                    success: function(data) {
                        if (data.status==='ok'){
                            $('#peyk').val(peyk_id);
                            $('#peyk_price').html(data.data.price);
                            $('#p_show').text(data.data.p);
                            $('#peyk_time').text(data.data.peykTime);
                            $('#p').val(data.data.p);
                            $('#totalPrice').text(data.data.totalPrice);
                        }
                    }
                });
                _wallet()
            }
        }

        let scrollMobile=false;
        let totalPages=0;
        let page=1;
        let url = window.location.href;
        let a = $('<a>', {
            href: url
        });
        let menu_id=a.prop("pathname").split("/");
        let prev_parent_id=menu_id[2];
        let current_parent_id=menu_id[2];

        $(document).ready(function () {
            $(document).on('click','.liParent',function(){
                current_parent_id = $(this).attr('id');
                if(current_parent_id!==prev_parent_id){
                    page=1;
                }
                $(".foodContent").html("");
                let url = window.location.href;
                let a = $('<a>', {
                    href: url
                });
                let menu_id=a.prop("pathname").split("/");
                if (menu_id.length>1&& menu_id[1]==='menu'){
                    _load_food(current_parent_id, 1, 1, page,'', 0);
                }
                $('.liParent').removeClass('active-menu');
                $(this).addClass('active-menu');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#foodContentScroll").offset().top
                }, 1000);
            });
            _load_food = function(parent_id,market_id,type,page,keyword,search){
                let    url="/api/v1/cargo?";
                prev_parent_id=parent_id;
                if(search===1){
                    url="/api/v1/search?";
                }
                $.ajax({
                    headers:{"Authorization":"Bearer "+localStorage.getItem('token')},
                    type: "GET",
                    url:url ,
                    data: {market_id,parent_id,type,page,'q':keyword},
                    success: function (result) {
                        if (result.paginate.current>=result.paginate.last_page){
                            $("#paginate").hide();
                        }else {
                            $("#paginate").show();
                        }
                        let data='';
                        let added_count=0;
                        let cargos=[];
                        if(localStorage.getItem('cargos')!=null){
                            cargos=JSON.parse(localStorage.getItem('cargos'))
                        }
                        localStorage.setItem('priceUnit',result.priceUnit);
                        $.each(result.cargos, function (key, item) {
                            if(cargos.findIndex(x=>x.id===item.id)>=0){
                                added_count=cargos[cargos.findIndex(x=>x.id===item.id)].count
                            }else{
                                added_count=0
                            }
                            data+=`<div class="col-lg-2 col-sm-3 col-xs-6 ${item.max_count=== 0?' finished-p-visibility':''}" >`;
                            data+=`<div class="product-box border-rad-img" style="height:550px; ${item.main_price !==item.price?'background-color: #f5d8d891;box-shadow: 0px 3px 16px 7px #948e8e82':'background-color:#ffefc1;box-shadow: 0px 3px 16px 7px #948e8e82;'}">`;
                            data+=`<div class="label-danger" style="font-size:20px;position: absolute;top: 1px;transform: rotate(20deg);padding: 4px;border-radius: 10px 10px 10px 10px;visibility: ${item.saleOff>0?'visible':'hidden'}">${item.saleOff>0?item.saleOff+'%':''}</div>`;
                            data+=`<div class="favorite ${item.is_favorite?'favorite-selected':'favorite-default'}" style="position: absolute;top: 8px;left: 30px;font-size: 30px;text-shadow: 0 0 3px #000;stroke: black;stroke-width: 2px;" title="افزودن به علاقه مندی ها" data-cargo="${item.id}"><span class="fa fa-heart"></span></div>`;
                            data+=`<img src="${item.image}" alt="${item.name}" height="300px" />`;
                            data+=`<div class="product-name text-center">`;
                            data+=`<span id="f${item.id}">${item.name}</span><br>`;
                            data+=`</div>`;
                            data+=`<div class="text-nowrap text-center priceDiscount">`;
                            data+=`<div class="pricemenu">${item.price!==item.price?formatPrice(item.price)+' '+result.priceUnit:''}</div>`;
                            data+=`<div dir="rtl">${item.saleOff>0?'<span class="pricemenu">'+formatPrice(item.price)+' '+result.priceUnit+'</span>':''} ${formatPrice(item.main_price)}${' '+result.priceUnit}</div>`;
                            data+=`</div>`;
                            data+=` <div class="text-center" style="font-size: 18px;margin-bottom: 15px">`;
                            data+=`${item.max_count>0?'<a class="increase" data-dir="rtl" data-id="'+item.id+'"><i class="fa fa-plus-square fa-lg" style="cursor: pointer; font-size:1.5em;margin-left: 5px"></i></a><span style="font-size: 30px;" class="cargo_'+item.id+'">'+added_count+'</span><a  class="decrease" data-dir="rtl" data-id="'+item.id+'"><i class="fa fa-minus-square fa-lg" style="cursor: pointer; font-size:1.5em;margin-right: 5px;"></i></a>':'<div class="finish-product">تمام شده!</div>'}`;
                            data+=`</div></div></div>`;
                        });
                        if (search===0) {
                            $("#foodContentScroll").append(data).fadeIn("slow");
                        }else {
                            if (result.cargos.length ===0){
                                $(".show-search-result").html("<div class='alert alert-danger' style='margin-top: 30px'>محصولی در این دسته موجود نیست.</div>").show().fadeIn("slow");
                            }else {
                                $(".show-search-result").html(data).fadeIn("slow");
                            }
                        }
                    },
                    error:function () {
                        $("#foodContentScroll").html('<a class="btn btn-warning" style="height: 35px" onclick="_load_food(2690,1,0,0,\' \',0)"><i class="fas fa-repeat"></i>تلاش مجدد</a>').show().fadeIn("slow");
                    }
                });
            };

            _search=function () {
                let keyword=$('#search').val();
                if(keyword.length>=3)
                    _load_food(1, 1, 0, 0, keyword,1)
            }
            $("#q").click(function () {
                $(".search-box-opacity").show();
                $('body').css({'overflow':'hidden'});
                $("#q").focus();
            });

            $("#back-arrow").click(function () {
                $(".search-box-opacity").hide();
                $('#q').val('');
                _load_food(menu_id[2],1,0,0,'',0);
                $('body').css({'overflow':'auto'});

            });
            if ( window.location.pathname !== '/' &&   window.location.pathname!=='/pay' ){
                setTimeout(function(){
                    _load_food(menu_id[2],1,0,1,'',0);
                }, 1000);
            }
        });
        $(window).scroll(function() {
            let url = window.location.href;
            let a = $('<a>', {
                href: url
            });
            let menu_id=a.prop("pathname").split("/");
            if ((menu_id.length>1&& menu_id[1]==='menu')){
                let offset=$("#paginate").offset().top - $(window).scrollTop()
                if (offset>=600 && offset<=620) {
                    page += 1;
                    _load_food(current_parent_id, 1, 0, page, '', 0);
                }
            }
        });
        $(document).on('click','.favorite',function(){
            let element=$(this);
            let cargo=element.data('cargo')
            if (localStorage.getItem('cargos')!=null) {
                let local_cargos = JSON.parse(localStorage.getItem('cargos'))
                if (local_cargos.findIndex(x => x.id === cargo) > -1) {
                    selected_cargo = local_cargos[local_cargos.findIndex(x => x.id === cargo)]
                    if(selected_cargo.is_favorite===false){
                        selected_cargo.is_favorite=true;
                    }else{
                        selected_cargo.is_favorite=false;
                    }
                }
                localStorage.setItem('cargos', JSON.stringify(local_cargos))
            }
            $.ajax({
                url:`/api/v1/favorite?cargo=${cargo}`,
                method:"POST",
                data:{"token":localStorage.getItem('token')},
                success:function(){
                    if (element.hasClass('favorite-default')){
                        element.removeClass('favorite-default')
                        element.addClass('favorite-selected')
                    }else{
                        element.removeClass('favorite-selected')
                        element.addClass('favorite-default')
                    }
                },
                error:function(){
                    alert('خطایی رخ داد! لطفا مجددا تلاش نمایید')
                }
            })
        })
        _loadMarketInfo=function() {
            $.ajax({
                type: "GET",
                url:'/api/v1/market_info',
                success:function (index) {
                    let holiday=index.market_info.holiday;
                    let timing_info=``;
                    if (index.market_info.service===0){
                        timing_info=`<p>ارسال سفارش بدلیل «${index.market_info.why_off}» امکانپذیر نیست.</p>`
                    }else if(holiday===false){
                        timing_info=`<p>ساعات فعالیت ${index.market_info.open_time} تا ${index.market_info.close_time}
                                 تحویل فوری سفارشات در کمتر از یک ساعت - ${index.market_info.percent_of_free_shipping===100?'ارسال رایگان ':index.market_info.percent_of_free_shipping+'درصد تخفیف ارسال'}  برای سفارشات بالای ${formatPrice(index.market_info.min_price_to_free_shipping)} تومان
                            </p>`;
                    }else{
                        timing_info=`<p>از تاریخ: ${holiday.start} تا تاریخ: ${holiday.end} بدلیل «${holiday.why_off}» ارسال سریع سفارش امکانپذیر نیست.</p>`
                    }
                    $('#timing_info').html(timing_info)
                    localStorage.setItem('open_time',index.market_info.open_time)
                    localStorage.setItem('close_time',index.market_info.close_time)
                    localStorage.setItem('express',index.market_info.shipping_methods.express)
                    localStorage.setItem('scheduled',index.market_info.shipping_methods.scheduled)
                    localStorage.setItem('cash',index.market_info.payment_methods.cash)
                    localStorage.setItem('ipg',index.market_info.payment_methods.ipg)
                    localStorage.setItem('wallet',index.market_info.payment_methods.wallet)
                    localStorage.setItem('holiday',index.market_info.holiday)
                    localStorage.setItem('priceUnit',index.market_info.priceUnit)
                },
                error:function () {
                    $("#timing_info").html('<a class="btn btn-warning" style="height: 35px" onclick="_loadMarketInfo()"><i class="fas fa-repeat"></i>تلاش مجدد</a>').show().fadeIn("slow");

                }
            })
        }
    </script>
</div>
</body>
</html>
