@extends('home.master')
@push('style')
    <link href="{{asset('assets/css/index.css?v=1')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
    <style>
        .favorite-default{
            color: white
        }
        .favorite-selected{
            color: red
        }

    </style>
@endpush
@section('content')
    {{--Start Of Header--}}
    <section class="home-section section-hero overlay slanted" id="home-section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-12 text-center">
                    <h1>قزوین مارکت</h1>
                    <div class="mx-auto w-75 active-time">
                        <p>سوپر مارکت اینترنتی و تلفنی قزوین</p>
                    </div>
                    <div class="mx-auto w-75 text-p" id="timing_info">
                    </div>
                    <br>
                    <?     $uri=\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri(); ?>
                    <div class="frmSearch" @if($detect->isMobile() and $uri != '/') data-spy="affix" data-offset-top="197" @endif>
                        <div class="row">
                            <div>
                                <input class="col-xs-8 col-xs-offset-2 quicksearch search-box-style" id="q"
                                       name="search" value="" placeholder="جستجوی کالا" autocomplete="off">
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
                    <i class="fa fa-cart-plus"></i> سبد خرید
                    <span class="badge badge-danger cartNumber">0</span>
                </span>
                                </button>
                            </div>

                            <div class="searchBox">
                                <div class="col-xs-9 col-xs-offset-1 col-md-8 col-md-offset-2 frmSearch" data-offset-top="197">
                                    <div>
                                        <input class="quicksearch search-box-style" style="width: 100%;" id="search" onkeyup="_search(1)"
                                               name="search" value=""  placeholder="جستجوی کالا" autofocus autocomplete="off">
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
        <div class="video-container">
            <img src="{{url('images/ui_images/header/header-market.jpg')}}" alt="">
        </div>
        <a href="#about-us-section" class="scroll-button smoothscroll">
            <span class=" icon-keyboard_arrow_down"></span>
        </a>
    </section>
    {{--End Of Header--}}

    {{--start of amazing--}}
    <div id="saleOff"></div>
    {{--end of amazing--}}
    {{--start of advertises--}}
    <div id="advertises"></div>
    {{--end of advertises--}}

    <div class="container product " data-sticky_parent="" style=" font-size:15pt;">
        <div class="container">
            <br>
            <div class="row"><h2>دسته بندی ها</h2></div> <hr><br>
            <div class="row" id="menus">
                <p>در حال دریافت اطلاعات...</p>
            </div>
        </div>
    </div>

    {{--start of newest--}}
    <div id="newest"></div>
    {{--end of newest--}}

    {{--start of Comments--}}
    <div id="comments"></div>
    {{--end of Comments--}}

    <a href="#" class="back-to-top btn-primary" style="padding-right: 5px;padding-left: 5px;">
        @if ( $detect->isMobile() )
            <i  style="display: inline;" class="fa fa-angle-down"></i>مشاهده سفارش
        @else
            <i class="fa fa-angle-up"></i>
        @endif
    </a>
@endsection
@push('script')
<script src="{{asset("assets/js/owl.carousel.min.js")}}"></script>
    <script>
        $(document).ready(function () {
            $.ajax({
                headers:{"Authorization":"Bearer "+localStorage.getItem('token')},
                type: "GET",
                url:'/api/v1/index',
                success:function (index) {
                    if (index.status === "ok") {
                        let newest_html='';
                        let saleOff_html='';
                        let advertises_html='';
                        let newest=index.data['newest'];
                        let saleOff=index.data['amazing'];
                        let advertises=index.data['advertises'];
                        let priceUnit=localStorage.getItem('priceUnit');
                        advertises_html+=`<div class="container">`;
                        advertises_html+=`<div class="row">`;
                        $.each(advertises, function (key, item) {
                            advertises_html+=`<div class="col-lg-6" ><a href="${item.url}">`;
                            advertises_html+=`<img src="${item.image}" style="width: 100%;height: 200px" alt="${item.title}"> `;
                            advertises_html+=`</a></div>`;
                        })
                        advertises_html+=`</div></div>`;
                        newest_html+=`<div>`;
                        newest_html+=`<div class="container">`;
                        newest_html+=`<h3 class="home-page-title">`;
                        newest_html+=`<div class="row">`;
                        newest_html+=`<span style="background-color:#d70009; font-size:18px; color:#fff; padding: 5px 12px 5px 12px;">جدیدترین ها</span>`;
                        newest_html+=`</div>`;
                        newest_html+=`</h3>`;
                        newest_html+=`<div class="owl-carousel owl-theme" dir="ltr">`;
                        let added_count=0;
                        let cargos=[];
                        if(localStorage.getItem('cargos')!=null){
                            cargos=JSON.parse(localStorage.getItem('cargos'))
                        }
                        $.each(newest, function (key, item) {
                            if(cargos.findIndex(x=>x.id===item.id)>=0){
                                added_count=cargos[cargos.findIndex(x=>x.id===item.id)].count
                            }else{
                                added_count=0
                            }
                            newest_html+=`<div class="text-center ">`;
                            newest_html+=`<div class="panel ${item.max_count === 0?'finished-p-visibility':''}"><div class="panel-body" >`;
                            newest_html+=`<div class="label-danger" style="font-size:20px;position: absolute;top: 1px;transform: rotate(20deg);padding: 4px;border-radius: 10px 10px 10px 10px;visibility: ${item.saleOff>0?'visible':'hidden'}">${item.saleOff>0?item.saleOff+'%':''}</div>`;
                            newest_html+=`<div class="favorite ${item.is_favorite?'favorite-selected':'favorite-default'}" style="position: absolute;top: 1px;right: 30px;font-size: 30px;text-shadow: 0 0 3px #000;stroke: black;stroke-width: 2px;" title="افزودن به علاقه مندی ها" data-cargo="${item.id}"><span class="fa fa-heart"></span></div>`;
                            newest_html+=`<img src="${item.image}" alt="${item.name}" class="img-responsive" style="width: 100px; margin: 0 auto;"/>`;
                            newest_html+=`<br>`;
                            newest_html+=`<div class="product-name text-center">`;
                            newest_html+=`<span style="color: #000;" dir="rtl" id="f${item.id}">`;
                            newest_html+=`${truncate(item.name,35)}`;
                            newest_html+=`</span>`;
                            newest_html+=`</br>`;
                            newest_html+=`</div>`;
                            newest_html+=`</br>`;
                            newest_html+=`<div class="text-nowrap ${item.isMobile? 'text-center m-bottom-10':''} priceDiscountNewest">`;
                            newest_html+=`<div dir="rtl">${item.saleOff>0?'<span class="pricemenu">'+formatPrice(item.price)+' '+priceUnit+'</span>':''} ${formatPrice(item.main_price)}${' '+priceUnit}</div>`;
                            newest_html+=`</div>`;
                            newest_html+=`<a  class="decrease" data-id="${item.id}"><i class="fa fa-minus-square fa-lg inc-box"></i></a><span class="inc-dec-text"  id="countNewest${item.id}"><span style="padding:2px" class="cargo_${item.id}">${added_count}</span></span><a class="increase" data-id="${item.id}"><i class="fa fa-plus-square fa-lg inc-box"></i></a>`;
                            newest_html+=`</div>`;
                            newest_html+=`</div>`;
                            newest_html+=`</div>`;

                        })
                        newest_html+=`</div>`;
                        newest_html+=`</div>`;
                        newest_html+=`</section>`;
                        if(newest.length>0){$('#newest').html(newest_html);}
                        saleOff_html+=`<section class="top-resturant">`;
                        saleOff_html+=`<div class="container">`;
                        saleOff_html+=`<h3 class="home-page-title">`;
                        saleOff_html+=`<div class="row">`;
                        saleOff_html+=`<span style="background-color:#d70009; font-size:18px; color:#fff; padding: 5px 12px 5px 12px;">تخفیف دار ها</span>`;
                        saleOff_html+=`</div>`;
                        saleOff_html+=`</h3>`;
                        saleOff_html+=`<div class="owl-carousel owl-theme" dir="ltr">`;
                        $.each(saleOff, function (key, item) {
                            if(index.data.is_mobile){
                            }else{
                                if(cargos.findIndex(x=>x.id===item.id)>=0){
                                    added_count=cargos[cargos.findIndex(x=>x.id===item.id)].count
                                }else{
                                    added_count=0
                                }
                                saleOff_html+=`<div class="text-center">`;
                                saleOff_html+=`<div class="panel ${item.max_count === 0?'finished-p-visibility':''}"><div class="panel-body" >`;
                                saleOff_html+=`<div class="label-danger" style="font-size:20px;position: absolute;top: 1px;transform: rotate(20deg);padding: 4px;border-radius: 10px 10px 10px 10px;visibility: ${item.saleOff>0?'visible':'hidden'}">${item.saleOff>0?item.saleOff+'%':''}</div>`;
                                saleOff_html+=`<div class="favorite ${item.is_favorite?'favorite-selected':'favorite-default'}" style="position: absolute;top: 1px;right: 30px;font-size: 30px;text-shadow: 0 0 3px #000;stroke: black;stroke-width: 2px;" title="افزودن به علاقه مندی ها" data-cargo="${item.id}"><span class="fa fa-heart"></span></div>`;
                                saleOff_html+=`<img src="${item.image}" alt="${item.name}" class="img-responsive" style="width: 100px; margin: 0 auto;"/>`;
                                saleOff_html+=`<br>`;
                                saleOff_html+=`<div class="product-name text-center">`;
                                saleOff_html+=`<span style="color: #000;" dir="rtl" id="f${item.id}">`;
                                saleOff_html+=`${truncate(item.name,35)}`;
                                saleOff_html+=`</span>`;
                                saleOff_html+=`</br>`;
                                saleOff_html+=`</div>`;
                                saleOff_html+=`</br>`;
                                saleOff_html+=`<div class="text-nowrap ${item.isMobile? 'text-center m-bottom-10':''} priceDiscountNewest">`;
                                saleOff_html+=`<div dir="rtl">${item.saleOff>0?'<span class="pricemenu">'+formatPrice(item.price)+' '+priceUnit+'</span>':''} ${formatPrice(item.main_price)}${' '+priceUnit}</div>`;
                                saleOff_html+=`</div>`;
                                saleOff_html+=`<a class="decrease" data-id="${item.id}"><i class="fa fa-minus-square fa-lg inc-box"></i></a><span class="inc-dec-text"  id="countNewest${item.id}"><span style="padding:2px" class="cargo_${item.id}">${added_count}</span></span><a class="increase" data-id=${item.id}><i class="fa fa-plus-square fa-lg inc-box"></i></a>`;
                                saleOff_html+=`</div>`;
                                saleOff_html+=`</div>`;
                                saleOff_html+=`</div>`;
                            }
                        })
                        saleOff_html+=`</div>`;
                        saleOff_html+=`</div>`;
                        saleOff_html+=`</section>`;
                        $('#advertises').html(advertises_html);
                        if(saleOff.length>0){
                            $('#saleOff').html(saleOff_html);
                        }

                        $('.owl-carousel').owlCarousel({
                            loop:true,
                            responsiveClass:true,
                            responsive:{
                                0:{
                                    items:1,
                                    dots:true,

                                },
                                600:{
                                    items:3,
                                    dots:true,
                                },
                                1000:{
                                    items:4,
                                    dots:true,
                                }
                            },
                            autoplay:true,
                            slideSpeed: 300,

                        });
                    }else{
                        $('#newest').html('خطا در دریافت اطلاعات.');
                    }
                },
                error:function () {
                    $("#newest").html('<a class="btn btn-warning" style="height: 35px" onclick="_loadIndex()"><i class="fas fa-repeat"></i>تلاش مجدد</a>').show().fadeIn("slow");

                }
            })
            _loadIndex=function() {

            }

            _loadMenus=function(){
                $.ajax({
                    type: "GET",
                    url:'/api/v1/menu',
                    data:{'source':'web'},
                    success:function (menus) {
                        if (menus.status === "ok") {
                            let html='';
                            let data=menus.menus;
                            $.each(data, function (index, menu) {
                                html+=`<div class="col-sm-3  col-xs-6 product-box-2"><div class="product-box">`;
                                html+=`<a href="/menu/${menu.id}">`;
                                html+=`<img src="${menu.image}" alt="${menu.name}"/>`;
                                html+=`<h4 class="sarfaslMarket">${menu.name}</h4>`;
                                html+=`</a></div></div>`;
                            })
                            $('#menus').html(html);
                        }else{
                            $('#menus').html('خطا در دریافت اطلاعات.');
                        }
                    },
                    error:function () {
                        $("#menus").html('<a class="btn btn-warning" style="height: 35px" onclick="_loadMenus()"><i class="fas fa-repeat"></i>تلاش مجدد</a>').show().fadeIn("slow");

                    }
                })
            }
            _loadComments=function(){
                $.ajax({
                    type: "GET",
                    url:'/api/v1/comments',
                    success:function (comments) {
                        let html="";
                        if (comments.status === "ok") {
                            let data=comments.comments;
                            if(data.length>0){
                                html+=`<section class="comments-bg"><div class="container"><div class="row"><div class="col-md-12"><div class="container"><h3 class="home-page-title"><span style="background-color:#d70009; font-size:18px; color:#fff; padding: 5px 12px 5px 12px;">آخرین نظرات</span></h3><br> <div class="comments"><div class="panel scroll" style="direction: rtl; overflow-x: auto; height: 220px;font-size: 14px;font-weight: 400;color: #505050;background-color: #f2efeb54;">`;
                                $.each(data, function (key, comment) {
                                    html+=`<div class="well well-sm">${comment.username} می گوید: ${comment.comment} <br>${comment.admin_reply.length>0?'<span style="color: #0E9A00">پاسخ مدیریت: '+ comment.admin_reply+'</span>':''} </div>`;
                                })
                                html+=`</div></div></div></div></div></div></section>`;
                            }else{
                                html+='پیامی جهت نمایش وجود ندارد'
                            }
                        }else{
                           html+='خطا در دریافت اطلاعات.';
                        }
                        $('#comments').html(html);
                    },
                    error:function () {
                        $("#comments").html('<a class="btn btn-warning" style="height: 35px" onclick="_loadComments()"><i class="fas fa-repeat"></i>تلاش مجدد</a>').show().fadeIn("slow");
                    }
                })
            }
            setTimeout(function(){
                _loadIndex();

                _loadMarketInfo()
            }, 1000);
            setTimeout(function(){
                _loadMenus()
            }, 1500);
            setTimeout(function(){
                _loadComments()
            }, 2000);

        });
    </script>
@endpush
