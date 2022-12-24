@extends('home.master')
@section('header')
    <section class="menu-bg" style="height: 6rem;background-image: url({{url('images/ui_images/back.jpg')}});background-repeat: repeat; background-position:right;">
    </section>
@endsection
@push('script')
    <script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.time-to.js')}}"></script>
@endpush
@push('style')

    <?
    $detect = new Mobile_Detect;
    ?>
    <style>
        .btn-circle{
            width: 150px;
            height: 150px;
            padding: 20px;
            border-radius: 81px;
            font-size: 14px;
            line-height: 1.33;
            text-align: center;
            display: inline-block;
            margin: 4px 2px;
            white-space: normal;

            text-decoration: none;
        }
        a:link {
            color: white;
        }
    </style>
    @if($detect->isMobile())
        <style>

            .btn-comment{
                margin-top: 10px;
            }
        </style>
    @else
        <style>
            .btn-comment{
                margin-right: 30px;
            }
        </style>
    @endif
    <link href="{{asset('assets/css/digital_clock.css')}}" rel="stylesheet" type="text/css">

@endpush
@section('content')
    <div id="cargoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">لیست سفارشها</h4>
                </div>
                <div class="modal-body">
                    <div id="orders">
                        <table  class="table-hover table table-bordered">
                            <thead>
                            <tr class="bg-success">
                                <td>نام غذا</td>
                                <td>تعداد</td>
                                <td>قیمت (تومان)</td>
                                <td>قیمت کل (تومان)</td>
                            </tr>
                            </thead>
                            <tbody id="cargos">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">خروج</button>
                </div>
            </div>

        </div>
    </div>
    <div class="container panel top-5" >
        <div id="result_section"></div>
        <div class="panel-body" style="background-color:#FFF;">
            <div class="label-success text-center replyTr" style="padding:15px 7px;display:none;">
                <span style="font-size: 18px;color: white">پاسخ پشتیبانی:</span>
                <span id="replySupporter" style="font-size: 18px;color: white">

                    </span>
            </div>
            <table class="table table-hover">
                <tr>
                    <td>رسید پرداخت:</td>
                    <td>
                        <span id="RefId"></span>
                    </td>
                </tr>
                    <tr id="payment_section"></tr>
                <tr>
                    <td>شماره پرداخت</td>
                    <td>
                        <span id="order_id"></span>
                    </td>
                </tr>
                <tr>
                    <td>شماره مرجع:</td>
                    <td>
                        <span id="order_ref"></span>
                    </td>
                </tr>
                <tr>
                    <td>نظر سنجی :</td>
                    <td id="vote_section"></td>
                </tr>

                <tr>
                    <td>جزییات سفارش:</td>
                    <td id="order_detail_section">

                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        function is_delayed (){
            let order=$("#delay_button").data('order');
            $.ajax({
                type: 'POST',
                data:{token:"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvcHdhLnFhenZpbm1hcmtldC5jb21cL2FwaVwvdjFcL3ZlcmlmeV9hY3RpdmF0aW9uX2NvZGUiLCJpYXQiOjE2MzU4Mzc1OTcsIm5iZiI6MTYzNTgzNzU5NywianRpIjoiZUJLZk5jbHpSbkw4cHFPciIsInN1YiI6NDU0MTcsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.z3KVZDGJkhNDF3YmUv9yG17JKcqLK_YuQ8Rrb-4W1cQ",order:$(this).data('order')},
                url: `/api/v1/is_delayed/QMnA110957047467`,
                success:function (response) {
                    if (response.status==='ok') {
                        swal({
                            type: 'success',
                            title: response.message,
                            text: "با تشکر از انتخاب شما",
                            confirmButtonText: 'باشه'
                        });
                    }else if(response.status==='duplicate'){
                        swal({
                            type: 'warning',
                            title: response.message,
                            confirmButtonText: 'باشه'
                        });
                    }
                    else if (response.status==='fail') {
                        swal({
                            type: 'warning',
                            title: "خطا در ارسال اطلاعات",
                            confirmButtonText: 'باشه'
                        });
                    }
                    else {
                        swal({
                            type: 'error',
                            title: data.message,
                            confirmButtonText: 'باشه'
                        });
                    }
                },
                error:function(){
                    swal({
                        type: 'warning',
                        title:"خطای سیستم! لطفاً با پشتیبانی تماس بگیرید",
                        confirmButtonText: 'باشه'
                    });
                }
            });
        }

        $(document).ready(function () {


            if(localStorage.getItem('cargos')!==null){
                localStorage.removeItem('cargos');
                localStorage.removeItem('totalPrice');
                $(".cartNumber").html("0")
                $(".totalPrice").html("0")
            }
            let url = window.location.href;
            let a = $('<a>', {
                href: url
            });
            let params=a.prop("pathname").split("/");
            let order=params[2]
            $.ajax({
                headers:{"Authorization":"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvcHdhLnFhenZpbm1hcmtldC5jb21cL2FwaVwvdjFcL3ZlcmlmeV9hY3RpdmF0aW9uX2NvZGUiLCJpYXQiOjE2MzU4Mzc1OTcsIm5iZiI6MTYzNTgzNzU5NywianRpIjoiZUJLZk5jbHpSbkw4cHFPciIsInN1YiI6NDU0MTcsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.z3KVZDGJkhNDF3YmUv9yG17JKcqLK_YuQ8Rrb-4W1cQ"},
                type: 'GET',
                data:{},
                url: `/api/v1/vote/QMnA110957047467`,
                success:function (response) {
                    if (response.status==="ok"){
                        let cargos=response.order.cargos;
                        let cargo_html=``;
                        let result_section=``;
                        let message=response.message;
                        let order=response.order;
                        console.log(order);
                        $.each(cargos,function (key,cargo){
                            cargo_html+=`<tr>`;
                            cargo_html+=`<td>${cargo.name}</td>`;
                            cargo_html+=`<td>${cargo.count}</td>`;
                            cargo_html+=`<td>${formatPrice(cargo.main_price)}</td>`;
                            cargo_html+=`<td>${formatPrice(cargo.main_price*cargo.count)}</td>`;
                            cargo_html+=`</tr>`;
                        });
                        $('#vote_url').attr('href',`/vote/${order.url}`)
                        if (order.status==="4"){
                            result_section+=`<div>`;
                            result_section+=`<div class="panel-heading text-center" style="padding:15px 0;background-color: rgb(79,205,92);">`;
                            result_section+=`<span style="font-size: 20px;color: white;">${message}</span>`
                            result_section+=`</div>`
                            result_section+=`</div>`
                            result_section+=`<div id="remain_shipping_message">`
                            result_section+=`<div class="panel-heading text-center timer" style="padding:15px 0;background-color: rgb(227,72,72);">`
                            result_section+=`<span style="font-size: 20px;color: white;">زمان باقیمانده برای دریافت سفارش</span>`
                            result_section+=`<br>`
                            result_section+=`<div dir="ltr" id="timer"></div>`
                            result_section+=`</div>`
                            result_section+=`<div class="panel-heading text-center vote" style="padding:15px 0;background-color: rgb(243,238,238);display: none">`
                            result_section+=`<button class="btn btn-danger btn-circle"><a href="/vote/${order.url}" >نظرسنجی</a></button>`
                            result_section+=`<button class="btn btn-danger btn-circle" id="delay_button" data-order="${order.url}" onclick="is_delayed()">سفارش هنوز نرسیده است؟ کلیک کنید!</button>`
                            result_section+=`</div>`
                            result_section+=`</div>`
                        }else{
                            result_section+=`<div>`
                            result_section+=`<div class="panel-heading text-center" style="padding:15px 0;background-color: rgb(207,56,116);">`
                            result_section+=`<span style="font-size: 20px;color: white;">${response.message}</span>`
                            result_section+=`</div>`
                            result_section+=`</div>`
                            result_section+=`<br>`
                        }
                        if (order.bank==='4'){
                            $('#payment_section').html(`<td>مبلغی که باید به پیک پرداخت نمایید:</td>
                        <td>${formatPrice(order.invoice_amount)} تومان </td>`);
                        }else if(order.bank==='1'){
                            $('#payment_section').show().html(`<td>وضعیت برگشتی از درگاه</td>
                            <td>
                            <span>${order.ResCode==='0'?'تراكنش با موفقيت انجام شد':'عدم موفقیت در برداشت از حساب بانکی'}</span>
                            </td>`);

                        }else if(order.bank==='3'){
                            $('#payment_section').show().html(`<td>نتیجه تراکنش</td>
                            <td>
                            <span>${order.status==="4"?'تراكنش با موفقيت انجام شد':'عدم موفقیت در برداشت از حساب کاربری'}</span>
                            </td>`);
                        }
                        let vote_section=``;
                        if (order.status==='4' && order.type!=='scheduled'){
                            vote_section+=`<p id="Survey">لینک نظرسنجی پس از اتمام زمان باقیمانده فعال خواهد شد.</p>`;
                            vote_section+=`<a id="support_phone" class="btn btn-success" style="display: none" href="tel:02833825">تماس با پشتیبانی (02833825)</a><br>`
                            vote_section+=`<a class="btn btn-info vote_link" style="display: none" target="_blank" href="/vote/${order.url}">ورود به صفحه نظر سنجی</a>`
                        }
                        $('#order_detail_section').html(`<p>
                            <b>نام گیرنده:</b>
                            <span>${order.username}</span>
                        </p>
                        <p>
                            <b>نام سوپرمارکت:</b>
                            <span>${order.market_name}</span>
                        </p>
                        <p>
                            <b>تلفن:</b>
                            <span>${order.tel}</span>
                        </p>
                        <p>
                            <b>آدرس:</b>
                            <span>${order.address}</span>
                        </p>
                        <p>
                            <button type="button" class="open-AddBookDialog btn btn-info" data-toggle="modal" data-target="#cargoModal">لیست سفارش ها</button>
                        </p>`)
                       $('#vote_section').html(vote_section);
                        $('#result_section').html(result_section)
                        $('#RefId').html(`${order.RefId}`)
                        $('#cargos').html(cargo_html)
                        $('#order_id').html(order.id)
                        $('#order_ref').html(order.SaleRefId)
                        $('#timer').timeTo(order.shipping_time, function(){
                            $(".vote_link").show();
                            $("#support_phone").show();
                            $("#Survey").hide();
                            $(".timer").hide();
                            $(".vote").show();
                        });
                        $('#reset-1').click(function() {
                            $('#timer').timeTo('reset');
                        });
                    }
                },
                error:function () {
                    alert('خطایی رخ داد')
                }
            });


        })
    </script>



@endsection

