@extends('ocms.master')
@section('content')
    {{--increase balance--}}
    <div class="modal fade" id="balancemodal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #4EAEE0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel" style="color: white;"> افزایش اعتبار </h4>
                </div>
                <div class="modal-body">
                    <div id="error_register" class="row col-md-12 error-log"></div>
                    <div id="success_register" class="row col-md-12 success-log"></div>
                    <br><br>
                    <div class="form-group">
                        <lable>متن پیام</lable>
                        <textarea name="textMessage" id="textMessage" rows="10" placeholder="متن پیام"
                                  style="width: 400px;" class="form-control">با سلام و با پوزش از اختلال بوجود آمده در سفارش اخیر و به جهت جبران آن، اعتبار کیف پول شما در سایت قزوین مارکت به مبلغ</textarea>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="balance" name="balance" style="width: 400px;" class="form-control"
                                   placeholder="مبلغ به تومان" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="textMessage2" id="textMessage2" rows="3" placeholder="متن پیام"
                                  style="width: 400px;" class="form-control">تومان افزایش یافت.&#13;&#10;"با تشکر از همراهی شما، مدیریت قزوین مارکت"</textarea>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="hidden" name="user_id" id="user_id" value="">
                            <input class="btn btn-primary" value="ذخیره" name="submit" type="button" id="submit"
                                   size="40"><br>
                            <div id="error_date" class="row col-md-12 error_log"></div>
                            <div id="success_date" class="row col-md-12 success_log"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--history increase balance--}}
    <div class="modal fade" id="historyIncreaseCredit" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background-color: #4EAEE0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel" style="color: white;"> تاریخچه افزایش اعتبار کاربر
                        (<span id="historyIncreaseCredit_modalTitle"></span>)-مانده اعتبار (<span
                            id="historyIncreaseCredit_modalTitle_balance"></span>)</h4>
                </div>
                <div class="modal-body">
                    <div id="historyIncreaseCredit_result"></div>
                </div>
            </div>
        </div>
    </div>
    {{--Block User--}}
    <div class="modal fade" id="blockUser" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background-color: #4EAEE0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel" style="color: white;">مسدود کردن کاربر</h4>
                </div>
                <div id="ErrorMessage">
                </div>
                <div class="modal-body">
                    <div id="error_register" class="row col-md-12 error-log"></div>
                    <div id="success_register" class="row col-md-12 success-log"></div>
                    <br><br>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="hidden" id="user_id_block"/>
                            <input type="text" id="mobile" name="mobile" style="width: 400px;" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input class="btn btn-primary" value="تغییر وضعیت" type="button" size="40"
                                   onclick="_block();"><br>
                            <div id="error_date" class="row col-md-12 error_log"></div>
                            <div id="success_date" class="row col-md-12 success_log"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div class="row">
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
            <button title="ترتیب بیشترین مبلغ خرید" type="button" class="btn" id="orderByButton" onclick="toggleOrderBy()">بر اساس بیشترین مبلغ خرید</button>
        </div>

        <div class="panel panel-info panel-table radius2px">
            <div class="panel-heading">
                <div style="text-align: center;">نتایج یافت شده: <span id="total_result"></span></div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="background-color: #969696;">
                    <tr>
                        <td nowrap="nowrap">
                            <div align="center">شناسه</div>
                        </td>
                        <td nowrap="nowrap">
                            <div align="center">نام کاربری</div>
                        </td>
                        <td nowrap="nowrap">
                            <div align="center">تعداد خرید (موفق)</div>
                        </td>
                        <td nowrap="nowrap">
                            <div align="center">نام کامل</div>
                        </td>
                        <td nowrap="nowrap">
                            <div align="center">جمع مبلغ</div>
                        </td>
                        <td nowrap="nowrap">
                            <div align="center">کیف پول(تومان)</div>
                        </td>
                        <td nowrap="nowrap">
                            <div align="center">امتیاز</div>
                        </td>
                        <td nowrap="nowrap">
                            <div align="center">عملیات</div>
                        </td>
                    </tr>
                    <tr>
                        <td><input class="search_filter" style="width: 100%" type="text" id="search_by_id"></td>
                        <td><input class="search_filter" style="width: 100%" type="text" id="search_by_username"></td>
                        <td><input class="search_filter" style="width: 100%" type="text" disabled></td>
                        <td><input class="search_filter" style="width: 100%" type="text" id="search_by_name"></td>
                        <td><input class="search_filter" style="width: 100%" type="text" id="search_by_group" disabled>
                        </td>
                        <td><input class="search_filter" style="width: 100%" disabled type="text"
                                   id="search_by_birthday"></td>
                        <td><input class="search_filter" style="width: 100%" type="text" id="search_by_wallet"></td>
                        <td><input class="search_filter" style="width: 100%" type="text" id="search_by_point"></td>
                    </tr>
                    </thead>
                    <tbody id="recordsTable">


                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <script type="text/javascript">

        var orderBy = 0;
      function toggleOrderBy(){
          if (orderBy == 0){
              $('#orderByButton').html('بر اساس بیشترین تعداد خرید');
              orderBy = 1;
              _search(1);
              
          }else {
              $('#orderByButton').html('بر اساس بیشترین مبلغ خرید');
              orderBy = 0;
              _search(1);
             
          }
      }
        insert_balance_dialog = function (id) {
            $('#error_date').hide();
            $('#success_date').hide();
            $('#balance').val('');
            $('#user_id').text(id);
            $('#balancemodal').modal('show');
        };
        $(document).on('keyup', '.search_filter', function () {
            _search(1)
        });

        history_balance_dialog = function (id) {
            $('#historyIncreaseCredit_result').html("");
            $('#historyIncreaseCredit_modalTitle').html("");
            $.ajax({
                type: "POST",
                url: "{{url('ocms/historyIncreaseCredit')}}",
                data: {id: id, "_token": "{{ csrf_token() }}"},
                success: function (data) {
                    if (data.status === 'ok') {
                        if (data.data.length > 0) {
                            let message = '<table class="table" dir="rtl"><th>شناسه</th><th>مبلغ(تومان)</th><th>تاریخ</th><th>شرح عملیات</th><th>بانک</th><th>وضعیت</th>';
                            $.each(data.data, function (key, index) {
                                message += `<tr>

<td>${index.id}</td>
<td>${formatPrice(index.deposit)}</td>
<td>${index.date}</td>
<td>${index.description}</td>
<td>${index.bank}</td>
<td>${index.status}</td>
</tr>`

                            })
                            message += '</table>'
                            $('#historyIncreaseCredit_result').html(message);
                        } else {
                            $('#historyIncreaseCredit_result').html("موردی یافت نشد");
                        }
                        $('#historyIncreaseCredit_modalTitle').html(data.username);
                        $('#historyIncreaseCredit_modalTitle_balance').html(data.balance);

                        $('#historyIncreaseCredit').modal('show');

                    }

                },
                error: function (result) {
                    alert('خطا')
                }
            });

        };

        $("#submit").click(function () {
            $('#error_date').hide();
            $('#success_date').hide();
            var balance = $("#balance").val();
            var id = $('#user_id').text();
            var textMessage = $('#textMessage').val();
            var textMessage2 = $('#textMessage2').val();
            if (balance == '')
                $('#error_date').show().text('فیلد های مورد نظر را تکمیل نمایید');
            else {
                $.ajax({
                    type: "POST",
                    url: "{{url('ocms/increaseCredit')}}",
                    data: {
                        balance: balance,
                        id: id,
                        message: textMessage,
                        message2: textMessage2,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.success) {
                            swal({
                                type: 'success',
                                title: data.message
                            });
                            $('#balancemodal').modal('hide');
                            _search();
                        } else {
                            $('#success_date').hide();
                            $('#error_date').show().text(data.message);
                        }
                    }
                });
            }
        });


        _search = function (page) {
            // orderBy = 0 => order by maximum count of transaction
            // orderBy = 1 => order by maximum of transactions amount
            let params = {};

            params.search_by_start_date = $('#search_by_start_date').val() ? $('#search_by_start_date').val() : '';
            params.search_by_end_date = $('#search_by_end_date').val() ? $('#search_by_end_date').val() : '';
            params.orderBy = orderBy;

            $.ajax({
                method: 'GET',
                url: `/ocms/user_most_purchased/?page=${page}`,
                data: {params: params},
                success: function (result) {
                    console.log(result)
                    // $("#total_result").text(result.paginate.total)
                    if (result.users.length < 1) {
                        $('#recordsTable').html('');
                    } else {
                        let users = result.users;
                        let paginate = result.paginate;
                        let data = '';
                        $.each(users, function (key, item) {
                            data += `<tr>`;
                            data += `<td>${item.id}</td>`;
                            data += `<td>${item.username}</td>`;
                            data += `<td>${item.order_count}</td>`;
                            data += `<td>${item.name}</td>`;
                            data += `<td>${formatPrice(item.sum_of_orders)}</td>`;
                            data += `<td>${formatPrice(item.wallet)}</td>`;
                            data += `<td>${formatPrice(item.point)}</td>`;
                            data += `<td><button title="افزایش اعتبار" type="button" class="btn btn-success" onclick="insert_balance_dialog(${item.id})"><i class="fa fa-plus-circle"></i></button>
                <button class="btn btn-info" type="button" title="تاریخچه افزایش اعتبار" onclick="history_balance_dialog(${item.id})"><i class="fas fa-history"></i></button>
                ${item.status !== '2' ? '<button class="btn btn-danger" type="button" title="مسدود کردن" onclick="block_dialog(' + item.id + ',' + item.username + ')"><i class="fas fa-user-slash"></i></button>' : '<a class="btn btn-success" title="آزاد کردن" onclick="block_dialog(' + item.id + ',' + item.username + ')"><i class="fas fa-user-plus"></i></a>'}
                </td>`;
                            data += `</tr>`;

                        })
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

        function block_dialog(user_id, mobile) {
            $('#user_id_block').val(user_id)
            $('#mobile').val(mobile)
            $('#blockUser').modal('show');
        }

        _block = function () {
            let user_id = $('#user_id_block').val();
            $.ajax({
                method: 'POST',
                url: `/ocms/block_user`,
                data: {user_id: user_id, _token: '{{csrf_token()}}'},
                success: function (result) {
                    console.log(result)
                    $('#blockUser').modal('hide');
                    _search(parseInt($('#page-number').val()))

                },
                error: function () {
                    $('#recordsTable').html(`<a class="btn btn-warning" onclick="_search(1)">تلاش مجدد<i class="fas fa-repeat"></i></a>`);
                }
            });

        }

        $(document).on("click", ".paginate", function () {
            _search($(this).attr('page'));
        })

    </script>



@endsection
