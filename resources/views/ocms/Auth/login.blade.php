<!DOCTYPE HTML>
<html>
<head>
    <title>Admin Panel</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{asset('assets/admin/css/stylelogin.css')}}" />


</head>
<body>
<div class="wrap">
    <!-- tab style-1 -->
    <div class="row">
        <div class="grid_12 columns">
            <div class="tab style-1">
                <dl>
                    <dd class="users"><a class="user active" href="#tab1" > </a></dd>

                </dl>
                <ul>

                    @if(session()->has('ADLoginERR'))
                        <div class="alert alert-danger">
                            {{ session()->get('ADLoginERR')}}
                        </div>
                    @endif
                    <li class="active">
                        <div class="form">
                            <form action="{{route('admin.auth')}}" method="post">
                                {{csrf_field()}}
                                <input type="text" name="username" class="active textbox" placeholder="نام کاربری">
                                {{--<input id="username" type="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" --}}
                                       {{--name="username" value="{{ old('username') }}" autofocus>--}}
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif

                                <input type="password" name="password" class="textbox" placeholder="رمز عبور">

                                {{--<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">--}}

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif


                                {{--<p><input type="image" id="captcha_qazvin" src="captcha_qazvin.php"></p>--}}
                                {{--<p> <input type="text" id="result_captcha" name="result_captcha" placeholder="کد امنیتی"></p>--}}
                                <input type="submit" value="ورود"></form>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
<div class="wrap">
    <!--footer-->
    <div class="footer">
        <p>سامانه مدیریت سوپرمارکت نسخه 1.0</p>
    </div>
    <div class="clear"> </div>
</div>
</body>
</html>
