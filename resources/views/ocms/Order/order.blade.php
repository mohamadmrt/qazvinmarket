@extends('ocms.master')
@section('content')
    <div id="modals">

    </div>
    <div class="modal fade" id="balanceModal" role="dialog">
        <div class="modal-dialog" style="text-align: right">
            <!-- Modal content-->
            <div class="modal-content">
                <form id="delayReasonForm" class="form-inline" role="form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">افزایش اعتبار کاربر</h4>
                    </div>
                    <div id="balance_error">
                    </div>
                    <div class="modal-body">
                        <span>اعتبار فعلی:</span>
                        <span name="currentBalance" class="currentBalance"></span>
                        <span>ریال</span>
                        <br>
                        <p>
                        <div class="form-group">
                            <label for="delayReason">مبلغ(به ریال):</label>
                            <br/>
                            <input type="text" id="balance" name="balance" style="width: 400px;" class="form-control"
                                   value=""/>
                            <input type="hidden" name="userId" id="user_id" class="user_id">
                            <input type="hidden" name="order_id" id="order_id">
                            {{--<input type="hidden"  name="currentBalance" class="currentBalance">--}}
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-default" value="ذخیره">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Cancel Modal -->
    <div class="modal fade" id="cancel_dialog" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background-color: #4EAEE0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel" style="color: white;"> لفو سفارش </h4>
                </div>

                <div class="modal-body">
                    <div id="error_register" class="row col-md-12 error-log"></div>
                    <div id="success_register" class="row col-md-12 success-log"></div>
                    <br>
                    <div class="form-group">
                        <div class="input-group">
                            <h4 id="text_cancel"></h4>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="hidden" name="order_id" id="order_id" value="">
                            <input type="hidden" name="state" id="state" value="">
                            <input class="btn btn-primary" value="بله" name="submit" type="button" id="submit"
                                   size="40">
                            <button type="button" class="btn btn-default" data-dismiss="modal">خروج</button>
                            <br><br>
                            <div id="error_log" class="row col-md-12 error_log"></div>
                            <div id="success_log" class="row col-md-12 success_log"></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="col-md-10" id="main-content" style="padding-top:5px;padding-left: 40px;">
        <div align="center">
            <div class="row" style="margin: 0px">
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon" data-mddatetimepicker="true"
                             data-targetselector="#search_by_start_date" data-trigger="click">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                        <input style="background-color: white; cursor:context-menu;" type="text" class="form-control"
                               id="search_by_start_date" placeholder="از تاریخ" onchange="_search(1)"
                               name="exampleInput1"/>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group ">
                        <div class="input-group-addon" data-mddatetimepicker="true"
                             data-targetselector="#search_by_end_date" data-trigger="click">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                        <input style="background-color: white;cursor: context-menu;" type="text" class="form-control"
                               onchange="_search(1)" id="search_by_end_date" placeholder="تا تاریخ"
                               name="exampleInput2"/>
                    </div>
                </div>
            </div>
            <div class="panel panel-info panel-table radius2px">
                <div class="panel-heading">
                    <div style="text-align: center;">نتایج یافت شده: <span id="total_result"></span></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead style="background-color: #969696;">
                        <tr>
                            <td nowrap="nowrap" style="text-align: center">شناسه</td>
                            <td nowrap="nowrap" style="text-align: center">زمان سفارش</td>
                            <td nowrap="nowrap" style="text-align: center">تایید ارسال</td>
                            <td nowrap="nowrap" style="text-align: center">تأخیر دارد</td>
                            <td nowrap="nowrap" style="text-align: center">نام سوپرمارکت</td>
                            <td nowrap="nowrap" style="text-align: center">نام</td>
                            <td style="text-align: center">تلفن</td>
                            <td style="text-align: center">منطقه</td>
                            <td style="text-align: center">آدرس</td>
                            <td style="text-align: center">توضیحات</td>
                            <td nowrap="nowrap" style="text-align: center">هزینه / نام پیک</td>
                            <td nowrap="nowrap" style="text-align: center">کل مبلغ خرید(تومان)</td>
                            <td style="text-align: center;width: 90px">روش پرداخت</td>
                            <td style="text-align: center;width: 90px">نوع سفارش</td>
                            <td style="text-align: center;width: 90px">وضعیت چاپ</td>
                            <td style="text-align: center">تاریخ دریافت پیش سفارش</td>
                            <td style="text-align: center">عملیات</td>
                        </tr>
                        <tr>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_id"></td>
                            <td></td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)" type="text"
                                        id="search_by_is_confirmed">
                                    <option value="">همه</option>
                                    <option value="1">تایید شده</option>
                                    <option value="0">تایید نشده</option>
                                </select>
                            </td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)" type="text"
                                        id="search_by_is_delayed">
                                    <option value="">همه</option>
                                    <option value="1">دارد</option>
                                    <option value="0">ندارد</option>
                                </select>
                            </td>
                            <td>
                                <select class="search_filter" style="width: 100%" onchange="_search(1)" type="text"
                                        id="search_by_market">
                                </select>
                            </td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_user_name">
                            </td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_user_tel">
                            </td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_area"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_address">
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_description">
                            </td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)" type="text"
                                        id="search_by_peyk_name">

                                </select>
                            </td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_amount"></td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)" type="text"
                                        id="search_by_bank">
                                    <option value="">همه</option>
                                    <option value="4">نقدی</option>
                                    <option value="1">درگاه ملت</option>
                                    <option value="3">کیف پول</option>
                                </select>
                            </td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)" type="text"
                                        id="search_by_type">
                                    <option value="">همه</option>
                                    <option value="express">سریع</option>
                                    <option value="scheduled">زمانبندی</option>
                                    <option value="verbal">حضوری</option>
                                </select>
                            <td>
                                <select class="search_filter" style="width: 100%" onchange="_search(1)" type="text"
                                        id="search_by_printed">
                                    <option value="">همه</option>
                                    <option value="1">بله</option>
                                    <option value="0">خیر</option>
                                </select>
                            </td>
                            <td><input class="search_filter" style="width: 100%" type="text"
                                       id="search_by_porder_date_"></td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody id="recordsTable">
                        <tr>
                            <td colspan="14">در حال دریافت اطلاعات...</td>
                        </tr>
                        </tbody>

                    </table>
                    <div class=" " style="text-align:center; direction:rtl; margin-top:35px ;margin-bottom: 35px;">
                        <button id="first-page" class="btn paginate" style="float:none;margin: 1px"> <<</button>
                        <button id="prev-page" class="btn paginate" style="float:none;margin: 1px"> <</button>
                        <button id="page-number" class="btn btn-success" style="float:none;margin: 1px"> 1</button>
                        <button id="next-page" class="btn paginate" style="float:none;margin: 1px"> ></button>
                        <button id="last-page" class="btn paginate" style="float:none;margin: 1px"> >></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        $(document).ready(function () {
            _get_filters()
            setInterval(function () {
                _search(1)
            }, 120000)
        })
        _get_filters = function () {
            $.ajax({
                type: "GET",
                url: "/ocms/get_markets/",
                data: {"_token": "{{ csrf_token() }}"},
                success: function (data) {
                    if (data.status === 'ok') {
                        let markets = data.markets;
                        let peyk_names = data.peyk_names;
                        let markets_options = `<option value="">همه</option>`
                        let peyks_options = `<option value="">همه</option>`
                        $.each(markets, function (key, market) {
                            markets_options += `<option value=${market.id}>${market.name}</option>`
                        })
                        $.each(peyk_names, function (key, peyk) {
                            peyks_options += `<option value=${peyk.courier}>${peyk.courier}</option>`
                        })
                        $('#search_by_market').html(markets_options);
                        $('#search_by_peyk_name').html(peyks_options);
                    }
                },
                error: function () {
                    $('#search_by_market').html(`<a class="btn btn-warning" onclick="_get_merkets()">تلاش مجدد<i class="fas fa-repeat"></i></a>`)
                }
            });
        }
        $(document).on("keyup", ".search_filter", function () {
            _search(1);
        })
        $(document).on("click", ".paginate", function () {
            _search($(this).attr('page'));
        })


        _search = function (page) {
            let params = {};
            params.search_by_start_date = $('#search_by_start_date').val() ? $('#search_by_start_date').val() : '';
            params.search_by_end_date = $('#search_by_end_date').val() ? $('#search_by_end_date').val() : '';
            params.search_by_name = $('#search_by_name').val() ? $('#search_by_name').val() : '';
            params.search_by_is_confirmed = $('#search_by_is_confirmed').val() ? $('#search_by_is_confirmed').val() : '';
            params.search_by_is_delayed = $('#search_by_is_delayed').val() ? $('#search_by_is_delayed').val() : '';
            params.search_by_bank = $('#search_by_bank').val() ? $('#search_by_bank').val() : '';
            params.search_by_porder_date = $('#search_by_porder_date').val() ? $('#search_by_porder_date').val() : '';
            params.search_by_porder = $('#search_by_porder').val() ? $('#search_by_porder').val() : '';
            params.search_by_id = $('#search_by_id').val() ? $('#search_by_id').val() : '';
            params.search_by_is_lated = $('#search_by_is_lated').val() ? $('#search_by_is_lated').val() : '';
            params.search_by_market = $('#search_by_market').val() ? $('#search_by_market').val() : '';
            params.search_by_user_name = $('#search_by_user_name').val() ? $('#search_by_user_name').val() : '';
            params.search_by_type = $('#search_by_type').val() ? $('#search_by_type').val() : '';
            params.search_by_printed = $('#search_by_printed').val() ? $('#search_by_printed').val() : '';
            params.search_by_area = $('#search_by_area').val() ? $('#search_by_area').val() : '';
            params.search_by_user_tel = $('#search_by_user_tel').val() ? $('#search_by_user_tel').val() : '';
            params.search_by_address = $('#search_by_address').val() ? $('#search_by_address').val() : '';
            params.search_by_peyk_name = $('#search_by_peyk_name').val() ? $('#search_by_peyk_name').val() : '';
            params.search_by_amount = $('#search_by_amount').val() ? $('#search_by_amount').val() : '';

            $.ajax({
                method: 'GET',
                url: `/ocms/orderList/?page=${page}`,
                data: {params},
                success: function (result) {
                    $("#total_result").text(result.paginate.total)
                    if (result.data.length < 1) {
                        $('#recordsTable').html('');
                    } else {
                        let orders = result.data;
                        let paginate = result.paginate;
                        let data = '';
                        let modals = '';
                        $.each(orders, function (key, item) {
                            data += `<tr style="background-color:${item.status < 2 ? '#FFD9B3' : ''}${item.status == 2 ? '#ffbfbf' : ''}${item.status == 4 ? '#ffffff' : ''}" title="${item.valid = 0 ? 'نامعتبر' : ''}" >`;
                            data += `<td>${item.id}</td>`;
                            data += `<td>${item.created_at}</td>`;
                            data += `<td>${item.is_confirm !== "1378/10/11 00:00:00" ? item.is_confirm : '<button class="btn btn-success confirm" onclick="confirmOrder(' + item.id + ')" title="تایید ارسال"><i class="fa fa-check"></i></button>'}</td>`;
                            data += `<td><span class="label ${item.delayed ? 'label-danger' : 'label-success'}">${item.delayed ? 'بله' : 'خیر'}</span></td>`;
                            data += `<td><strong>${item.market_name}</strong><br>${item.market_tel.join(' - ')}<br>${item.market_mobile.replace(/-/g, '<br>')}</td>`;
                            data += `<td>${item.name}<br><span class="btn btn-danger btn-sm">«تعداد خرید:${item.buy_count}»</span><hr>${item.user_isQasedak ? 'قاصدکی: ' + formatPrice(item.Amount_ghasedak) : ''}</td>`;
                            data += `<td>${item.tel}</td>`;
                            data += `<td>${item.peyk_zones ? item.peyk_zones : 'منطقه یافت نشد'}</td>`;
                            data += `<td>${item.address}</td>`;
                            data += `<td>${item.description != null ? item.description : ''}</td>`;
                            data += `<td>${formatPrice(item.peyk_price)}<hr>${item.peyk_name}</td>`;
                            if (item.coupon !== null) {
                                var discount_type = 'درصد';
                                if (item.coupon.discount_type === 'price') {
                                    discount_type = 'تومان';
                                }
                            }
                            data += `<td  ${item.coupon !== null ? 'style="background-color: #ffbfbf"' : ''}>${formatPrice(item.sum_of_cargos_price + item.peyk_price)}<hr>${item.discount_ghasedak !== 0 ? '<strong style="color: red" ">تخفیف: </strong>' + formatPrice(item.discount_ghasedak) : ''}${item.coupon !== null ? '<strong style="color: red" ">تخفیف: </strong>' + item.coupon.title : ''}<br>${item.coupon !== null ? '<strong style="color: red" ">کد: </strong>' + item.coupon.code : ''}<br>${item.coupon !== null ? '<strong style="color: red" ">نوع: </strong>' + discount_type : ''}<br>${item.coupon !== null ? '<strong style="color: red" ">مبلغ: </strong>' + item.coupon.discount_amount : ''}</td>`;
                            data += `<td>${item.bank === '1' ? '<strong class="label label-danger">درگاه ملت</strong>' : ''}
${item.bank === '3' ? '<strong class="label label-warning">کیف پول</strong>' : ''}
${item.bank === '4' ? '<strong class="label label-success">نقدی</strong>' : ''}
<hr>${item.mobile === 'true' ? 'موبایل' : item.os === 'webApp' ? 'وب اپ' : 'دسکتاپ'}</td>`;
                            data += `<td style="background-color: ${item.type === "زمانبندی" ? '#a1dfc5' : ''}"><span  class="label ${item.type === "سریع" ? 'label-success' : ''} ${item.type === "زمانبندی" ? 'label-danger' : ''}${item.type === "حضوری" ? 'label-warning' : ''}">${item.type}</span>${item.type === 'حضوری' ? '<hr>' + item.deliver_timestamp : ''}${item.type === 'زمانبندی' ? '<hr>' + item.deliver_time : ''}</td>`;
                            data += `<td>${item.printed === '1' ? '<button title="چاپ شده" class="btn btn-success"><i class="fas fa-check"></i></button>' : '<button title="چاپ نشده" class="btn btn-danger"><i class="fas fa-times-circle"></i></button>'}</td>`;
                            data += `<td>${item.porder_date != null ? item.porder_date + '- ساعت: ' + item.porder_time : ''}</td>`;
                            data += `<td>
                                    <button type="button" title=" لیست سفارشات" data-id="${item.id}" class="btn btn-block btn-default" data-toggle="modal" data-target="#ordersModal${item.id}">
                                    <span class="fa fa-eye"></span>
                                    </button>
                                    ${item.status > 2 ? '<button title="ارسال مجدد به محک" type="button" data-id="' + item.id + '" class="resend-factor btn btn-block btn-warning"><span class="fa fa-repeat"></span></button>' : ''}
                                    ${item.status < 2 ? '<button title="موفق کردن سفارش" type="button" data-id="' + item.id + '" class="success-order btn btn-block btn-info"><span class="fa fa-check"></span></button>' : ''}
                                    <button class="btn btn-primary btn-block balanceModal" data-toggle="modal" data-target="#balanceModal" data-id="[${item.id},${item.user_wallet},${item.user_id}]" title="افزایش اعتبار کاربر"><span class="fas fa-dollar-sign"></span></button>
                                    <button style="${item.status !== "4" ? 'display:none' : ''}" title="لغوسفارش" type="button" onclick="cancel_order('${item.id}',${item.valid})" class="btn btn-block btn-danger"><span class="fas fa-trash-alt"></span></button>
                                    <button title="چاپ" type="button" class="btn btn-default" onclick="window.open('/ocms/1/factorPrint/${item.id}','_blank')"><i class="fas fa-print fa-lg"></i></button></td>`;
                            data += `</tr>`;
                            modals += `<div id="ordersModal${item.id}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">لیست سفارشها</h4>
                            </div>
                            <div class="modal-body"><table class="table table-hover"><thead><td>ردیف</td><td>کالا</td><td>تعداد</td><td>قیمت واحد</td><td>قیمت کل</td></thead>`;
                            $.each(item.cargos, function (index, cargo) {
                                modals += `<tr><td>${index + 1}</td><td>${cargo.name}</td><td>${cargo.count}</td><td>${cargo.main_price}</td><td>${parseInt(cargo.count) * parseInt(cargo.main_price)}</td></tr>`
                            })
                            modals += `</table> </div>`;
                            modals += `<div class="alert alert-info">توضیحات: ${item.comment ? item.comment : ''}</div>`;
                            modals += `<div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">خروج</button>
                            </div>
                            </div>
                            </div>
                            </div>`;

                        })
                        $('#recordsTable').html(data);
                        $('#modals').html(modals);
                        $('#page-number').text(paginate.current_page).attr('page', paginate.current_page)
                        $('#last-page').attr('page', paginate.last_page)
                        if (paginate.current_page === 1)
                            $('#first-page, #prev-page').attr('disabled', 'disabled');
                        else {
                            $('#first-page, #prev-page').removeAttr('disabled');
                            $('#first-page').attr('page', 1);
                            $('#prev-page').attr('page', paginate.current_page + 1);
                        }
                        $('#prev-page').attr('page', paginate.current_page - 1);
                        if (paginate.current_page < paginate.last_page) {
                            $('#last-page, #next-page').removeAttr('disabled');
                            $('#last-page').attr('page', paginate.last_page);
                            $('#next-page').attr('page', paginate.current_page + 1);
                        } else {
                            $('#last-page, #next-page').attr('disabled', 'disabled');
                        }
                    }
                },
                error: function () {
                    $('#recordsTable').html(`<a class="btn btn-warning" onclick="_search(1)">تلاش مجدد<i class="fas fa-repeat"></i></a>`);
                }
            });

        };
        _search(1);

        cancel_order = function (id, state) {
            $('#order_id').val(id);
            $('#text_cancel').text('آیا می خواهید سفارش لغو شود؟');
            $('#cancel_dialog').modal('show');
        };
        $("#submit").click(function () {
            $('#error_log').hide();
            $('#success_log').hide();
            let order_id = $("#order_id").val();
            $.ajax({
                type: "POST",
                url: "/ocms/cancelOrder/" + order_id,
                data: {"_token": "{{ csrf_token() }}"},
                success: function (data) {
                    if (data.status === 'ok') {
                        $('#error_log').hide();
                        $('#cancel_dialog').modal('hide');
                        _search(1);
                    } else {
                        $('#success_log').hide();
                        $('#error_log').show().text(data.message);
                    }
                }
            });
        });
        $(document).on("click", ".balanceModal", function () {
            $('#Error2').html('');
            $('#balance').val('');
            var user_id = $(this).data('id')[2];
            var order_id = $(this).data('id')[0];
            var currentBalance = $(this).data('id')[1];
            $('.user_id').val(user_id);
            $('#order_id').val(order_id);
            $('.currentBalance').text(formatPrice(currentBalance));

        });
        $('#balanceModal').on('submit', function (e) {
            e.preventDefault();
            let balance = $('#balance').val();
            let order_id = $('#order_id').val();
            console.log(order_id);
            if (balance == '')
                $('#balance_error').html('<div class="alert alert-danger">مبلغ را وارد کنید</div>');
            else {
                $.ajax({
                    type: "POST",
                    url: "/ocms/increaseCredit?order_id=" + order_id,
                    data: {balance: balance, order_id: order_id, "_token": "{{ csrf_token()}}"},
                    success: function (data) {
                        if (data.status === 'ok') {
                            swal({
                                type: 'success',
                                title: data.message
                            });
                            $('#balanceModal').modal('hide');
                            _search(1);
                        } else {
                            $('#balance_error').html('<div class="alert alert-danger">' + data.message + '</div>');
                        }
                    }
                });
            }
        });
        $(document).on("click", ".resend-factor", function () {
            if (confirm('آیا از ارسال مجدد به محک اطمینان دارید؟')) {
                let order_id = $(this).data('id');
                $.ajax({
                    method: 'get',
                    url: "/ocms/resend_factor" + '/' + order_id,
                    success: function (result) {
                        alert("با موفقیت ارسال شد")
                    },
                    error: function (result) {
                        alert('خطایی رخ داد')
                    }
                })
            }
        });
        $(document).on("click", ".success-order", function () {
            if (confirm('آیا از موفق کردن سفارش اطمینان دارید؟')) {
                let order_id = $(this).data('id');
                $.ajax({
                    method: 'get',
                    url: "/ocms/success_order" + '/' + order_id,
                    success: function (result) {
                        alert("با موفقیت انجام شد")
                    },
                    error: function (result) {
                        alert('خطایی رخ داد')
                    }
                })
            }
        });

        function confirmOrder($id) {
            if (confirm('آیا از ارسال سفارش اطمینان دارید؟')) {
                $.ajax({
                    method: 'GET',
                    url: "/ocms/confirmOrder" + '/' + $id
                }).done(function (result) {
                    _search(1)
                })
            }
        }
    </script>
@endsection
