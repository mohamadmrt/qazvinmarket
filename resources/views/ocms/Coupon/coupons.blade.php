@extends('ocms.master')
@push('style')
@endpush
@section('content')
    <!-- Modal -->
    <div class="modal fade" id="coupon" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: aqua;border-top-right-radius:5px;border-top-left-radius:5px; ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="couponModalTitle">درج کد تخفیف جدید</h4>
                </div>
                <form role="form" id="form">
                    <div class="modal-body">
                        <div class=" row">
                            <div class="alert alert-danger" id="error" style="display: none"></div>
                            <div class="form-group col-md-6">
                                <label for="title">عنوان :</label>
                                <div class="input-group">
                                    <input id="title" name="title" class="form-control" type="text" placeholder="عنوان" value="">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="title">کد تخفیف :</label>
                                <div class="input-group">
                                    <input id="code" name="code"  class="form-control" type="text" placeholder="کد تخفیف" value="">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="min_price">حداقل خرید (تومان) :</label>
                                <div class="input-group">
                                    <input id="min_price" name="min_price" class="form-control" type="text" placeholder="حداقل خرید" value="">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="discount_amount">مبلغ/درصد تخفیف (تومان / درصد):</label>
                                <div class="input-group">
                                    <input id="discount_amount" name="discount_amount" class="form-control" type="text" placeholder="مبلغ/درصد تخفیف" value="">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="discount_type">نوع تخفیف :</label>
                                <div class="input-group">
                                    <select class="form-control" id="discount_type" name="discount_type">
                                        <option value="price">مبلغ</option>
                                        <option value="percent">درصد</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="max_count">حداکثر تعداد استفاده:</label>
                                <div class="input-group">
                                    <input id="max_count" name="max_count" class="form-control" type="text" placeholder="حداکثر تعداد استفاده" value="">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="max_discount">حداکثر مبلغ تخفیف(تومان):</label>
                                <div class="input-group">
                                    <input id="max_discount" name="max_discount" class="form-control" type="text" placeholder="حداکثر مبلغ تخفیف" value="">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status">فعال:</label>
                                <div class="input-group">
                                    <input id="status" checked name="status" value="true"  type="checkbox" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="start_date">تاریخ شروع:</label>
                                <div class="input-group">
                                    <input id="start_date" name="start_date" autocomplete="off" data-mddatetimepicker="true" class="form-control" type="text" placeholder="تاریخ شروع" value=""  data-enabletimepicker="true">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="end_date">تاریخ پایان:</label>
                                <div class="input-group">
                                    <input id="end_date" name="end_date" autocomplete="off" data-mddatetimepicker="true" class="form-control" type="text" placeholder="تاریخ پایان" data-enabletimepicker="true" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-success" value="ذخیره"  name="admin_submit"  type="submit" id="saveCoupon">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="dell_dialog" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: violet;border-top-right-radius:5px;border-top-left-radius:5px; ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel" style="color: white;"> حذف فیلد</h4>
                </div>
                <div class="modal-body">
                    <div id="error_register" class="row col-md-12 error-log"> </div>
                    <div id="success_register" class="row col-md-12 success-log"> </div>
                    <br>
                    <div class="form-group">
                        <div class="input-group">
                            <h4 id="text_cancel">
                                آیا می خواهید فیلد حذف شود؟
                            </h4>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="hidden" name="del_id" id="del_id" value="">
                            <input type="hidden" name="del_city_id" id="del_city_id" value="">
                            <input type="hidden" name="state" id="state" value="">
                            <input class="btn btn-danger" value="بله"  name="submit"  type="button" id="delCoupon" size="40" >
                            <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div align="center">
            <div class="panel panel-default panel-table radius2px">
                <div  style="height: 50px;padding-top: 10px;display: inline;
    margin: 6px;">
                    <a class="couponModal btn btn-info btn-lg" data-id="0"  data-toggle="modal" data-target="#coupon" style="margin: 5px;">
                        <span class="glyphicon glyphicon-plus"></span>درج کد تخفیف جدید
                    </a>
                </div>
                <br>
            </div>
            <div class="panel panel-info panel-table radius2px">
                <div class="panel-heading" ><div>نتایج یافت شده: <span id="total"></span></div> </div>
                <div class="table-responsive">
                    <table  class="table table-bordered table-hover">
                        <thead style="background-color: #969696;">
                        <tr >
                            <td nowrap="nowrap" style="text-align: center">ردیف</td>
                            <td nowrap="nowrap" style="text-align: center">شناسه</td>
                            <td nowrap="nowrap" style="text-align: center">عنوان</td>
                            <td nowrap="nowrap" style="text-align: center">کد تخفیف</td>
                            <td nowrap="nowrap" style="text-align: center">حداقل خرید</td>
                            <td nowrap="nowrap" style="text-align: center">مبلغ/درصد تخفیف</td>
                            <td nowrap="nowrap" style="text-align: center">نوع تخفیف</td>
                            <td style="text-align: center">حداکثر تعداد استفاده</td>
                            <td style="text-align: center">تعداد استفاده شده</td>
                            <td style="text-align: center">حداکثر مبلغ تخفیف</td>
                            <td nowrap="nowrap" style="text-align: center">تاریخ شروع</td>
                            <td style="text-align: center;width: 90px">تاریخ پایان</td>
                            <td style="text-align: center;width: 90px">وضعیت</td>
                            <td style="text-align: center;width: 90px">تاریخ ایجاد</td>
                            <td style="text-align: center">عملیات</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_id"></td>
                            <td><input class="search_filter" style="width: 100%" type="text"  id="search_by_title"></td>
                            <td><input class="search_filter" style="width: 100%" type="text"  id="search_by_code"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_min_price"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_discount_amount"></td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)" type="text" id="search_by_discount_type">
                                    <option value="">همه</option>
                                    <option value="percent">درصد</option>
                                    <option value="price">مبلغ</option>
                                </select>
                            </td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_max_count"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_used_count"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_max_discount"></td>
                            <td><input class="search_filter" style="width: 100%" onchange="_search(1)" type="text" data-mddatetimepicker="true" name="search_by_start_at" id="search_by_start_at"></td>
                            <td><input class="search_filter" style="width: 100%" onchange="_search(1)" type="text" data-mddatetimepicker="true" name="search_by_end_at" id="search_by_end_at"></td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)" type="text" id="search_by_status">
                                    <option value="">همه</option>
                                    <option value="1">فعال</option>
                                    <option value="0">غیر فعال</option>
                                </select>
                            </td>
                            <td><input class="search_filter" style="width: 100%" onchange="_search(1)" type="text" data-mddatetimepicker="true" id="search_by_created_at" name="search_by_created_at"></td>
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
                        <button id="first-page" class="btn paginate" style="float:none;margin: 1px"> << </button>
                        <button id="prev-page" class="btn paginate" style="float:none;margin: 1px"> < </button>
                        <button id="page-number" class="btn btn-success" style="float:none;margin: 1px"> 1 </button>
                        <button id="next-page" class="btn paginate" style="float:none;margin: 1px"> > </button>
                        <button id="last-page" class="btn paginate" style="float:none;margin: 1px"> >> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).on("submit", "#form", function (e) {
            e.preventDefault();
            let form = $(this).serialize();
            let id = $("#saveCoupon").data('id');
            $('#error').html('');
            $.ajax({
                method: 'POST',
                url: `/ocms/coupon`,
                data:{id,form,'_token':"{{csrf_token()}}"},
                success:function (response) {
                    if (response.status==='ok'){
                        $("#form").trigger("reset");
                        swal({
                            type: 'success',
                            title: response.message
                        });
                        $('#coupon').modal('hide');
                        _search(1)
                    }
                },
                error:function (response) {
                    $('#error').html(response.responseJSON.message).show()
                }
            });
        });
        $(document).on("click", ".couponModal", function () {
            let id = $(this).data('id');
            $('#error').hide()
            $("#saveCoupon").data('id',id)
            $("#couponModalTitle").text('درج کد تخفیف')
            if (id!==0){
                $(this).parent().parent().css('background-color','aqua');
                let  url=`/ocms/coupon/${id}`;
                $.ajax({
                    method:"get",
                    url: url,
                    data: {id},
                    success:function (response) {
                        $("#couponModalTitle").text('ویرایش کد تخفیف: '+response.data.title)
                        $('#title').val(response.data.title)
                        $('#code').val(response.data.code)
                        $('#min_price').val(response.data.min_price)
                        $('#discount_amount').val(response.data.discount_amount)
                        $('#discount_type').val(response.data.discount_type==='درصد'?"percent":'price')
                        $('#max_count').val(response.data.max_count)
                        $('#max_discount').val(response.data.max_discount)
                        $('#status').prop('checked',response.data.status === 'فعال')
                        $('#end_date').val(response.data.end_date)
                        $('#start_date').val(response.data.start_date)
                    }
                });
            }

            $('#error').html('');
            $('#coupon').modal('show');


        });
        $(document).on("click", ".dell_dialog", function () {
            let id = $(this).data('id');
            $('#del_id').val(id);
            $(this).parent().parent().css('background-color','violet')
            $('#dell_dialog').modal('show');
        })
        //when hidden
        $('#dell_dialog,#coupon').on('hidden.bs.modal', function(e) {
            $('tr').css('background-color','');
           $('#title').val('')
           $('#code').val('')
           $('#min_price').val('')
           $('#discount_amount').val('')
           $('#discount_type').val('')
           $('#max_count').val('')
           $('#max_discount').val('')
           $('#start_date').val('')
           $('#end_date').val('')
           $('#status').prop('checked',true)
            $('#error').hide()
        });
        $("#delCoupon").click(function () {
            let id = $("#del_id").val();
            $.ajax({
                method: 'post',
                url: `/ocms/coupon/${id}`,
                data:{"_token":"{{csrf_token()}}","_method":"DELETE"},
                success: function(data) {
                    if (data.status==='ok') {
                        swal({
                            type: 'error',
                            title: data.message
                        });
                        _search(1);
                        $('#dell_dialog').modal('hide');
                    }
                    else {
                        swal({
                            type: 'error',
                            title: data.message
                        });
                        $('#dell_dialog').modal('hide');
                    }
                },
                error:function () {
                    alert('خطا در عملیات!')
                }
            });
        });

        _search = function (page) {
            let params={};
            params.search_by_id = $('#search_by_id').val()?$('#search_by_id').val():'';
            params.search_by_title = $('#search_by_title').val()?$('#search_by_title').val():'';
            params.search_by_code = $('#search_by_code').val()?$('#search_by_code').val():'';
            params.search_by_min_price = $('#search_by_min_price').val()?$('#search_by_min_price').val():'';
            params.search_by_discount_amount = $('#search_by_discount_amount').val()?$('#search_by_discount_amount').val():'';
            params.search_by_discount_type = $('#search_by_discount_type').val()?$('#search_by_discount_type').val():'';
            params.search_by_max_count = $('#search_by_max_count').val()?$('#search_by_max_count').val():'';
            params.search_by_used_count = $('#search_by_used_count').val()?$('#search_by_used_count').val():'';
            params.search_by_max_discount = $('#search_by_max_discount').val()?$('#search_by_max_discount').val():'';
            params.search_by_start_at=$('#search_by_start_at').val()?$('#search_by_start_at').val():'';
            params.search_by_end_at = $('#search_by_end_at').val()?$('#search_by_end_at').val():'';
            params.search_by_status = $('#search_by_status').val()?$('#search_by_status').val():'';
            params.search_by_created_at = $('#search_by_created_at').val()?$('#search_by_created_at').val():'';
            $.ajax({
                method: 'GET',
                url: `/ocms/couponsList/?page=${page}`,
                data: {params:params},
                success:function (result) {
                    let coupons=result.coupons;
                    let paginate=result.paginate;
                    let data='';
                    $('#total').text(paginate.total)
                    if (coupons.length===0){
                        $('#recordsTable').html("");
                    }
                    else{
                        $.each(coupons,function (key,item) {
                            data+=`<tr>`;
                            data+=`<td>${key+1}</td>`;
                            data+=`<td>${item.id}</td>`;
                            data+=`<td>${item.title}</td>`;
                            data+=`<td>${item.code}</td>`;
                            data+=`<td>${formatPrice(item.min_price)}</td>`;
                            data+=`<td>${item.discount_amount}</td>`;
                            data+=`<td>${item.discount_type}</td>`;
                            data+=`<td>${item.max_count}</td>`;
                            data+=`<td>${item.used_count}</td>`;
                            data+=`<td>${formatPrice(item.max_discount)}</td>`;
                            data+=`<td>${item.start_date}</td>`;
                            data+=`<td>${item.end_date}</td>`;
                            data+=`<td><div class="label ${item.status==='فعال'?'label-success':"label-danger"}">${item.status}</div></td>`;
                            data+=`<td>${item.created_at}</td>`;
                            data+=`<td>
                                    <button type="button" title="ویرایش" data-id="${item.id}" class="couponModal btn btn-block btn-info" data-toggle="modal" data-target="#couponsModal">
                                    <span class="fa fa-pencil"></span>
                                    </button>
                                    <button type="button" title="حذف" data-id="${item.id}" class="dell_dialog btn btn-block btn-danger" data-toggle="modal" data-target="#couponsModal">
                                    <span class="fa fa-trash"></span>
                                    </button>
                </td>`;
                            data+=`</tr>`;
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

        _search(1);
        $(document).on("keyup", ".search_filter", function () {
            _search(1);
        })
        $(document).on("click", ".paginate", function () {
            _search($(this).attr('page'));
        })
    </script>
@endsection
