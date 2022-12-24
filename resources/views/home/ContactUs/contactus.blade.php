<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<link href="{{asset('assets/css/main.css?v=64')}}" rel="stylesheet" type="text/css">
<style>
    body{
        background-color: #ffffff;
        direction: rtl;
        text-align: justify;
        font-family: IRANSans;
    }
    .p-term-and-condition-title{
        margin: 15px 1px;
        text-align: center;
    }
    .p1{
        margin: 20px 1px 1px 1px;
    }
    .p2{
        margin: 1px 1px 1px 1px;
    }
</style>
<body>

<div>
    <form class="form-horizontal contact-us-info" method="post">
        <fieldset class="bottom-3">
            <legend class="titr">@lang('messages.master.contact_us')</legend>
            <ul class="list">
                <li><p><span class="size-20"><i class="fa fa-map-marker" aria-hidden="true"></i> </span>{{$market->address}}</p></li>
                <li><p><span class="size-20"><i class="fa fa-map-marker" aria-hidden="true"></i> </span>@lang('messages.master.postal_code') 3414895787</p></li>
                <li><p><span class="size-20"><i class="fa fa-phone" aria-hidden="true"></i> </span>@lang('messages.contactUs.1'){{implode(' - ',$market->tel)}}</p></li>
                <li><p> <span class="size-20"><i class="fa fa-envelope"></i> </span>
                        @lang('messages.contactUs.2') {{$market->email}}
                    </p></li>
                <li><p><i class="fa fa-wifi" aria-hidden="true"></i> @lang('messages.contactUs.3')</p></li>
{{--                <li><p class="network">--}}
{{--                        <a href="{{$market->instagram}}"><i class="fab fa-instagram" aria-hidden="true"></i></a>--}}
{{--                        <a href="{{$market->telegram}}"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>--}}
{{--                    </p>--}}
{{--                </li>--}}
            </ul>
        </fieldset>
    </form>
</div>
</body>
</html>
