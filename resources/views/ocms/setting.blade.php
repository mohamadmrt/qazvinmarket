@extends('ocms.master')
@push('style')
    <link href="{{asset('assets/css/bootstrap-switch-v3.css')}}" rel="stylesheet">
    <script src="{{asset('assets/js/bootstrap-switch-v3.js')}}"></script>

    <style>
        .highlight {
            background-color: #8BF18B;
        }

        .default {
            background-color: #d2d1d1;
        }
    </style>
@endpush
@section('content')
    <div id="why_off" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #e9aabd;border-radius:5px 5px 0 0 ">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">علت تعطیلی سوپرمارکت را وارد نمایید</h4>
                </div>
                <div id="why_off_error"></div>
                <div class="modal-body">
                    <label for="name"></label>
                    <textarea type="text" class="form-control" name="name" id="why_off_user"
                              style="width: 100%;"></textarea>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" id="why_off_submit" value="ارسال">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">خروج</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div class="panel panel-info">
            <div align="center" class="panel-heading"><h5>تغییر تنظیمات</h5></div>
            <div class="panel-body ">
                <div class="row">
                    <div class="well col-lg-8" style="margin-left: auto;margin-right: 15% ">
                        <div class="text-center">
                            <label for="close_market">وضعیت سفارشگیری</label>
                            <input type="checkbox" id="close_market" name="close_market">
                        </div>
                        <div class="text-center"><h4>روزهای کاری</h4></div>
                        <div class="text-center"><span style="color: #5cb85c" class="delayMessage"
                                                       id="market_time_message"></span></div>
                        <div class="text-center" style="overflow-x:auto;">
                            <table class="table table-hover" style="overflow-x: scroll">
                                <thead>
                                <td>روز</td>
                                <td colspan="48">ساعت</td>
                                </thead>
                                <tbody id="market_time">
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <input type="submit" id="save_market_time" value="ذخیره" class="btn btn-success">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="well col-lg-6" style="margin-left: auto;margin-right: 20% ">
                        <div class="text-center">تغییر شماره پیامک</div>
                        <div class="text-center">
                            <h4>شماره فعلی جهت ارسال پیامک :
                                <span style="color: #db2332" class="showtel" id="marketSmsNumber"></span>
                            </h4>
                            <div style="height: 50px;padding-top: 10px;">
                                <input class=" btn btn-primary changeTel" value="تغییر شماره به 900002550" name="tel2"
                                       type="button" data-id="90002550" size="40">
                                <input class=" btn btn-primary changeTel" value="تغییر شماره به 210002100" name="tel2"
                                       type="button" data-id="210002100" size="40">
                                <input class=" btn btn-primary changeTel" value="تغییر شماره به 3000" name="tel2"
                                       type="button" data-id="3000" size="40">
                                <input class="btn btn-primary changeTel" value=" تغییر شماره به 2000" name="tel3"
                                       type="button" data-id="2000" size="40">
                                <input class="btn btn-primary changeTel" value=" تغییر شماره به 1000" name="tel1"
                                       type="button" data-id="1000" size="40">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="well col-lg-6" style="margin-left: auto;margin-right: 20% ">
                        <div class="text-center">تغییر درگاه پیش فرض</div>
                        <div class="text-center">
                            <h4>درگاه پیش فرض پرداخت :
                                <span class="text-danger showbank" id="showbank">ملت</span>
                            </h4>
                            <div style="height: 50px;padding-top: 10px;">
                                <input class="btn btn-primary ipg" value="تغییر به بانک ملت" name="tel2" type="button"
                                       data-id="0" size="40">
                                <input class="btn btn-primary ipg" value="تغییر به بانک پاسارگاد" name="tel3"
                                       type="button" data-id="1" size="40">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="well col-lg-6" style="margin-left: auto;margin-right: 20% ">
                        <div class="text-center">
                            <span style="color: #5cb85c" class="delayMessage" id="support_message"></span>
                            <h4>شماره موبایل های پشتیبان</h4>
                            <div><input dir="ltr" style="text-align: left;" class="form-control" id="supports"
                                        type="text" value=""></div>
                            <div style="height: 50px;padding-top: 10px;">
                                <input class="btn btn-success" value="ذخیره" name="btn-support" type="button"
                                       id="btn-support" size="40">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="well col-lg-6" style="margin-left: auto;margin-right: 20% ">
                        <div class="text-center">
                            <h4>شماره موبایل های پشتیبان سفارشات با تأخیر« <span class="text-danger"
                                                                                 id="market_name"></span>»</h4>
                        </div>
                        <div class="text-center">
                            <span style="color: #5cb85c" class="showDelay" id="showDelay"></span>
                            <input dir="ltr" class="form-control" style="text-align: left;" id="delay_support" value="">
                            <div style="height: 50px;padding-top: 10px;">
                                <input class="btn btn-success" value="ذخیره" name="btn-delay" type="button"
                                       id="btn-delay" size="40">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="well col-lg-6" style="margin-left: auto;margin-right: 20% ">
                        <div class="text-center">
                            <h4>تلفن های فروشگاه<a class="btn btn-success btn-sm" title="افزودن شماره" id="addMarketTel"
                                                   style="font-size: 12px"><span class="fa fa-plus-circle"></span></a>
                            </h4>
                        </div>
                        <div class="text-center">
                            <span style="color: #5cb85c" class="showDelay" id="market_tel_error"></span>
                            <div id="market_tels">
                                <div class="form-group form-inline" style="padding: 2px"><a title="حذف"
                                                                                            class="del-num btn btn-sm btn-danger"><span
                                            class="fa fa-times-circle"></span></a><input dir="ltr" class="form-control"
                                                                                         style="width:120px;text-align: left;"
                                                                                         name="market_tel[]"></div>
                            </div>
                            <div style="height: 50px;padding-top: 10px;">
                                <input class="btn btn-success" value="ذخیره" name="btn-delay" type="button"
                                       id="change_market_tels" size="40">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="well col-lg-6" style="margin-left: auto;margin-right: 20% ">
                        <div class="text-center">
                            <h4> درصد تخفیف برای مبلغ پیک <a class="btn btn-success btn-sm" title="افزودن درصد"
                                                             id="addPeykPriceDiscount" style="font-size: 12px"><span
                                        class="fa fa-plus-circle"></span></a></h4>
                        </div>
                        <div class="text-center">
                            <span style="color: #5cb85c" class="showDelay" id="peyk_price_message"></span>
                            <div id="peykPriceDiscount">
                                <div class="form-group form-inline" style="padding: 2px"><a title="حذف"
                                                                                            class="del-num btn btn-sm btn-danger"><span
                                            class="fa fa-times-circle"></span></a><input dir="ltr" class="form-control"
                                                                                         style="width:120px;text-align: left;"
                                                                                         name="peyk_discount[]"> درصد
                                    تخفیف برای خرید بیشتر از <input dir="ltr" class="form-control"
                                                                    style="width:120px;text-align: left;"
                                                                    name="peyk_discount[]"> تومن
                                </div>
                            </div>
                            <div style="height: 50px;padding-top: 10px;">
                                <input class="btn btn-success" value="ذخیره" name="btn-delay" type="button"
                                       id="change_peyk_discount" size="40">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="well col-lg-6" style="margin-left: auto;margin-right: 20% ">
                        <div class="text-center">
                            <h4> باشگاه مشتریان <a class="btn btn-success btn-sm" title="افزودن"
                                                   id="addCustomerClub" style="font-size: 12px"><span
                                        class="fa fa-plus-circle"></span></a></h4>
                        </div>
                        <div class="text-center">
                            <span style="color: #5cb85c" class="showDelay" id="customer_club_message"></span>
                            <div id="customerClub">
                                <div class="form-group form-inline" style="padding: 2px"><a title="حذف"
                                                                                            class="del-num btn btn-sm btn-danger"><span
                                            class="fa fa-times-circle"></span></a>سطح<input dir="ltr"
                                                                                            class="form-control"
                                                                                            style="width:120px;text-align: left;"
                                                                                            name="customer_club_levels[]">حداقل
                                    امتیاز<input dir="ltr" class="form-control" style="width:120px;text-align: left;"
                                                 name="customer_club_levels_min[]">حداکثر امتیاز<input dir="ltr"
                                                                                                       class="form-control"
                                                                                                       style="width:120px;text-align: left;"
                                                                                                       name="customer_club_levels_max[]">
                                </div>
                            </div>
                            <div id="customerClubLevels">
                            </div>

                            <div class="form-group form-inline" style="padding: 2px">
                                امتیاز به ازاء هر خرید موفق: <input dir="ltr" class="form-control" style="width:120px;text-align: left;" name="score_of_success_order">
                            </div>

                            <div style="height: 50px;padding-top: 10px;">
                                <input class="btn btn-success" value="ذخیره" name="btn-delay" type="button"
                                       id="change_customer_club" size="40">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="well col-lg-6" style="margin-left: auto;margin-right: 20% ">
                        <div class="text-center">
                            <h4>آدرس فروشگاه</h4>
                        </div>
                        <div class="text-center">
                            <span style="color: #5cb85c" class="showDelay" id="market_address_error"></span>
                            <div id="">
                                <textarea class="form-control" name="" id="market_address" cols="30"
                                          rows="3"></textarea>
                            </div>
                            <div style="height: 50px;padding-top: 10px;">
                                <input class="btn btn-success" value="ذخیره" type="button" id="change_market_address"
                                       size="40">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="well col-lg-6" style="margin-left: auto;margin-right: 20% ">
                        <div class="text-center">
                            <h4>تنظیمات نحوه ارسال</h4>
                        </div>
                        <span style="color: #5cb85c" class="showDelay" id="shipping_method_error"></span>
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <div class="row col-md-12">
                                    <div class="col-md-4">
                                        <input type="checkbox" name="express" id="cash">
                                        <label for="cash"> پرداخت نقدی </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <div class="row col-md-12">
                                    <div class="col-md-4">
                                        <input type="checkbox" name="express" id="express">
                                        <label for="express"> سفارش سریع </label>
                                    </div>

                                </div>
                                <div class="row col-md-12" style="margin-top: 20px">
                                    <span> کاهش </span>
                                    <input type="text" id="incity_express_peykPrice_percent">
                                    <span>درصد هزینه پیک برای سفارشات بالای </span>
                                    <input type="text" id="incity_express_peykPrice_threshold">
                                    <span>تومان</span>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <div class="row col-md-12">
                                    <div class="col-md-4">
                                        <input type="checkbox" name="scheduled" id="scheduled">
                                        <label for="scheduled">سفارش زمانبندی</label></div>
                                    <div class="col-md-8">
                                        <span>  شروع ارسال سفارشات زمانبندی برای چند روز آینده باشد؟ </span>
                                        <select name="pOrder_date" id="scheduler_latency_day">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row col-md-12" style="margin-top: 20px">
                                    <span> کاهش </span>
                                    <input type="text" id="incity_scheduled_peykPrice_percent">
                                    <span>درصد هزینه پیک برای سفارشات بالای </span>
                                    <input type="text" id="incity_scheduled_peykPrice_threshold">
                                    <span>تومان</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div style="height: 50px;padding-top: 10px;">
                                <input class="btn btn-success" value="ذخیره" type="button" id="change_shipping_method"
                                       size="40">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                </div>
            </div>

        </div>
        <script type="text/javascript">
            $('#addMobile').click(function () {
                $('#order_mobiles').append(`<div class="form-group form-inline" style="padding: 2px"><a title="حذف"  class="del-num btn btn-sm btn-danger"><span class="fa fa-times-circle"></span></a><input dir="ltr" class="form-control"  style="width:120px;text-align: left;" name="order_mobile[]"></div>`);
            });
            $('#addPeykPriceDiscount').click(function () {
                $('#peykPriceDiscount').append(`<div class="form-group form-inline" style="padding: 2px"><a title="حذف"  class="del-num btn btn-sm btn-danger"><span class="fa fa-times-circle"></span></a><input dir="ltr" class="form-control"  style="width:120px;text-align: left;" name="peyk_discount[]"> درصد تخفیف برای خرید بیشتر از <input dir="ltr" class="form-control"  style="width:120px;text-align: left;" name="peyk_discount[]"> تومن </div>`);
            });
            $('#addCustomerClub').click(function () {
                $('#customerClub').append(`<div class="form-group form-inline" style="padding: 2px"><a title="حذف" class="del-num btn btn-sm btn-danger"><span class="fa fa-times-circle"></span></a> سطح <input dir="ltr" class="form-control" style="width:120px;text-align: left;" name="customer_club_levels[]"> حداقل امتیاز <input dir="ltr" class="form-control" style="width:120px;text-align: left;"  name="customer_club_levels_min[]"> حداکثر امتیاز <input dir="ltr" class="form-control" style="width:120px;text-align: left;"  name="customer_club_levels_max[]"></div>`);
                $('#customerClubLevels').append(`<div class="form-group form-inline" style="padding: 2px"><a title="حذف" class="del-num btn btn-sm btn-danger"><span class="fa fa-times-circle"></span></a> سطح <input dir="ltr" class="form-control" style="width:120px;text-align: left;" name="customer_club_levels_for_pay[]"> هر <input dir="ltr" class="form-control" style="width:120px;text-align: left;" name="customer_club_levels_score_per_pay[]"> امتیاز <input dir="ltr" class="form-control" style="width:120px;text-align: left;"  name="customer_club_levels_amount_per_pay[]"> تومان`);
            });
            $('#addMarketTel').click(function () {
                $('#market_tels').append(`<div class="form-group form-inline" style="padding: 2px"><a title="حذف"  class="del-num btn btn-sm btn-danger"><span class="fa fa-times-circle"></span></a><input dir="ltr" class="form-control"  style="width:120px;text-align: left;" name="market_tel[]"></div>`);
            });
            $(document).on('click', '.del-num', function () {
                $(this).parent().remove();
            });
            let row = [];
            let col = [];
            for (let i = 0; i <= 6; i++) {
                for (let j = 0; j <= 23; j++) {
                    col[0] = {'day': i};
                    col.push({
                        'start': `${j < 10 ? '0' + j : j}:00`,
                        'end': `${j < 10 ? '0' + j : j}:30`,
                        'selected': false,
                        'id': `${i + '.' + j + 'even'}`,
                        'label': `${j}`
                    })
                    col.push({
                        'start': `${j < 10 ? '0' + j : j}:30`,
                        'end': `${j + 1 < 10 ? '0' + (j + 1) : j + 1}:00`,
                        'selected': false,
                        'id': `${i + '.' + j + '.odd'}`,
                        'label': `${j}`
                    })
                }
                row[i] = col;
                col = [];
            }
            $(document).ready(function () {
                $.ajax({
                    type: "GET",
                    url: `/ocms/settingData/1`,
                    success: function (response) {

                        let market = response.data


                        if (response.status === 'ok') {
                            if (market.peyk_price_discount !== '') {
                                $('#peykPriceDiscount').empty();
                            }
                            $.each(JSON.parse(market.peyk_price_discount), function (i, val) {
                                $.each(val, function (key, value) {
                                    $('#peykPriceDiscount').append(`<div class="form-group form-inline" style="padding: 2px"><a title="حذف"  class="del-num btn btn-sm btn-danger"><span class="fa fa-times-circle"></span></a><input dir="ltr" class="form-control"  style="width:120px;text-align: left;" value="${key}" name="peyk_discount[]"> درصد تخفیف برای خرید بیشتر از <input dir="ltr" class="form-control"  style="width:120px;text-align: left;" value="${value}" name="peyk_discount[]"> تومن </div>`);
                                });
                            });

                            if (market.customer_club !== '') {
                                $('#customerClub').empty();
                            }
                            $.each(JSON.parse(market.customer_club)['levels'], function (i, val) {
                                $('#customerClub').append(`<div class="form-group form-inline" style="padding: 2px"><a title="حذف" class="del-num btn btn-sm btn-danger"><span class="fa fa-times-circle"></span></a> سطح <input dir="ltr" class="form-control" style="width:120px;text-align: left;" value="${i}" name="customer_club_levels[]"> حداقل امتیاز <input dir="ltr" class="form-control" style="width:120px;text-align: left;" value="${val['min_score']}" name="customer_club_levels_min[]"> حداکثر امتیاز <input dir="ltr" class="form-control" style="width:120px;text-align: left;" value="${val['max_score']}" name="customer_club_levels_max[]"></div>`);
                            });

                            $("input[name='score_of_success_order']").val(JSON.parse(market.customer_club)['score_of_success_order']);

                            $.each(JSON.parse(market.customer_club)['convert_score_to_wallet_money'], function (i, val) {
                                $('#customerClubLevels').append(`<div class="form-group form-inline" style="padding: 2px"><a title="حذف" class="del-num btn btn-sm btn-danger"><span class="fa fa-times-circle"></span></a> سطح <input dir="ltr" class="form-control" style="width:120px;text-align: left;" value="${i}" name="customer_club_levels_for_pay[]"> هر <input dir="ltr" class="form-control" style="width:120px;text-align: left;" value="${val['score']}" name="customer_club_levels_score_per_pay[]"> امتیاز <input dir="ltr" class="form-control" style="width:120px;text-align: left;" value="${val['amount']}" name="customer_club_levels_amount_per_pay[]"> تومان </div>`);
                            });

                            $('#marketSmsNumber').text(market.sms_number);
                            $('#market_name').text(market.name)
                            $('#market_address').text(market.address)
                            $('#scheduler_latency_day').val(market.scheduler_latency_day)
                            $('#express').prop('checked', market.express === '1')
                            $('#cash').prop('checked', market.cash === '1')
                            $('#scheduled').prop('checked', market.scheduled === '1')
                            $('#incity_express_peykPrice_percent').val(market.incity_express_peykPrice_percent)
                            $('#incity_express_peykPrice_threshold').val(market.incity_express_peykPrice_threshold)
                            $('#incity_scheduled_peykPrice_percent').val(market.incity_scheduled_peykPrice_percent)
                            $('#incity_scheduled_peykPrice_threshold').val(market.incity_scheduled_peykPrice_threshold)
                            $('#close_market').prop('checked', market.service === '1')
                            $('#supports').val(market.support.join(' - '))
                            $('#delay_support').val(market.delay_support.join(' - '))


                            let market_tels = ``;


                            $.each(market.tel, function (key, item) {
                                market_tels += `<div class="form-group form-inline" style="padding: 2px"><a title="حذف"  class="del-num btn btn-sm btn-danger"><span class="fa fa-times-circle"></span></a><input dir="ltr" class="form-control" value="${item}" style="width:120px;text-align: left;" name="market_tel[]"></div>`
                            })
                            $('#market_tels').html(market_tels)


                            let options = {
                                onText: "باز",
                                onColor: 'primary',
                                size: 'normal',
                                offColor: 'danger',
                                offText: "بسته",
                                animate: true
                            };

                            $("#close_market").bootstrapSwitch(options)
                        } else {
                            swal({
                                type: 'error',
                                title: data.message
                            });
                        }
                    }
                });

                $(".changeTel").click(function () {
                    let tel = $(this).data('id')
                    $.ajax({
                        type: "POST",
                        url: "/ocms/changeTel",
                        data: {tel, "_token": "{{ csrf_token() }}"},
                        success: function (data) {
                            if (data.status === 'ok') {
                                $('#marketSmsNumber').show().text(data.number);
                            } else {
                                swal({
                                    type: 'error',
                                    title: data.message
                                });
                            }
                        }
                    });
                });
                $("#change_order_mobiles").click(function () {
                    $('#order_mobile_error').text('')
                    let order_mobiles = $("input[name='order_mobile[]']")
                        .map(function () {
                            return $(this).val().length === 11 ? $(this).val() : null;
                        }).get();
                    $.ajax({
                        type: "POST",
                        url: "/ocms/change_order_mobiles",
                        data: {order_mobiles, "_token": "{{ csrf_token() }}"},
                        success: function (response) {
                            if (response.status === 'ok') {
                                $('#order_mobile_error').show().text(response.message);
                            } else {
                                swal({
                                    type: 'error',
                                    title: response.message
                                });
                            }
                        },
                        error: function (response) {
                            alert(response.responseJSON.message)
                        }
                    });
                });
                $("#change_peyk_discount").click(function () {
                    $('#peyk_price_message').text('')
                    let peyk_discount = $("input[name='peyk_discount[]']")
                        .map(function () {
                            return $(this).val()
                        }).get();
                    $.ajax({
                        type: "POST",
                        url: "/ocms/change_peyk_discount",
                        data: {peyk_discount: peyk_discount, "_token": "{{ csrf_token() }}"},
                        success: function (response) {
                            if (response.status === 'ok') {
                                $('#peyk_price_message').show().text(response.message);
                            } else {
                                swal({
                                    type: 'error',
                                    title: response.message
                                });
                            }
                        },
                        error: function (response) {
                            alert(response.responseJSON.message)
                        }
                    });
                });
                $("#change_customer_club").click(function () {
                    $('#customer_club_message').text('')
                    let customer_club_levels = $("input[name='customer_club_levels[]']")
                        .map(function () {
                            return $(this).val()
                        }).get();
                    let customer_club_levels_min = $("input[name='customer_club_levels_min[]']")
                        .map(function () {
                            return $(this).val()
                        }).get();
                    let customer_club_levels_max = $("input[name='customer_club_levels_max[]']")
                        .map(function () {
                            return $(this).val()
                        }).get();
                    let customer_club_levels_for_pay = $("input[name='customer_club_levels_for_pay[]']")
                        .map(function () {
                            return $(this).val()
                        }).get();
                    let customer_club_levels_score_per_pay = $("input[name='customer_club_levels_score_per_pay[]']")
                        .map(function () {
                            return $(this).val()
                        }).get();
                    let customer_club_levels_amount_per_pay = $("input[name='customer_club_levels_amount_per_pay[]']")
                        .map(function () {
                            return $(this).val()
                        }).get();
                    let score_of_success_order = $("input[name='score_of_success_order']").val();

                    $.ajax({
                        type: "POST",
                        url: "/ocms/change_customer_club",
                        data: {
                            data: {
                                customer_club_levels,
                                customer_club_levels_min,
                                customer_club_levels_max,
                                customer_club_levels_for_pay,
                                customer_club_levels_score_per_pay,
                                customer_club_levels_amount_per_pay,
                                score_of_success_order
                            }, "_token": "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            console.log(JSON.stringify(response))
                            if (response.status === 'ok') {
                                $('#customer_club_message').show().text(response.message);
                            } else {
                                swal({
                                    type: 'error',
                                    title: response.message
                                });
                            }
                        },
                        error: function (response) {
                            alert(response.responseJSON.message)
                        }
                    });
                });
                $("#change_market_tels").click(function () {
                    $('#market_tel_error').text('');
                    let market_tels = $("input[name='market_tel[]']")
                        .map(function () {
                            return $(this).val().length > 4 ? $(this).val() : null;
                        }).get();
                    $.ajax({
                        type: "POST",
                        url: "/ocms/change_market_tels",
                        data: {market_tels, "_token": "{{ csrf_token() }}"},
                        success: function (response) {
                            console.log(response);
                            if (response.status === 'ok') {
                                $('#market_tel_error').show().text(response.message);
                            } else {
                                swal({
                                    type: 'error',
                                    title: response.message
                                });
                            }
                        },
                        error: function (response) {
                            alert(response.responseJSON.message)
                        }
                    });
                });
                $("#change_market_address").click(function () {
                    $('#market_address_error').text('');
                    let market_address = $('#market_address').val()
                    $.ajax({
                        type: "POST",
                        url: "/ocms/change_market_address",
                        data: {market_address, "_token": "{{ csrf_token() }}"},
                        success: function (response) {
                            if (response.status === 'ok') {
                                $('#market_address_error').show().text(response.message);
                            } else {
                                swal({
                                    type: 'error',
                                    title: response.message
                                });
                            }
                        },
                        error: function (response) {
                            alert(response.responseJSON.message)
                        }
                    });
                });
                $("#change_shipping_method").click(function () {
                    $('#shipping_method_error').text('');
                    let express = $('#express').prop('checked') ? '1' : '0';
                    let cash = $('#cash').prop('checked') ? '1' : '0';
                    let scheduled = $('#scheduled').prop('checked') ? '1' : '0';
                    let incity_express_peykPrice_percent = $('#incity_express_peykPrice_percent').val();
                    let incity_express_peykPrice_threshold = $('#incity_express_peykPrice_threshold').val();
                    let incity_scheduled_peykPrice_percent = $('#incity_scheduled_peykPrice_percent').val();
                    let incity_scheduled_peykPrice_threshold = $('#incity_scheduled_peykPrice_threshold').val();
                    let scheduler_latency_day = $('#scheduler_latency_day').val();
                    if (express === '1' || scheduled === '1') {
                        $.ajax({
                            type: "POST",
                            url: "/ocms/change_shipping_method",
                            data: {
                                express,
                                cash,
                                scheduled,
                                incity_express_peykPrice_percent,
                                incity_express_peykPrice_threshold,
                                incity_scheduled_peykPrice_percent,
                                incity_scheduled_peykPrice_threshold,
                                scheduler_latency_day,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                if (response.status === 'ok') {
                                    $('#shipping_method_error').show().text(response.message);
                                } else {
                                    swal({
                                        type: 'error',
                                        title: response.message
                                    });
                                }
                            },
                            error: function (response) {
                                alert(response.responseJSON.message)
                            }
                        });
                    } else {
                        $('#shipping_method_error').text('حداقل یک روش برای ارسال انتخاب نمایید');
                    }
                });


                $(".ipg").click(function () {
                    $.ajax({
                        type: "POST",
                        url: '/ocms/changeBank',
                        data: {bank: $(this).data('id'), "_token": "{{ csrf_token() }}"},
                        success: function (response) {
                            if (response.status === 'ok') {
                                $('#showbank').show().text(response.message);
                            }
                        },
                        error: function (response) {
                            swal({
                                type: 'error',
                                title: response.responseJSON.message
                            });
                        }
                    });
                });

                $("#btn-support").click(function () {
                    $.ajax({
                        type: "POST",
                        url: '/ocms/changeSupport',
                        data: {support: $('#supports').val(), "_token": "{{ csrf_token() }}"},
                        success: function (response) {
                            if (response.status === 'ok') {
                                $('#support_message').show().text(response.message);
                            }
                        },
                        error: function (response) {
                            $('#support_message').show().text("");

                            swal({
                                type: 'error',
                                title: response.responseJSON.message
                            });
                        }
                    });
                });
                $("#btn-delay").click(function () {
                    $.ajax({
                        type: "POST",
                        url: '/ocms/changeDelayNum/1',
                        data: {delay: $('#delay_support').val(), "_token": "{{ csrf_token() }}"},
                        success: function (response) {
                            if (response.status === 'ok') {
                                $('#showDelay').show().text(response.message);
                            }
                        },
                        error: function (response) {
                            $('#showDelay').show().text("");
                            swal({
                                type: 'error',
                                title: response.responseJSON.message
                            });
                        }
                    });
                });

                $(document).on('change', '.time', function () {
                    if (!$(this).parent().hasClass("check"))
                        $(this).parent().toggleClass("highlight");
                });

                _get_market_time()

            })
            _get_market_time = function () {
                $.ajax({
                    type: "GET",
                    url: '/ocms/get_market_times',
                    success: function (response) {
                        if (response.status === 'ok') {
                            let t_row = ``;
                            let t_col = ``;
                            let day_label = '';
                            $.each(row, function (key, row_item) {
                                switch (row_item[0].day) {
                                    case 0:
                                        day_label = 'شنبه';
                                        break;
                                    case 1:
                                        day_label = 'یکشنبه';
                                        break;
                                    case 2:
                                        day_label = 'دوشنبه';
                                        break;
                                    case 3:
                                        day_label = 'سه شنبه';
                                        break;
                                    case 4:
                                        day_label = 'چهار شنبه';
                                        break;
                                    case 5:
                                        day_label = 'پنج شنبه';
                                        break;
                                    case 6:
                                        day_label = 'جمعه';
                                        break;
                                }
                                t_row += `<tr><td>${day_label}</td>`;
                                $.each(row_item, function (index, col) {
                                    if (index > 0)

                                        t_col += `<td style="width: 5px;font-size: 10px" class="time ${response.data.findIndex(x => x.day === row_item[0].day && x.start == col.start && x.end == col.end) >= 0 ? 'highlight' : 'default'} " title="${col.start}-${col.end}" data-start="${col.start}" data-end="${col.end}" data-day="${row_item[0].day}">${col.start}-${col.end}</td>`
                                })
                                t_row += t_col + `<tr>`
                                t_col = ``;
                            })
                            $('#market_time').html(t_row);
                        }
                    },
                    error: function (response) {
                        $('#showDelay').text("<a class='btn btn-warning' onclick='_get_market_time()'>تلاش مجدد</a>");
                    }
                });
            }
            $(document).on('click', '.time', function () {
                if ($(this).hasClass('highlight')) {
                    $(this).removeClass('highlight')
                    $(this).addClass('default')
                } else {
                    $(this).addClass('highlight')
                    $(this).removeClass('default')
                }
            })
            $(document).on('click', '#save_market_time', function () {
                $('#market_time_message').text('')
                let days = [];
                let item = {};
                $(".highlight").each(function () {
                    item.day = $(this).data('day');
                    item.start = $(this).data('start');
                    item.end = $(this).data('end');
                    days.push(item)
                    item = {}
                });
                $.ajax({
                    type: "POST",
                    url: '/ocms/market_times',
                    data: {days, "_token": "{{csrf_token()}}"},
                    success: function (response) {
                        if (response.status === 'ok') {
                            console.log(response)
                            $('#market_time_message').text(response.message)
                        }
                    },
                    error: function (response) {
                        alert(response.responseJSON.message)
                    }
                })
            })

            $("#close_market").on('switchChange.bootstrapSwitch', function (event, state) {
                let service = '0';
                if (state === true) {
                    service = '1'
                } else {
                    $('#why_off').modal('show')
                }
                $.ajax({
                    type: "POST",
                    url: '/ocms/toggle_market_service',
                    data: {service, "_token": "{{ csrf_token() }}"}
                }).done(function (result) {
                    console.log('on');
                });
            });
            $(document).on('click', '#why_off_submit', function () {
                $("#why_off_error").val('')
                let why_off = $('#why_off_user').val()
                if (why_off.length < 3) {
                    $("#why_off_error").val('حداقل 3 حرف وارد نمایید')
                } else {
                    $.ajax({
                        type: "POST",
                        url: '/ocms/market_service_why_off',
                        data: {why_off, "_token": "{{ csrf_token() }}"},
                        success: function (result) {
                            $('#why_off').modal('hide')
                        },
                        error: function (response) {
                            $("#why_off_error").val(response.responseJSON.message)
                        }
                    })
                }
            })
        </script>

@endsection
