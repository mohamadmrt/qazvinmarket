@extends('home.master',array('aboutUs'=>__('قوانین و مقررات')))
@section('header')
        <section class="menu-bg" style="height: 6rem;background-image: url({{url('images/ui_images/back.jpg')}});background-repeat: repeat; background-position:right;"></section>
@endsection


@section('style')
    <style type="text/css">
        .about {
            /*font-family: "B Yekan","Tahoma", "Arial";*/
            direction: rtl;
            font-size: 11pt;
            line-height: 160%;
        }
        span.at{
            color: #666;
        }
        a.mail,a.mail:visited,a.mail:hover{
            text-decoration: none;
            font-weight: bold;
            color: #444;
        }
    </style>
@endsection

@section('content')
    <br><br><br><br>
    <div class="about">
        <p align="center">
            <img src='{{url("images/ui_images/Logo2_qazvinMarket.png")}}' width="150px" height="140px">
            <br/>
        </p>
        <div style="padding: 50px;line-height: 30px;text-align: justify" class="container">
            <strong style="color: #700;text-align: center;font-size: large;padding-bottom: 20px">قوانین استفاده از خدمات سامانه قزوین مارکت</strong>
            <br><br>
            <p>
                از نظر حقوقی، در معاملات سایت فروشگاه مجازی قزوین مارکت، شرکت خدمات کالای قزوین مارکت به عنوان فروشنده و کاربر اینترنتی سفارش دهنده به عنوان خریدار تلقی می شوند. فروش کالا بر مبنای نوع و مقداری صورت می گیرد که کاربر سفارش دهنده آنرا در سایت فروشگاه مجازی قزوین مارکت درج نموده است.
            </p>
            <p>
                قزوین مارکت تابع قوانین و مقررات جمهوری اسلامی ایران است و درج هرگونه موارد سیاسی، غیر اخلاقی و مغایر با هنجارهای اجتماعی باعث حذف حساب کاربر مورد نظر خواهد شد.
            </p>
            <p>
                استفاده از نام و نام‌خانوادگی حقیقی افراد به منظور ثبت نام در سایت الزامی است. در صورت مشاهده کلمات رکیک و الفاظ نامناسب، حساب كاربر حذف خواهد شد.
            </p>
            <p>
                هنگام سفارش ، ثبت یک شماره معتبر و قابل دسترس برای کاربران الزامی است.
            </p>
            <p>
                مسئولیت وارد کردن اطلاعات اشتباه و غیر واقعی از قبیل نام و نام خانوادگی، آدرس و شماره تماس به عهده کاربر است.
            </p>
            <p style="line-height: 40px">
                هر گونه نقص و یا عیب فنی بایستی در لحظه تحویل سفارش به متصدی تحویل کالا اعلام و کالا مرجوع گردد.
                در صورت بروز اختلاف بین طرفین، پلیس فتا و دادگاه رسیدگی به جرایم رایانه ای قزوین محل عقد صالح میباشد.
                کلیه عناصر موجود در این وب سایت، شامل اطلاعات، اسناد، تولیدات، لوگوها، گرافیک، تصاویر و خدمات، کلاً متعلق به سایت فروشگاه مجازی قزوین مارکت، می‌باشد و هیچ شخص حقیقی و حقوقی بدون اجازه کتبی صاحب عناصر مذکور سایت فروشگاه مجازی قزوین مارکت، اجازه کپی کردن، توزیع، نشر مجدد، واگذاری (Download) نمایش، ارسال و انتقال آن‌ها را ندارد.
            </p>
        </div>
    </div>
@endsection
