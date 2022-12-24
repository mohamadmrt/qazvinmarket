@extends('ocms.master')
@section('content')
    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div>
            <div class="panel panel-default panel-table radius2px" style="height: 100px; padding: 20px;">
                <div class="row" style="margin-top: 10px">
                    <div class="form-group col-md-2">
                        <div class="input-group">
                            <div class="input-group-addon" data-mddatetimepicker="true" data-targetselector="#search_by_from_date" data-trigger="click" >
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                            <input style="background-color: white;cursor: context-menu"   type="text" class="form-control" id="search_by_from_date" placeholder="از تاریخ" onchange="_search(1)" name="search_by_from_date"  />
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <div class="input-group ">
                            <div class="input-group-addon" data-mddatetimepicker="true" data-targetselector="#search_by_to_date" data-trigger="click" >
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                            <input  style="background-color: white;cursor: context-menu"   type="text" class="form-control" onchange="_search(1)" id="search_by_to_date" placeholder="تا تاریخ" name="search_by_to_date"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info panel-table radius2px">
                <div class="panel-heading">
                    <div style="text-align: center;">نتایج یافت شده:  <span id="total_result"></span></div>
                </div>
                <div class="table-responsive">
                    <table id="records_table"  class="table table-striped table-hover table-bordered">
                        <thead style="background-color: #969696;">
                        <tr>
                            <td nowrap="nowrap"><div align="center">شناسه</div></td>
                            <td nowrap="nowrap"><div align="center">نام کاربری</div></td>
                            <td nowrap="nowrap"><div align="center">نام و نام خانوادگی</div></td>
                            <td nowrap="nowrap"><div align="center">مبلغ (تومان)</div></td>
                            <td nowrap="nowrap"><div align="center">مانده (تومان)</div></td>
                            <td nowrap="nowrap"><div align="center">نوع عملیات</div></td>
                            <td nowrap="nowrap"><div align="center">تاریخ</div></td>
                            <td nowrap="nowrap"><div align="center">شرح عملیات</div></td>
                            <td nowrap="nowrap"><div align="center">توضیحات</div></td>
                            <td nowrap="nowrap"><div align="center">وضعیت</div></td>
                        </tr>
                        <tr>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_id"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_username"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_name"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_deposit"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_total_current"></td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)" type="text" id="search_by_type">
                                    <option value="">همه</option>
                                    <option value="1">واریز</option>
                                    <option value="0">برداشت</option>
                                </select>
                            </td>
                            <td></td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)" type="text" id="search_by_bank">
                                    <option value="">همه</option>
                                    <option value="0">مدیر</option>
                                    <option value="1">بانک ملت</option>
                                    <option value="2">روز تولد</option>
                                    <option value="4">افزایش اعتبار برای قاصدکی ها</option>
                                </select>
                            </td>
                            <td></td>
                            <td>
                                <select class="search_filter" style="width: 100%" onchange="_search(1)" type="text" id="search_by_status">
                                    <option value="">همه</option>
                                    <option value="4">موفق</option>
                                    <option value="0">ناموفق</option>
                                </select>
                            </td>
                        </tr>
                        </thead><tbody id="recordsTable">
                        <tr>
                            <td colspan="8">در حال دریافت اطلاعات...</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class=" " style="text-align:center; direction:rtl; margin-top:35px ;margin-bottom: 35px;">
                        <button id="first-page" class="btn paginate" style="float:none;margin: 1px"> << </button>
                        <button id="prev-page" class="btn paginate" style="float:none;margin: 1px"> < </button>
                        <button id="page-number" class="btn paginate btn-success" style="float:none;margin: 1px"></button>
                        <button id="next-page" class="btn paginate" style="float:none;margin: 1px"> > </button>
                        <button id="last-page" class="btn paginate" style="float:none;margin: 1px"> >> </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).on('keyup','.search_filter',function () {
            _search(1)
        });
        insert_balance_dialog  = function (id) {
            $('#error_date').hide();
            $('#success_date').hide();
            $('#balance').val('');
            $('#user_id').text(id);
            $('#balancemodal').modal('show');
        };
        _search = function (page_number) {
            let params={};
            params.search_by_from_date=$('#search_by_from_date').val()?$('#search_by_from_date').val():'';
            params.search_by_to_date = $('#search_by_to_date').val()?$('#search_by_to_date').val():'';
            params.search_by_id = $('#search_by_id').val()?$('#search_by_id').val():'';
            params.search_by_username = $('#search_by_username').val()?$('#search_by_username').val():'';
            params.search_by_name = $('#search_by_name').val()?$('#search_by_name').val():'';
            params.search_by_deposit = $('#search_by_deposit').val()?$('#search_by_deposit').val():'';
            params.search_by_total_current = $('#search_by_total_current').val()?$('#search_by_total_current').val():'';
            params.search_by_type = $('#search_by_type').val()?$('#search_by_type').val():'';
            params.search_by_bank = $('#search_by_bank').val()?$('#search_by_bank').val():'';
            params.search_by_status = $('#search_by_status').val()?$('#search_by_status').val():'';


            $.ajax({
                method: 'GET',
                url: `/ocms/walletsList/?page=${page_number}`,
                data: {params,"_token": "{{ csrf_token() }}"},
                success:function (result) {
                    $("#total_result").text(result.paginate.total)
                    if (result.data.length<1){
                            $('#recordsTable').html('');
                    }
                    else {
                        let data =''
                        let paginate=result.paginate;
                        $.each(result.data, function (key, item) {
                            data += `<tr>
<td>${item.id}</td>
<td>${item.username}</td>
<td>${item.fullname}</td>
<td>${formatPrice(item.deposit)}</td>
<td>${formatPrice(item.total_current)}</td>
<td><div class="label ${item.type==="واریز"?"label-success":"label-danger"}">${item.type}</div></td>
<td>${item.date}</td>
<td>${item.description}</td>
<td>${item.bank}</td>
<td><div class="label ${item.status==="موفق"?"label-success":""}${item.status==="ناموفق"?"label-danger":""}">${item.status}</div></td>
<tr>`
                        })
                        $('#recordsTable').html(data);
                        $('#page-number').text(paginate.current_page).attr('page',paginate.current_page)
                        $('#last-page').attr('page',paginate.last_page)
                        if (paginate.current_page===1)
                            $('#first-page, #prev-page').attr('disabled', 'disabled');
                        else
                        { $('#first-page, #prev-page').removeAttr('disabled');
                            $('#first-page').attr('page',1);
                            $('#prev-page').attr('page',paginate.current_page+1);}
                        $('#prev-page').attr('page',paginate.current_page-1);
                        if (paginate.current_page<paginate.last_page)
                        { $('#last-page, #next-page').removeAttr('disabled');
                            $('#last-page').attr('page',paginate.last_page);
                            $('#next-page').attr('page',paginate.current_page+1);
                        }
                        else {
                            $('#last-page, #next-page').attr('disabled', 'disabled');
                        }
                    }
                },
                error:function () {
                    $('#recordsTable').html(`<a class="btn btn-warning" onclick="_search(1)">تلاش مجدد<i class="fas fa-repeat"></i></a>`);
                }
            });
        };
        $('.paginate').click(function(){
            let page=parseInt($(this).attr('page'))
            _search(page);

        });
        _search(1);
    </script>



@endsection
