<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/bootstrap-rtl.min.css')}}" rel="stylesheet">
    <link href="{{asset('fonts/fontawesome5.14.0/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style_user.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/persianDatepicker-default.css')}}"  type="text/css"/>
    <link href="{{asset('assets/css/bootstrap-switch.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-switch.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.js')}}"></script>
    <script src="{{asset('assets/js/html5shiv.min.js')}}"></script>
    <script src="{{asset('assets/js/respond.min.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/persianDatepicker.min.js')}}" type="text/javascript"></script>
    <title>@lang('messages.userMaster.title') {{\App\Market::find(1)->name}}</title>
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
    .connectedSortable { list-style-type: none; margin: 0; padding: 0 0 2.5em; margin-right: 10px; }
    .connectedSortable li { margin: 0 5px 5px 5px; padding: 5px;font-size: 14px;  }

    .move {
        width: 20px;
        height: 20px;
        float: left;
        color: #fff;
        text-align: center;
        text-transform: uppercase;
        line-height: 30px;
        cursor: move;
        margin-left:10px;
        background-image:url(../new/images/move.png);
        background-repeat:no-repeat;
        margin-top:10px;
    }
    .edit {
        text-align: center;
        text-transform: uppercase;
        padding: 6px;
    }
    .delete {
        color: #fff;
        text-align: center;
        text-transform: uppercase;
        padding: 6px;
    }
    .movable-placeholder {
        background: #ccc;
        height: 100px;
        display: block;
        padding: 20px;
        margin: 0 0 15px 0;
        border-style: dashed;
        border-width: 2px;
        border-color: #000;
    }
    .ui-state-default {
        border:#e3e3e3 1px solid;
        border-radius: 5px;
        background-color: rgba(248, 248, 248, 1);
    }
    .ui-state-default2 {
        border:#e3e3e3 1px solid;
        list-style-type: none;
        padding:0px;
        padding-right:15px;
        border-radius: 5px;
    }
    ._dbd-ls {
        background-color: #fff;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        box-sizing: content-box;
        border-radius: 2px;

    }
    .list-group {
        margin-bottom: 20px;
        padding-right: 0;
    }
    ._dbd-ls .list-group-item {
        border: 0;
        border-top-width: 0px;
        border-top-style: none;
        border-top-color: currentcolor;
        border-top: 1px solid #ddd;
    }
    a.list-group-item {
        color: #337AB7;
        font-size: 13px;
        font-weight: 800;
    }
    i.a.list-group-item{
        padding-left: 5px;
        margin-left: 5px;
    }
    .list-group-item {
        position: relative;
        display: block;
        padding: 2px 15px;
        margin-bottom: -1px;
        background-color: #fff;
        border: 1px solid #ddd;
    }
    .list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
        color: #fff;
    }
    .list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
        border-top: 0;
        border-top-color: currentcolor;
        border-color: #0275d8;
        border-top-color: rgb(2, 117, 216);
    }
    /*-----------------------------------------*/
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
    /*-----------------------cridte----------------------*/
    label{
        display: inline-block;
        margin-bottom: 5px;
        color: #666;
        clear: both;
    }
    .form-control{
        width: 40%;
        height: 34px;
        padding: 7px 14px;
        font-size: 13px;
        color: #555;
        background-color: #FFF;
        border:1px solid rgba(153, 153, 153, 1)
        border-radius: 2px;
        transition: border-color 0.15s ease-in-out 0s;
    }
    .form-group {
        margin-bottom: 15px;
        margin-top: 35px;
    }
    .panel-body a{
        list-style: none;
        text-decoration: none;
        cursor: pointer;
    }
    .error {color:#C00; font-weight:normal;}
</style>
@stack('style')
<body>
<div class="container-fluid">
    <div class="row" style="background-image:url({{asset('images/ui_images/user/header.jpg')}}); height:180px; background-color:#000;">
        <div class="container">
            <div class="col-md-12">
                <h1 style="padding-top:50px;">
                    <a href="" style="color:#FFF;" id="userInfo"></a>
                </h1>
            </div>
        </div>
    </div>
    <div class="row" style="background-image:url({{asset('images/ui_images/user/bg.png')}}); height:445px;">
        <div class="container" style="background-color:#FFF;">
            <div class="row">
                <div class="col-md-3">
                    <div class="page">
                        <div class="panel-body">
                            <div calss="list-group _dbd-ls panel-heading" style="line-height:300%;">
                                <a class="list-group-item active" href="{{route('dashboard')}}"><i class="fas fa-tachometer-alt"></i> داشبورد</a>
                                <a class="list-group-item" href="{{route('home.index')}}"><i class="fas fa-home"></i> برگشت به قزوین مارکت</a>
                                <a class="list-group-item" href="{{route('user.profile')}}"><i class="fas fa-user bfa"></i>اطلاعات کاربری</a>
                                <a class="list-group-item" href="{{route('user.addresses')}}"><i class="fas fa-map-marked bfa"></i>آدرس ها</a>
                                <a class="list-group-item" href="{{route('user.referral')}}"><i class="fas fa-gift bfa"></i>اعتبار رایگان</a>
                                <a class="list-group-item" id="logout" ><i class="fas fa-power-off bfa"></i>خروج</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 ">
                    <div class="panel panel-primary" style="min-height: 500px">
                        <div class="panel-heading " >
                            <a class="btn" href="{{route('dashboard')}}" style="padding: 10px;color: #ffffff"><i class="fas fa-user" ></i> <span id="userTitle"></span> -  &nbsp;<span id="pageTitle"></span> </a>
                        </div>

                        @yield('content')

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function formatPrice(num)
    {
        let num_parts = num.toString().split(".");
        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return num_parts.join(".");
    }
    $(document).ready(function() {
        let userName=localStorage.getItem('username');
        let userMobile=localStorage.getItem('mobile');
        let wallet=localStorage.getItem('wallet_amount');
        let point=localStorage.getItem('points');
        let orderCount=localStorage.getItem('orderCount');
        let transactionCount=localStorage.getItem('transactionCount');
        $('#userTitle').text(userName+' ( '+userMobile+')');
        $('#wallet').text(formatPrice(wallet));
        $('#point').text(formatPrice(point));
        $('#order').text(formatPrice(orderCount));
        $('#transactionCount').text(formatPrice(transactionCount));
        let address=window.location.pathname;
        switch(address){
            case '/dashboard':
                $('#pageTitle').text('داشبورد');
                break;
            case '/referral':
                $('#pageTitle').text('اعتبار رایگان');
                break;
            case '/profile':
                $('#pageTitle').text('اطلاعات کاربری');
                break;
            case '/addresses':
                $('#pageTitle').text('آدرس ها');
                break;
            case '/buyList':
                $('#pageTitle').text('سفارشات');
                break;
            case '/credit':
                $('#pageTitle').text('کیف پول');
                break;
            default:
                $('#pageTitle').text('');
                break;
        }
    });
    $(document).on("click", ".paginate", function () {
        _search($(this).attr('page'));
    })
    $(document).on("click", "#logout", function () {
        $.ajax({
            method: 'POST',
            headers:{"Authorization":"Bearer "+localStorage.getItem('token')},
            url:"/api/v1/logout",
            success:function () {
                localStorage.clear();
            }
        });
        $.ajax({
            method: 'GET',
            url:"/logout",
            success:function () {
                window.location="/";
            }
        });
    });
    href=""
</script>
@stack('scripts')

</body>
</html>
