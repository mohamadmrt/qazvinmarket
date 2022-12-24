@extends('home.master')
@section('content')
    <style>
        #paginate {
            border: 4px solid #f3f3f3; /* Light grey */
            border-top: 4px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    {{--Start Of Header--}}
    <? $detect = new Mobile_Detect;?>
    <section class="home-section section-hero overlay slanted" id="home-section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-12 text-center">
                    <h1>@lang('messages.master.47')</h1>
                    <div class="mx-auto w-75 active-time">
                        <p>@lang('messages.master.48')</p>
                    </div>
                    <div class="mx-auto w-75 text-p" id="timing_info">
                    </div>
                    <br>
                    <?     $uri=\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri(); ?>
                    <div class="frmSearch" @if($detect->isMobile() and $uri != '/') data-spy="affix" data-offset-top="197" @endif>
                        <div class="row">
                            <div>
                                <input class="col-xs-8 col-xs-offset-2 quicksearch search-box-style" id="q"
                                       name="search" value="" placeholder="@lang('messages.master.49')" autocomplete="off">
                            </div>
                            <br>
                        </div>
                    </div>

                    <div style="display: none;" class="search-box-opacity">
                        <div class="above-page-search">
                            <div class="btn-group btnGroupStyle">
                                <button class="btn backButton" id="back-arrow">
                <span>
                    <i class="fa fa-arrow-circle-right"></i> برگشت
                </span>
                                </button>
                                <button class="mobileCartButton cartButton cartClass" style="float: none !important;">
                <span>
                    <i class="fa fa-cart-plus"></i> @lang('messages.master.44')
                    <span class="badge badge-danger cartNumber">0</span>
                </span>
                                </button>
                            </div>

                            <div class="searchBox">
                                <div class="col-xs-9 col-xs-offset-1 col-md-8 col-md-offset-2 frmSearch" data-offset-top="197">
                                    <div>
                                        <input class="quicksearch search-box-style" style="width: 100%;" id="search" onkeyup="_search(1)"
                                               name="search" value=""  placeholder="@lang('messages.master.49')" autofocus autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div style="display: none;" class="show-search-result">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- IMAGE -->
        <div class="video-container">
            <img src="{{url('images/ui_images/header/header-market.jpg')}}" alt="">
        </div>
        <a href="#about-us-section" class="scroll-button smoothscroll">
            <span class=" icon-keyboard_arrow_down"></span>
        </a>

    </section>

    {{--End Of Header--}}
    <div class="container-fluid m-top"  data-sticky_parent style="font-size:15pt;">
        <div class="col-md-2 hidden-sm hidden-xs side-top">
            <div class="SubCategoryList sc-gPzReC">
                <h2>دسته بندی ها</h2>
                {{--                <hr style="background-color: black !important;">--}}
                <nav id="sidebar">
                    <div class="p-4 pt-5">
                        <ul class="list-unstyled components mb-5" id="sidebar-menus">
                            <li class="liOfParent">
                                <a href="#" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed liParent">
                                    <span class="fa fa-chevron-left mr-2 ml-2"></span>
                                    <span class="color-white">  درحال دریافت اطلاعات</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        {{--Start Of Menu Content--}}
        <div  class="col-md-10 col-xs-12  bg-white minHeight" data-sticky_column id="point1">
            <div class="bg-white">
                <div class="tab-content" dir="rtl">
                    <div id="home" class="tab-pane fade active in">
                        <div id="home" class="tab-pane fade in active">
                            <div class="row" id="section" style="font-size: 14px;margin-bottom: 20px">
                                <div class="container">
                                    <div class="row">
                                        <div class="hidden-md hidden-lg" id="contentParent">
                                            <ul class="bar-menu" id="bar-menu">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid foodContent" id="foodContentScroll" style="display: flex;flex-wrap: wrap;">
                                </div>
                                <div style="margin: auto;width: 50%;"><div  id="paginate"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--End Of Menu Content--}}
    </div>

    <a href="#" class="back-to-top btn-primary btT-s">
        @if($detect->isMobile()) <span>برو به سبد خرید</span> @else <span>مشاهده سبد خرید</span> @endif
    </a>

@endsection
@push('script')
    <script>


        $(document).ready(function(){
            if (localStorage.getItem('open_time')!==null && localStorage.getItem('close_time')!==null){
                $('#open_time').text(localStorage.getItem('open_time'))
                $('#close_time').text(localStorage.getItem('close_time'))
            }else{
                window.location.replace('/')
            }
            _loadSideBar=function(){
                $.ajax({
                    method: 'GET',
                    url: "/api/v1/menu",
                    data:[],
                    success:function (menus) {
                        let desktop_menu=``;
                        let mobile_menu=``;
                        let dataToShow=menus.menus;
                        $.each(dataToShow,function (key,menu) {
                            desktop_menu+=`<li class="liOfParent" id="li_${menu.id}">`;
                            desktop_menu+=`<a href="#pageSubmenu${key}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed liParent" id="${menu.id}">`;
                            desktop_menu+=`<span class="fa fa-chevron-left mr-2 ml-2"></span>`;
                            desktop_menu+=`<span class="color-white">${menu.name}</span>`;
                            desktop_menu+=`</a>`;
                            desktop_menu+=`<ul class="list-unstyled collapse" id="pageSubmenu${key}">`;
                            mobile_menu+=`<li data-toggle="collapse" data-target="#demo${menu.id}" class="liMobile" id="liMobile_${menu.id}"><span class="fa fa-chevron-left mr-2 ml-2"></span> ${menu.name} </li><div id="demo${menu.id}" class="collapse"><ul>`
                            $.each(menu.subMenus,function (index,item) {
                                desktop_menu+=`<li class="liOfParent"  id="li_${item.id}">`;
                                desktop_menu+=`<a href="#pageSubmenu${'0'+index}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle  liParent"  id="${item.id}">`;
                                desktop_menu+=`<span class="fa fa-chevron-left color-white ml-2" style='margin-right: 4rem;'></span>`;
                                desktop_menu+=`<span class="color-white">${item.name}</span>`
                                desktop_menu+=`</a>`;
                                mobile_menu+=`<li data-toggle="collapse" data-target="#demo${item.id}" class="liMobile" id="liMobile_${item.id}"><span class="fa fa-chevron-left mr-2 ml-2"></span>${item.name}</li>`
                            });
                            desktop_menu+=`</ul></li>`
                            mobile_menu+=`</ul></div>`;
                        });
                        $('#sidebar-menus').html(desktop_menu);
                        $('#bar-menu').html(mobile_menu);
                    },
                    error:function () {
                        $('#sidebar-menus').html('<a class="btn btn-warning" style="height: 35px" onclick="_loadSideBar()"><i class="fas fa-repeat"></i>تلاش مجدد</a>').show().fadeIn("slow");
                    }
                })
            }
            setTimeout(function(){
                _loadMarketInfo()
                _loadSideBar();
            }, 1);
            let offset = 400;
            $(window).scroll(function() {
                if ($(this).scrollTop() > offset)
                    $('.back-to-top').fadeIn(400);
                else
                    $('.back-to-top').fadeOut(400);
            });
            $('.back-to-top').click(function(event) {
                event.preventDefault();
                $('html, body').animate({scrollTop: 0}, 600);
                return false;
            });
        });
        $(window).scroll(function() {
            let offset=$("#paginate").offset().top - $(window).scrollTop()
            if (offset>=600 && offset<=620){
                page+=1;
                _load_food(current_parent_id,1,0,page,'',0);

            }
        });
        _loadMarketInfo=function() {
            $.ajax({
                type: "GET",
                url:'/api/v1/market_info',
                success:function (index) {
                    if (index.status === "ok") {
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
                    }else{
                        $('#timing_info').html('خطا در دریافت اطلاعات.');
                    }
                },
                error:function () {
                    $("#timing_info").html('<a class="btn btn-warning" style="height: 35px" onclick="_loadMarketInfo()"><i class="fas fa-repeat"></i>تلاش مجدد</a>').show().fadeIn("slow");

                }
            })
        }
    </script>

@endpush

