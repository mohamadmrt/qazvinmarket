@extends('ocms.master')

@section('content')
    <div id="orders_modals"></div>
    <!-- admin reply Modal -->
    <div class="modal fade" id="replyModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #4EAEE0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel" style="color: white;"> پاسخ مدیر سایت: <span
                            id="comment_id"></span></h4>
                </div>
                <div class="modal-body">
                    <div id="reply_modal_error" class="row error-log"></div>
                    <div class="form-group ">
                        <div class="input-group">
                            <textarea type="text" id="admin_text" name="admin_text" style="width: 568px; height: 127px;"
                                      class="form-control"/></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="btn btn-success" value="ذخیره" name="admin_submit" type="button"
                                   id="admin_submit" size="40"><br>
                            <div class="row col-md-12 error_log"></div>
                            <div class="row col-md-12 success_log"></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{--increase balance--}}
    <div class="modal fade" id="balanceModal" role="dialog">
        <div class="modal-dialog" style="text-align: right">
            <!-- Modal content-->
            <div class="modal-content">
                <form id="delayReasonForm" class="form-inline" role="form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">افزایش اعتبار کاربر</h4>
                    </div>
                    <div id="Error1">
                    </div>
                    <div class="modal-body">
                        <span>اعتبار فعلی:</span>
                        <span class="currentBalance"></span>
                        <span>ریال</span>
                        <br>
                        <div class="form-group">
                            <label for="delayReason">مبلغ(به ریال):</label>
                            <br/>
                            <input type="text" id="balance" name="balance" style="width: 400px;" class="form-control"
                                   value=""/>
                            <input type="hidden" name="comment_id" class="comment_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="ذخیره">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div align="center">
            <div class="row">
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon" data-mddatetimepicker="true"
                             data-targetselector="#search_by_from_date" data-trigger="click">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                        <input style="form-control;background-color: white;cursor: context-menu" type="text"
                               data-mddatetimepicker="true" class="form-control" id="search_by_from_date"
                               placeholder="از تاریخ" onchange="_search(1)" name="exampleInput1"/>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group ">
                        <div class="input-group-addon" data-mddatetimepicker="true"
                             data-targetselector="#search_by_to_date" data-trigger="click">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                        <input style="form-control;background-color: white;cursor: context-menu" type="text"
                               data-mddatetimepicker="true" class="form-control" onchange="_search(1)"
                               id="search_by_to_date" placeholder="تا تاریخ" name="exampleInput2"/>
                    </div>
                </div>
            </div>
            <div class="panel panel-info panel-table radius2px">
                <div class="panel-heading">
                    <div>نتایج یافت شده: <span id="total"></span></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead style="background-color: #969696;">
                        <tr>
                            <td>
                                <div align="center">شناسه</div>
                            </td>
                            <td>
                                <div align="center">زمان</div>
                            </td>
                            <td>
                                <div align="center">نام کاربر</div>
                            </td>
                            <td>
                                <div align="center">تلفن</div>
                            </td>
                            <td width="40%;">
                                <div align="center">متن پیام</div>
                            </td>
                            <td>
                                <div align="center">نام سوپرمارکت</div>
                            </td>
                            <td>
                                <div align="center">وضعیت</div>
                            </td>
                            <td>
                                <div align="center">پاسخ مدیریت</div>
                            </td>
                            <td>
                                <div align="center">تاریخ پاسخ</div>
                            </td>
                            <td>
                                <div align="center">عملیات</div>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_id"></td>
                            <td><input data-mddatetimepicker="true" type="text" onchange="_search(1)"
                                       id="search_by_created_at" name="search_by_created_at"/></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_user_name">
                            </td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_user_tel">
                            </td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_text"></td>
                            <td><select class="search_filter" onchange="_search(1)" style="width: 100%"
                                        id="search_by_market_name">
                                    <option value="">همه</option>
                                    <option value="1">قزوین مارکت</option>
                                </select>
                            </td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)"
                                        id="search_by_status">
                                    <option value="">همه</option>
                                    <option value="0">بررسی نشده</option>
                                    <option value="4">تایید شده</option>
                                    <option value="1">تایید نشده</option>
                                </select>
                            </td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_admin_reply">
                            </td>
                            <td><input onchange="_search(1)" data-mddatetimepicker="true" style="width: 100%"
                                       type="text" id="search_by_admin_reply_date"></td>
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
        $(document).on("keyup", ".search_filter", function () {
            _search(1);
        })
        _search = function (page) {
            let params = {};
            params.search_by_from_date = $('#search_by_from_date').val() ? $('#search_by_from_date').val() : '';
            params.search_by_to_date = $('#search_by_to_date').val() ? $('#search_by_to_date').val() : '';
            params.search_by_id = $('#search_by_id').val() ? $('#search_by_id').val() : '';
            params.search_by_created_at = $('#search_by_created_at').val() ? $('#search_by_created_at').val() : '';
            params.search_by_user_tel = $('#search_by_user_tel').val() ? $('#search_by_user_tel').val() : ' ';
            params.search_by_user_name = $('#search_by_user_name').val() ? $('#search_by_user_name').val() : '';
            params.search_by_text = $('#search_by_text').val() ? $('#search_by_text').val() : '';
            params.search_by_market_name = $('#search_by_market_name').val() ? $('#search_by_market_name').val() : '';
            params.search_by_status = $('#search_by_status').val() ? $('#search_by_status').val() : '';
            params.search_by_admin_reply = $('#search_by_admin_reply').val() ? $('#search_by_admin_reply').val() : '';
            params.search_by_admin_reply_date = $('#search_by_admin_reply_date').val() ? $('#search_by_admin_reply_date').val() : '';

            $.ajax({
                method: 'GET',
                url: `/ocms/commentList/?page=${page}`,
                data: {params: params},
                success: function (result) {
                    let paginate = result.paginate;
                    let comments = result.comments;
                    let data = '';
                    $("#total_result").text(result.paginate.total)
                    $('#total').text(paginate.total)
                    if (result.comments.length < 1) {
                        $('#recordsTable').html('');
                    } else {
                        let orders_modal = ``;
                        $.each(comments, function (key, item) {
                            data += `<tr style="background-color: ${item.status === 'بررسی نشده' ? '#ee7d72' : ''}" title="${item.status === "بررسی نشده" ? 'بررسی نشده' : ''}" >`;
                            data += `<td>${item.id}</td>`;
                            data += `<td>${item.created_at}</td>`;
                            data += `<td>${item.fullname}</td>`;
                            data += `<td>${item.username}</td>`;
                            data += `<td>${item.text}</td>`;
                            data += `<td>${item.market_name}</td>`;
                            data += `<td><div class="label ${item.status === 'بررسی نشده' ? "label-info" : ''}${item.status === 'تایید نشده' ? "label-danger" : ''}${item.status === 'تایید شده' ? "label-success" : ''}">${item.status}</div></td>`;
                            data += `<td>${item.admin_reply}</td>`;
                            data += `<td>${item.replied_at}</td>`;
                            data += `<td>
                                    <button type="button" title=" لیست سفارشات" data-id="${item.id}" class="btn btn-block btn-info" data-toggle="modal" data-target="#ordersModal${item.id}">
                                    <span class="fa fa-eye"></span>
                                    </button>
                                    <button class="btn btn-primary btn-block balanceModal" data-toggle="modal" data-target="#balanceModal" data-id="[${item.id},${item.user_wallet}]" title="افزایش اعتبار کاربر"><span class="fas fa-dollar-sign"></span></button>
<button title="پاسخ به نظر" type="button" data-toggle="modal" data-id="${item.id}" class="btn btn-warning btn-block reply_modal"><span class="fa fa-repeat"></span></button>
<button title="حذف نظر" type="button" onclick="delete_comment('${item.id}')" class="btn btn-block btn-danger" style="background-color: violet;"><span class="fas fa-trash"></span></button>
<button title="${item.status == 'تایید شده' ? "رد نظر" : "تائید نظر" }"
                            onclick="approve_comment('${item.id}')" class="btn btn-block ${item.status == 'تایید شده' ? "btn-danger" : "btn-success" }"><span class="fas ${item.status === '4' ? "fa-times-circle" : "fa-check"}"></span></button>
</td>`;
                            data += `</tr>`;
                            orders_modal += `<div id="ordersModal${item.id}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">لیست سفارشها</h4>
                            </div>
                            <div class="modal-body"><table class="table table-hover"><thead><td>ردیف</td><td>کالا</td><td>تعداد</td><td>قیمت واحد</td><td>قیمت کل</td></thead>`;
                            $.each(item.cargos, function (index, cargo) {
                                orders_modal += `<tr><td>${index + 1}</td><td>${cargo.name}</td><td>${cargo.count}</td><td>${cargo.main_price}</td><td>${parseInt(cargo.count) * parseInt(cargo.main_price)}</td></tr>`
                            })
                            orders_modal += `</table> </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">خروج</button>
                            </div>
                            </div>
                            </div>
                            </div>`;
                        })
                        $('#orders_modals').html(orders_modal);
                        $('#recordsTable').html(data);
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
        $('#balance').keyup(function (event) {

            // skip for arrow keys
            if (event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        });

        delete_comment = function (id) {
            if (confirm("آیا از حذف پیام مطمئن هستید؟")) {
                $.ajax({
                    type: "POST",
                    url: "/ocms/delete_comment/" + id,
                    data: {"_token": "{{ csrf_token()}}"},
                    success: function (data) {
                        _search(1)
                    },
                    error: function () {
                        alert('خطا در عملیات!')
                    }
                });
            }
        }
        approve_comment = function (id) {
            if (confirm("آیا از تغییر وضعیت پیام مطمئن هستید؟")) {
                $.ajax({
                    type: "POST",
                    url: "/ocms/approve_comment/" + id,
                    data: {"_token": "{{ csrf_token()}}"},
                    success: function (data) {
                        _search(1)
                    },
                    error: function () {
                        alert('خطا در عملیات!')
                    }
                });
            }
        }

        $(document).ready(function () {
            $(document).on("click", ".reply_modal", function () {
                $("#comment_id").text($(this).data('id'));
                $('#admin_text').val($(this).closest('tr').find(' td:nth-child(8)').html())
                $('#replyModal').modal('show');
            });

            $("#admin_submit").click(function () {
                $('#reply_modal_error').text();
                let text = $("#admin_text").val();
                let comment_id = $("#comment_id").text()
                if (comment_id === '' || text === '') {
                    $('#reply_modal_error').text('فیلد های مورد نظر را تکمیل نمایید');
                } else {
                    $.ajax({
                        type: "POST",
                        url: `/ocms/reply_admin/${comment_id}`,
                        data: {text, "_token": "{{csrf_token()}}"},
                        success: function (data) {
                            if (data.status === "ok") {
                                $('#admin_text').val('')
                                swal({
                                    type: 'success',
                                    title: data.message
                                }).then((result) => {
                                    $('#replyModal').modal('hide');
                                    _search(1);
                                });

                            } else {
                                swal({
                                    type: 'error',
                                    title: data.message
                                });
                            }
                            $('#admin_comment').modal('hide');
                        }
                    });
                }
            });
            $(document).on("click", ".paginate", function () {
                _search($(this).attr('page'));
            })
            _search(1);
            $(document).on("click", ".balanceModal", function () {
                $('#Error2').html('');
                $('#balance').val('');
                var comment_id = $(this).data('id')[0];
                var currentBalance = $(this).data('id')[1];
                $('.comment_id').val(comment_id);
                $('.currentBalance').text(currentBalance);
            });
            $('#balanceModal').on('submit', function (e) {
                e.preventDefault();
                let balance = $('#balance').val();
                if (balance === '')
                    $('#Error1').html('<div class="alert alert-danger">مبلغ را وارد کنید</div>');
                else {
                    $.ajax({
                        type: "POST",
                        url: "{{url('ocms/increaseCredit')}}",
                        data: {balance, id: $('.comment_id').val(), "_token": "{{ csrf_token()}}"},
                        success: function (data) {
                            if (data.status === 'ok') {
                                swal({
                                    type: 'success',
                                    title: data.message
                                });
                                $('#balanceModal').modal('hide');
                                _search(1);
                            } else {
                                $('#Error1').html('<div class="alert alert-danger">' + data.message + '</div>');
                            }
                        },
                        error: function () {
                            $('#Error1').html('<div class="alert alert-danger">خطای سیستم رخ داد. با مدیر سیستم تماس بگیرید</div>');
                        }
                    });
                }
            });
        })

    </script>

@endsection
