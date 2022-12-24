@extends('ocms.master')

@section('content')

    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div align="center">
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
                <div class="form-group col-md-4 right-align text-right">
                    <div class="input-group ">
                       <p>تعداد سفارش های موفق: <span id="reports_all_result_success_count"></span></p>
                       <p>جمع سفارش های موفق: <span id="reports_all_result_success_sum"></span></p>
                    </div>
                </div>
            </div>

            <div class="d" style="height: 10px;"></div>

            <div class="panel panel-default panel-table radius2px">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr style="background-color:#069; color:#FFF;">
                            <td>
                                <div align="center"><strong>تاریخ</strong></div>
                            </td>
                            <td>
                                <div align="center"><strong>تعداد</strong></div>
                            </td>
                            <td>
                                <div align="center"><strong>آنلاین</strong></div>
                            </td>
                            <td>
                                <div align="center"><strong>نقدی</strong></div>
                            </td>
                            <td>
                                <div align="center"><strong>کیف پول</strong></div>
                            </td>

                            <td>
                                <div align="center"><strong>مبلغ(تومان)</strong></div>
                            </td>
                        </tr>
                        </thead>
                        <tbody id="records_table">
                        </tbody>
                    </table>
{{--                    <div class=" " style="text-align:center; direction:rtl; margin-top:35px ;margin-bottom: 35px;">--}}
{{--                        <button id="first-page" class="btn" style="float:none;margin: 1px"> <<</button>--}}
{{--                        <button id="prev-page" class="btn" style="float:none;margin: 1px"> <</button>--}}
{{--                        <button id="page-number" class="btn btn-success" style="float:none;margin: 1px"> 1</button>--}}
{{--                        <button id="next-page" clas s="btn" style="float:none;margin: 1px"> ></button>--}}
{{--                        <button id="last-page" class="btn" style="float:none;margin: 1px"> >></button>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        _search = function (page) {
            let params = {};
            params.search_by_start_date = $('#search_by_start_date').val() ? $('#search_by_start_date').val() : '';
            params.search_by_end_date = $('#search_by_end_date').val() ? $('#search_by_end_date').val() : '';

            $.ajax({
                method: 'GET',
                url: `/ocms/reportList?page=${page}`,
                data: {"_token": "{{ csrf_token() }}", params},
                success: function (result) {
                    console.log(result);
                    // let paginate = result.paginate;
                    let reports = result.reports;
                    let data = '';
                    $('#reports_all_result_success_count').text(result.reports_result[0].tedad)
                    $('#reports_all_result_success_sum').text(formatPrice(result.reports_result[0].sum))
                    // $("#total_result").text(result.paginate.total)
                    // $('#total').text(paginate.total)
                    if (reports.length < 1) {
                        $('#recordsTable').html('');
                    } else {
                        $.each(reports, function (key, report) {
                            data += `<tr>`;
                            data += `<td>${report.created_at}</td>`;
                            data += `<td>${report.tedad}</td>`;
                            data += `<td>${report.online_orders}</td>`;
                            data += `<td>${report.cash_orders}</td>`;
                            data += `<td>${report.wallet_orders}</td>`;
                            data += `<td>${formatPrice(report.sum)}</td>`;
                            data += `</tr>`;
                        })
                        $('#records_table').html(data);
                        // $('#page-number').text(paginate.current_page).attr('page', paginate.current_page)
                        // $('#last-page').attr('page', paginate.last_page)
                        // if (paginate.current_page === 1)
                        //     $('#first-page, #prev-page').attr('disabled', 'disabled');
                        // else {
                        //     $('#first-page, #prev-page').removeAttr('disabled');
                        //     $('#first-page').attr('page', 1);
                        //     $('#prev-page').attr('page', paginate.current_page + 1);
                        // }
                        // $('#prev-page').attr('page', paginate.current_page - 1);
                        // if (paginate.current_page < paginate.last_page) {
                        //     $('#last-page, #next-page').removeAttr('disabled');
                        //     $('#last-page').attr('page', paginate.last_page);
                        //     $('#next-page').attr('page', paginate.current_page + 1);
                        // } else {
                        //     $('#last-page, #next-page').attr('disabled', 'disabled');
                        // }
                    }
                },
                error: function () {
                }
            })
        };
        _search(1);

    </script>

@endsection
