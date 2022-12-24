@extends('ocms.master')
@push('style')
@endpush
@section('content')
    <!-- Modal -->
    <div class="modal fade" id="group" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: aqua;border-top-right-radius:5px;border-top-left-radius:5px; ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="groupModalTitle">درج گروه جدید</h4>
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
                                <label for="coupon_id">کد تخفیف :</label>
                                <div class="input-group">
                                    <select name="coupon_id" id="coupon_id" class="form-control">

                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="status">فعال:</label>
                                <div class="input-group">
                                    <input id="status" checked name="status" value="true"  type="checkbox" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-success" value="ذخیره"  name="admin_submit"  type="submit" id="saveGroup">
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
                            <input class="btn btn-danger" value="بله"  name="submit"  type="button" id="delGroup" size="40" >
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
                    <a class="groupModal btn btn-info btn-lg" data-id="0"  data-toggle="modal" data-target="#group" style="margin: 5px;">
                        <span class="glyphicon glyphicon-plus"></span>درج گروه جدید
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
                            <td nowrap="nowrap" style="text-align: center">عنوان گروه</td>
                            <td nowrap="nowrap" style="text-align: center">کد تخفیف</td>
                            <td style="text-align: center;width: 90px">وضعیت</td>
                            <td style="text-align: center;width: 90px">تاریخ ایجاد</td>
                            <td style="text-align: center">عملیات</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_id"></td>
                            <td><input class="search_filter" style="width: 100%" type="text"  id="search_by_title"></td>
                            <td><input class="search_filter" style="width: 100%" type="text"  id="search_by_code"></td>
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
        $(document).ready(function () {
            _get_coupons()
        })
        function _get_coupons(){
            $.ajax({
                url:"/ocms/get_copons_list",
                method:"GET",
                success:function (response) {
                    if (response.status==='ok'){
                        let coupons=response.coupons;
                        let data=`<option value="">انتخاب کنید</option>`
                        $.each(coupons,function (key,item) {
                            data+=`<option value="${item.id}">${item.title}</option>`;
                        })
                        $('#coupon_id').html(data)
                    }
                },
                error:function (response) {
                    alert(response.responseJSON.message)
                }
            })
        }
        $(document).on("submit", "#form", function (e) {
            e.preventDefault();
            let form = $(this).serialize();
            let id = $("#saveGroup").data('id');
            $('#error').html('');
            $.ajax({
                method: 'POST',
                url: `/ocms/group`,
                data:{id,form,'_token':"{{csrf_token()}}"},
                success:function (response) {
                    if (response.status==='ok'){
                        $("#form").trigger("reset");
                        swal({
                            type: 'success',
                            title: response.message
                        });
                        $('#group').modal('hide');
                        _search(1)
                    }
                },
                error:function (response) {
                    $('#error').html(response.responseJSON.message).show()
                }
            });
        });
        $(document).on("click", ".groupModal", function () {
            let id = $(this).data('id');
            $('#error').hide()
            $("#saveGroup").data('id',id)
            $("#groupModalTitle").text('درج گروه جدید')
            if (id!==0){
                $(this).parent().parent().css('background-color','aqua');
                let  url=`/ocms/group/${id}`;
                $.ajax({
                    method:"get",
                    url: url,
                    data: {id},
                    success:function (response) {
                        $("#groupModalTitle").text('ویرایش گروه: '+response.data.title)
                        $('#title').val(response.data.title)
                        $('#coupon_id').val(response.data.coupon_id)
                        $('#status').prop('checked',response.data.status === 'فعال')
                    }
                });
            }

            $('#error').html('');
            $('#group').modal('show');


        });
        $(document).on("click", ".dell_dialog", function () {
            let id = $(this).data('id');
            $('#del_id').val(id);
            $(this).parent().parent().css('background-color','violet')
            $('#dell_dialog').modal('show');
        })
        //when hidden
        $('#dell_dialog,#group').on('hidden.bs.modal', function(e) {
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
        $("#delGroup").click(function () {
            let id = $("#del_id").val();
            $.ajax({
                method: 'post',
                url: `/ocms/group/${id}`,
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
                error:function (response) {
                    $('#dell_dialog').modal('hide');
                    swal({
                        type: 'error',
                        title: response.responseJSON.message
                    });

                }
            });
        });

        _search = function () {
            $.ajax({
                method: 'GET',
                url: `/ocms/groupsList`,
                success:function (result) {
                    let groups=result.groups;
                    let data='';
                    $('#total').text(groups.length)
                    if (groups.length===0){
                        $('#recordsTable').html("");
                    }
                    else{
                        $.each(groups,function (key,item) {
                            data+=`<tr>`;
                            data+=`<td>${key+1}</td>`;
                            data+=`<td>${item.id}</td>`;
                            data+=`<td>${item.title}</td>`;
                            data+=`<td>${item.coupon}</td>`;
                            data+=`<td><div class="label ${item.status==='فعال'?'label-success':"label-danger"}">${item.status}</div></td>`;
                            data+=`<td>${item.created_at}</td>`;
                            data+=`<td>
                                    <button type="button" title="ویرایش" data-id="${item.id}" class="groupModal btn btn-block btn-info" data-toggle="modal" data-target="#groupsModal">
                                    <span class="fa fa-pencil"></span>
                                    </button>
                                    <button type="button" title="حذف" data-id="${item.id}" class="dell_dialog btn btn-block btn-danger" data-toggle="modal" data-target="#groupsModal">
                                    <span class="fa fa-trash"></span>
                                    </button>
                </td>`;
                            data+=`</tr>`;
                        })
                        $('#recordsTable').html(data);
                    }
                },
                error:function () {
                    $('#recordsTable').html(`<a class="btn btn-warning" onclick="_search()">تلاش مجدد<i class="fas fa-repeat"></i></a>`);
                }
            });

        };

        _search();
        $(document).on("keyup", ".search_filter", function () {
            _search();
        })
        $(document).on("click", ".paginate", function () {
            _search($(this).attr('page'));
        })
    </script>
@endsection
