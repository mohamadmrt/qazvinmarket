@extends('ocms.master')
@section('content')
    <!-- Modal -->
    <div class="modal fade" id="amazing" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background-color: aqua;border-top-right-radius:5px;border-top-left-radius:5px; ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal_title">ایجاد پیشنهاد شگفت انگیز</h4>
                </div>
                <div class="modal-body" >
                    <div class="alert alert-danger" id="create_amazing_error" style="display: none"></div>
                    <div class="row">
                        <div class="form-group col-lg-12" >
                            <div class="input-group" >
                                <label for="cargo_menu">کالا را انتخاب کنید:</label>
                                <select class="form-control select2" style="width:400px" dir="rtl" name="cargo_menu" id="selected_cargo">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <label for="price_old">قیمت بدون تخفیف(تومان):</label>
                                <input type="text" id="price_old" name="price_old" class="form-control" placeholder="قیمت اصلی" value="" readonly/>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <label for="price" >قیمت با تخفیف(تومان):</label>
                                <input type="text" id="price" name="price"   class="form-control" placeholder="قیمت با تخفیف"  value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <label for="start_date" >تاریخ شروع:</label>
                                <input type="text" class="form-control"  data-mddatetimepicker="true"  data-enabletimepicker="true" id="start_date" placeholder="تاریخ شروع" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <label for="start_date" >تاریخ پایان:</label>
                                <input type="text" class="form-control"  data-mddatetimepicker="true" data-enabletimepicker="true"  id="end_date" autocomplete="off" placeholder="تاریخ پایان" value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-success" value="ذخیره"  name="submit"  type="submit" data-id="0" id="submit_amazing" size="40" >
                        <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="dell_dialog" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: violet;border-top-right-radius:5px;border-top-left-radius:5px; ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel" style="color: white;"> حذف پیشنهاد شگفت انگیز </h4>
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
                            <input type="hidden" name="state" id="state" value="">
                            <input class="btn btn-danger" value="بله"  name="submit"  type="button" id="del_amazing" size="40" >
                            <button type="button" class="btn btn-default" data-dismiss="modal">خروج</button><br><br>
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
                    <a title="ایجاد پیشنهاد شگفت انگیز" class="openFood btn btn-info btn-lg" data-id="0" data-check="0" data-toggle="modal" data-target="#amazing" style="margin: 5px;">
                        <span class="fas fa-plus-circle"></span>ایجاد پیشنهاد شگفت انگیز
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
                            <td nowrap="nowrap" style="text-align: center">شناسه</td>
                            <td nowrap="nowrap" style="text-align: center">نام سوپر مارکت</td>
                            <td nowrap="nowrap" style="text-align: center">نام کالا</td>
                            <td nowrap="nowrap" style="text-align: center">قیمت اصلی</td>
                            <td nowrap="nowrap" style="text-align: center">قیمت شگفت انگیز</td>
                            <td nowrap="nowrap" style="text-align: center">تعداد باقی مانده</td>
                            <td nowrap="nowrap" style="text-align: center">حداکثر تعداد سفارش</td>
                            <td nowrap="nowrap" style="text-align: center">وضعیت</td>
                            <td style="text-align: center">تاریخ شروع</td>
                            <td style="text-align: center">تاریخ پایان</td>
                            <td style="text-align: center">تاریخ ایجاد</td>
                            <td style="text-align: center">عملیات</td>
                        </tr>
                        <tr>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_id"></td>
                            <td>
                            </td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)" type="text" id="search_by_is_confirmed">
                                    <option value="">همه</option>
                                    <option value="1">تایید شده</option>
                                    <option value="0">تایید نشده</option>
                                </select>
                            </td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_created_date"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_resturant"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_user_name"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_user_tel"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_area"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_address"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_peyk_name"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_amount"></td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody id="recordsTable"  class="ui-sortable">
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
        $(document).on("click", "#submit_amazing", function () {
            let cargo= $("#selected_cargo").val();
            let price =$("#price").val()
            let start_date=$('#start_date').val()
            let end_date=$('#end_date').val()
            let id=$(this).data('id')
            $('#create_amazing_error').html('');
            $.ajax({
                method: 'POST',
                url:`/ocms/add_amazing/${cargo}` ,
                data:{price,start_date,end_date,id,'_token':"{{csrf_token()}}"},
                success:function (response) {
                    if (response.status==='ok'){
                        $("#selected_cargo").val('');
                        $("#price_old").val('')
                        $("#price").val('')
                        $('#start_date').val('')
                        $('#end_date').val('')
                        $('.select2').val([]).trigger('change');
                        $('#amazing').modal('hide')
                        swal({
                            type: 'success',
                            title: response.message
                        }).then((res)=>{
                            _search(1)
                        });
                    }
                },
                error:function (response) {
                    $('#create_amazing_error').html(response.responseJSON.message).show()

                }
            })
        });

        $(document).on("click", ".delete_modal", function () {
            let id = $(this).data('id');
            $(this).parent().parent().css('background-color','violet')
            $('#del_id').val(id);
            $('#dell_dialog').modal('show');
        });
        $(document).on("click", ".edit_amazing", function () {
            let id = $(this).data('id');
            $(".select2").empty().trigger('change');
            $(this).parent().parent().css('background-color','aqua')
            $.ajax({
                method: 'GET',
                url:`/ocms/amazing/${id}` ,
                success:function (response) {
                    let amazing=response.data;
                    $('.select2').select2({data:[{"id":amazing.cargo_id,"text":amazing.name}]}).trigger('change');
                    $('#submit_amazing').data('id',id);
                    $('#price_old').val(amazing.price)
                    $('#price').val(amazing.price_discount)
                    $('#start_date').val(amazing.start_at)
                    $('#end_date').val(amazing.end_at)
                    $('#modal_title').text("ویرایش پیشنهاد شگفت انگیز")
                    $('#amazing').modal('show');

                },
                error:function (response) {
                    $('#create_amazing_error').text(response.responseJSON.message).show()

                }
            })

        });
        //when hidden
        $('#dell_dialog,#amazing').on('hidden.bs.modal', function(e) {
            $('tr').css('background-color','');
            $('#error').hide()
            $('#price_old').val('')
            $('#price').val('')
            $('#start_date').val('')
            $('#end_date').val('')
            $('#submit_amazing').data('id',0);
            $('#modal_title').text("ایجاد پیشنهاد شگفت انگیز")
            $('#create_amazing_error').hide()
            $(".select2").empty().trigger('change');
            select()
        });
        $("#del_amazing").click(function () {
            let id = $("#del_id").val();
            $.ajax({
                method: 'get',
                url:`/ocms/delete_amazing/${id}` ,
                success: function(data) {
                    if (data.status==='ok') {
                        $('#dell_dialog').modal('hide');
                        swal({
                            type: 'success',
                            title: data.message
                        }).then((res)=>{
                            _search(1);

                        });
                    }
                    else {
                        swal({
                            type: 'error',
                            title: data.message
                        });
                        $('#dell_dialog').modal('hide');
                    }
                }

            });
        });
        _search = function (page) {
            $.ajax({
                method: 'POST',
                url: `/ocms/amazing_list?page=${page}`,
                data: { "_token": "{{ csrf_token() }}"},
                success:function (result) {
                    let amazings=result.data;
                    let paginate=result.paginate;
                    let data='';
                    if (amazings.length<1){
                        $('#recordsTable').html("");
                    }else{
                        $.each(amazings,function (key,item) {
                            data+=`<tr class="ui-state-default" id="${item.id}"  data="row-${item.id}" style="background-color: ${item.status<2?'#FFD9B3':''} ${item.valid===0?'#fab7be':''};" title="${item.valid===0?'نامعتبر':''}" >`;
                            data+=`<td>${item.id}</td>`;
                            data+=`<td>${item.market_name}</td>`;
                            data+=`<td><img class="img-thumbnail" src="${item.image}" style="height:100px" alt="">${item.name}</td>`;
                            data+=`<td>${formatPrice(item.price)}</td>`;
                            data+=`<td>${formatPrice(item.price_discount)}</td>`;
                            data+=`<td>${item.max_count}</td>`;
                            data+=`<td>${item.max_order}</td>`;
                            data+=`<td>${item.status==='0'?"غیر فعال":"فعال"}</td>`;
                            data+=`<td>${item.start_at}`;
                            data+=`<td>${item.end_at}`;
                            data+=`<td>${item.created_at}`;
                            data+=`<td>
                                    <button type="button" title=" ویرایش" data-id="${item.id}" class="btn btn-block btn-info edit_amazing" data-toggle="modal">
                                    <span class="fa fa-pencil"></span>
                                    </button>
                                    <button title="حذف" type="button" data-id=${item.id} class="btn btn-block delete_modal btn-danger"><span class="fas fa-trash-alt"></span></button></td>`;
                            data+=`</tr>`;


                        })
                        $('#recordsTable').html(data);
                        $('#total').html(paginate.total);
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

                }
            })
        };
        _search(1);
        function select(){
            $('#selected_cargo').val(null).trigger('change');
            $( ".select2" ).select2({
                ajax: {
                    url: function (params) {
                        return '/api/v1/search?q='+  $("#selected_cargo").val();
                    },
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: $.map(data.cargos, function (cargo) {
                                return {
                                    text: cargo.name+" - "+cargo.id,
                                    id: cargo.id
                                }
                            }),
                        };
                    }
                },
                placeholder: "انتخاب",
                maximumSelectionSize: 6,
            });
        }
        select()
        $('.select2').on('select2:select', function (e) {
            let cargo_id = e.params.data.id;
            $.ajax({
                method: 'GET',
                url: `/api/v1/cargo/${cargo_id}`,
            }).done(function (result) {
                $('#price_old').val(result.main_price)
                $('#selected_cargo').val(result.data.id)
            })

        });
        $(document).on("keyup", ".search_filter", function () {
            _search(1);
        })
        $(document).on("click", ".paginate", function () {
            _search($(this).attr('page'));
        })
        $( " #recordsTable" ).sortable({
            cursor: "move",
            tolerance: "pointer",
            opacity: 0.7,
            revert: 0,
            delay: 150,
            update: function () {
                let amazings=$('#recordsTable').sortable('toArray')

                // let sub_menus=$(this).sortable('toArray')
                $.ajax({
                    type: "POST",
                    url: `/ocms/sort_amazings`,
                    data:{amazings,"_token":"{{csrf_token()}}"},
                    success: function (response) {
                        console.log(response)
                    },
                    error:function () {
                        alert('مشکلی در ارتباط با سرور وجود دارد. لطفاً با پشتیبانی تماس بگیرید')
                    }
                });
            },
            appendTo: document.body
        })
    </script>
@endsection
