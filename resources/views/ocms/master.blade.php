<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>پنل مدیریت {{get_market(1)->name}}</title>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/jquery.Bootstrap-PersianDateTimePicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('fonts/fontawesome5.14.0/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/css/admin.css')}}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('fonts/fontawesome5.14.0/css/all.css')}}"  type="text/css"/>
    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/calendar.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/jquery.Bootstrap-PersianDateTimePicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/select2.full.min.js')}}"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('e5d43e43b526461d351e', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
</head>
<?
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off" and $_SERVER['HTTP_HOST']!='pwa.qazvinmarket.local'){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}
?>
<style>
    .tab{
        padding-right: 10px;
        margin-left: 20px;
    }

    a:hover{
        text-decoration: none;
        color: #2e6da4;
    }
    .active{
        color: #2e6da4 !important;
    }
    /*-----------------------------------------*/
    .panels-default {
        border-color: #ddd;
    }
    .panels {
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    img {
        max-width: 100%;
    }
    #logo a, img {
        height: auto;
    }
    img {
        border: 0;
        vertical-align: middle;
    }

    .page-banner {
        padding: 10px;
        background: none repeat scroll 0% 0% #337AB7;
    }
    .error_log {
        color: #F00;
        font-size: 13px;
        width: 100%;
        text-align: center;
        margin: 0px 0px 10px;
    }
    .success_log{
        color: #5cb85c;
        font-size: 13px;
        width: 100%;
        text-align: center;
        margin: 0px 0px 10px;
    }
    a:hover{
        text-decoration: none;
        color: #2e6da4;
    }
    .active{
        color: #2e6da4 !important;
    }


    /*------------------*/


    /* Style the sidenav links and the dropdown button */
    .sidenav a, .dropdown-btn {
        padding: 2px 4px 2px 20px;
        text-decoration: none;
        font-size: 16px;
        color: #333333;
        display: block;
        border: none;
        background: none;
        width: 100%;
        text-align: right;
        cursor: pointer;
        outline: none;
    }

    /* Main content */
    .main {
        margin-left: 200px; /* Same as the width of the sidenav */
        font-size: 20px; /* Increased text to enable scrolling */
        padding: 0px 10px;
    }



    /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
    .dropdown-container {
        display: none;
        padding-right: 50px;
        padding-top: 15px;
        line-height: 1.5;
    }

    .dropdown-container a:before{
        left: 0;
        right: 21px;
        content: "";
        display: block;
        position: absolute;
        width: 12px;
        left: 21px;
        top: 15px;
        border-top: rgba(255,255,255,0.2) 1px dotted;
    }

    /* Optional: Style the caret down icon */
    .fa-caret-down {
        float: left;
    }
    .hr-list{
        margin-top: 6px; margin-bottom: 3px;margin-left: 21px;border: 0;border-top: 1px solid #d4cfcf;
    }
    #menu_button{
        cursor: pointer;
    }
    .sidebar-hidden{
        display: none;
    }
    .main-content-100{
        width: 100%;
        padding: 5px 0 !important;
    }

</style>
@stack('style')
@stack('script')
<body>
<div id="navbar" class="navbar navbar-default   h-navbar" style="margin-bottom: 5px;">
    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-right">
                <span class="fa fa-list-ul tab" style="padding-right: 45px;" id="menu_button"></span>
            <small>
                <a href="{{route('home.index')}}">
                    <img src='{{url("images/ui_images/Logo_qazvinMarket.png")}}' style="height: 64px">
                </a>
            </small>
        </div>

        <div class="navbar-buttons navbar-header pull-left" role="navigation">

            <ul class="nav ace-nav">

                <li class="light-blue">
                    <a style="padding: 20px 15px;" data-toggle="dropdown" href="#" class="dropdown-toggle" title="عباس حسین پور، برای اطلاعات بیشتر کلیک کنید">
                    <span class="user-info">
                        <small>{{auth()->guard('admin')->user()->name}}،خوش آمدید</small>
                    </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-left dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="{{route('ocms.logout')}}">
                                <i class="ace-icon fa fa-power-off"></i>خروج
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div>
    <div class="container-fuild">
        <div id="sidebar" class="col-md-2" style="padding-top:0px;">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default sidenav">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a  class="active" href="{{route('ocms.dashboard')}}">
                                <span class="fas fa-home tab"></span> داشبورد </a>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default sidenav">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a  href="{{route('ocms.orders')}}"><span class="fa fa-list-ul  tab"></span>  سفارشات</a>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default sidenav">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a  href="{{route('ocms.cargos')}}"  class=""><span class="fa fa-box-full  tab"></span>مدیریت کالاها</a>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default sidenav">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a  href="{{route('ocms.menus')}}"  class=""><span class="fa fa-list-alt  tab"></span>مدیریت منو</a>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default sidenav">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <button class="dropdown-btn"><span class="fa fa-users tab"></span>کاربران
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-container">
                                <a   href="{{route('ocms.users')}}">کاربران
                                </a>
                                <hr class="hr-list">
                                <a   href="{{route('ocms.wallets')}}">گزارش شارژ کاربران
                                </a>
                                <hr class="hr-list">
                                <a   href="{{route('group.index')}}">مدیریت گروه های کاربران
                                </a>
                                <hr class="hr-list">
                                <a   href="{{route('ocms.userMostPurchasedView')}}">بیشترین خرید
                                </a>
                                <hr class="hr-list">
                                <a   href="{{route('ocms.comments')}}">نظرات
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="panel panel-default sidenav">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <button class="dropdown-btn"><span class="fas fa-dollar-sign tab"></span>  مالی
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-container">
                                <a   href="{{route('ocms.reports')}}">گزارشات</a>
                                <hr class="hr-list">
                                <a   href="{{route('ocms.cargoList')}}">گزارش فروش</a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="panel panel-default sidenav">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <button class="dropdown-btn"><span class="fa fa-calendar tab"></span>  خدمات
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-container">
                                <a   href="{{route('coupon.index')}}"> کدهای تخفیف
                                </a>
                                <hr class="hr-list">
                                <a   href="{{route('ocms.amazing')}}">پیشنهاد شگفت انگیز
                                </a>
                                <hr class="hr-list">
                                <a   href="{{route('holiday.index')}}"> تعطیلات
                                </a>
                                <hr class="hr-list">
                                <a   href="{{route('advertise.index')}}">تبلیغات
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="panel panel-default sidenav">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a href="{{route('ocms.peyk')}}">
                                <span class="fa fa-map-marker tab"></span>  مناطق پیک
                            </a>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default sidenav">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <button class="dropdown-btn"><span class="fa fa-cogs tab"></span>  تنظیمات
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-container">
                                <a   href="{{route('ocms.setting')}}">تنظیمات
                                </a>
                                <hr class="hr-list">
                                <a   href="{{route('ocms.logout')}}">خروج
                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        function formatPrice(num)
        {
            var num_parts = num.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return num_parts.join(".");
        }
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
        $("#menu_button").click(function() {
            $("#sidebar").toggleClass('sidebar-hidden');
            $("#main-content").toggleClass('main-content-100');
        })
    </script>
    @include('sweetalert::alert')
    @yield('content')

</div>
</body>
</html>
