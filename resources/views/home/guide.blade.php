@extends('home.master',array('aboutUs'=>__('messages.AboutUs.2')))

@section('header')
    <section class="menu-bg" style="height: 6rem;background-image: url({{url('images/ui_images/back.jpg')}});background-repeat: repeat; background-position:right;"></section>
@endsection

<?
        $detect=new \Detection\MobileDetect();
?>
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
    <div class="container">
        <div class="row">
            <div class="about">
                <div style="padding: 50px;line-height: 40px">
                    <strong style="text-align: center;font-size: large;padding-bottom: 20px">راهنمای سفارش از قزوین مارکت</strong>
                    <p class="guideP"> قزوین مارکت یک سوپر مارکت اینترنتی و تلفنی است که در محدوده استان قزوین فعالیت می‌کند. این فروشگاه تمام تلاش خود را به کار گرفته است که مایحتاج روزانه یک خانه را در کوتاهترین زمان ممکن و با بهترین کیفیت در دسترس خانواده ها قرار دهد. از این رو امکان سفارش را از دو راه تماس تلفنی و خرید اینترنتی برای مشتریان خود فراهم ساخته است. برای سفارش تلفنی، مشتریان محترم این مجموعه می‌توانند با شماره تلفن 02833825 تماس حاصل نموده و لیست لوازم مورد نیاز خود را به اپراتور اعلام و پس از ثبت سفارش، محصولات سوپرمارکتی خریداری شده خود را در آدرس مورد نظرشان تحویل بگیرند. </p>
                  <p class="guideP">&nbsp;</p>
                    <div class="guideImg "> <img src="{{url('images/guide/5.jpg')}}" class="guideImgStyle " width="100%" /> </div>
                    <p class="guideP">برای سفارش از قزوین مارکت از قسمت دسته بندی ها، محصولات مورد نظر خود را انتخاب نمایید. </p>
                  <p class="guideP">&nbsp;</p>
                    <div class="guideImg "> <img src="{{url('images/guide/6.jpg')}}" class="guideImgStyle " width="100%" /> </div>
                    <p class="guideP"> به طور مثال اگر نیاز به پنیر دارید می‌توانید وارد دسته بندی لبنیات شده و پنیر مورد نظر خود را از میان محصولات نمایش داده شده انتخاب نمایید. </p>
                  <p class="guideP">&nbsp;</p>
                    <div class="guideImg "> <img src="{{url('images/guide/7.jpg')}}" class="guideImgStyle " width="100%" /> </div>
                    <p class="guideP">همچنین برای دسترسی سریعتر به محصولات مورد نیاز خود می‌توانید نام کالای مورد نیازتان را در کادر جستجو وارد نمایید  و کالای دلخواهتان را از میان گزینه های نمایش داده شده، انتخاب نمایید.</p>
                  <p class="guideP">&nbsp;</p>
                    <div class="guideImg "> <img src="{{url('images/guide/8.jpg')}}" class="guideImgStyle " width="100%" /> </div>
                    <p class="guideP"> حال با کلیک بر روی گزینه مثبت، تعداد کالا مورد نظر خود را انتخاب و آن را به سبد خرید خود اضافه نمایید. </p>
                  <p class="guideP">&nbsp;</p>
                    <div class="guideImg "> <img src="{{url('images/guide/9.jpg')}}" class="guideImgStyle " width="100%" /> </div>
                    <p class="guideP"> تمامی کالاهای مورد نظر خود را به همین روش، از میان دسته بندی های مرتبط انتخاب نموده و در پایان، برای تکمیل سفارش خود به سبد خرید مراجعه نمایید. </p>
                  <p class="guideP">&nbsp;</p>
                    <div class="guideImg " > <img src="{{url('images/guide/10.jpg')}}" class="guideImgStyle " width="100%" /> </div>
                    <p class="guideP"> (1) در سبد خرید لیست سفارشات خود را بررسی کنید، (2) نحوه ارسال را از میان دو گزینه موجود « فوری (ارسال رایگان برای سفارشات بالای 100,000 تومان) و زمانبندی (ارسال رایگان برای سفارشات بالای 50,000 تومان)» انتخاب نموده و با وارد کردن (3) آدرس و (4) انتخاب یکی از سه روش موجود « کیف پول حساب کاربری، پرداخت اینترنتی و پرداخت نقدی هنگام تحویل کالا» برای پرداخت هزینه سفارش، (5) سفارش خود را ثبت و منتظر ارسال آن در زمان انتخاب شده باشید.                  </p>
                  <p class="guideP">&nbsp;</p>
                  <p class="guideP"><strong style="text-align: center;font-size: large;padding-bottom: 20px">راهنمای ساخت پنل کاربری </strong></p>

                    <p class="guideP">
                    پیش از هر چیز یادآور می‌شویم که شما برای خرید از قزوین مارکت نیازی به ایجاد پنل کاربری ندارید با این حال بهتر است برای مدیریت بهتر سفارشات خود، در سایت ثبت نام نمایید.                     </p>

                    <div class="guideImg ">
                        <img src="{{url('images/guide/3.jpg')}}" class="guideImgStyle " width="100%" >
                    </div>

                    <p class="guideP">برای ثبت نام در سایت می‌توانید روی گزینه « ساخت حساب کاربری» کلیک کرده و با ثبت شماره همراه خود وارد پنل کاربری خود در سایت شوید. </p>
                  <p class="guideP">&nbsp;</p>

                    <div class="guideImg ">
                        <img src="{{url('images/guide/11.jpg')}}" class="guideImgStyle " width="100%" >
                    </div>

                    <div class="guideImg guideMargin">
                        <img src="{{url('images/guide/4.jpg')}}" class="guideImgStyle " width="100%" >
                    </div>

                    <p class="guideP"> حال می‌توانید از قسمت « تنظیمات حساب کاربری»، اطلاعات پروفایل خود را تکمیل نمایید، لیست خرید و لیست تراکنش های خود را ببینید. </p>
                    <p class="guideP" style="text-align:left;"><strong style="text-align:left;"> سوپر مارکت اینترنتی و تلفنی قزوین مارکت</strong></p>
</div>
            </div>

        </div>
    </div>
@endsection
