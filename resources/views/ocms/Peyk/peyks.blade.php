@extends('ocms.master')

@section('content')
    <div class="modal fade" id="dell_dialog" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: violet;border-top-right-radius: 5px;border-top-left-radius: 5px">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel" style="color: white;">حذف منطقه</h4>
                </div>

                <div class="modal-body">
                    <div id="error_delete" class="row col-md-12 error-log"> </div><br>
                    <div class="form-group">
                        <div class="input-group">
                            <h4 id="text_cancel">
                                آیا می خواهید پیک حذف شود؟
                            </h4>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="btn btn-danger" value="بله"  name="submit"  type="button" id="delPeyk" size="40" >
                            <button type="button" class="btn btn-default" data-dismiss="modal">خروج</button><br><br>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="modal fade" id="peykModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #4EAEE0;border-top-right-radius: 5px;border-top-left-radius: 5px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal_title" style="color: white;">افزودن منطقه </h4>
                </div>
                <div class="modal-body">
                    <div id="error_data" class="row col-md-12 error_log"></div>
                    <div class="form-group">
                        <label for="zones">نام منطقه :</label>
                        <div class="input-group">
                            <input type="text" id="zones" name="zones"  style="width: 400px;" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price">هزینه پیک(تومان) :</label>
                        <div class="input-group">
                            <input type="text" id="price" name="price"  style="width: 400px;" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="shippingTime">زمان رسیدن(دقیقه) :</label>
                        <div class="input-group">
                            <input type="text" id="shippingTime" name="shippingTime"  style="width: 400px;" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="courier">نام و نام خانوادگی پیک:</label>
                        <div class="input-group">
                            <input type="text" id="courier" name="courier"  style="width: 400px;" class="form-control" value="" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="market_id">خارج از شهر :</label>
                        <select id="outOfCity" required name="outOfCity" class="form-control" style="width: 400px;">
                            <option value=""></option>
                            <option value="0">خیر</option>
                            <option value="1">بله</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="market_id">فروشگاه :</label>
                        <select id="market_id" name="market_id" class="form-control" style="width: 400px;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">فعال:</label>
                        <div class="input-group">
                            <input id="status" checked name="status" value="true"  type="checkbox" />
                        </div>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <input class="btn btn-success" value="ذخیره" data-id="0"  name="save"  type="submit" id="save">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div align="center">
            <div  style="height: 50px;padding-top: 10px;">
                <button type="button" class="addPeyk btn btn-info" data-id="0" id="addPeyk" style="margin-top: 10px;"><span class="fa fa-plus"></span>افزودن منطقه</button>
            </div>
            <br>
            <div class="panel panel-info panel-table radius2px">
                <div class="panel-heading" ><div>نتایج یافت شده: <span id="total"></span></div> </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead style="background-color: #969696;">
                        <tr >
                            <td nowrap="nowrap" style="text-align: center;width: 60px">شناسه</td>
                            <td nowrap="nowrap" style="text-align: center;width: 90px">نام فروشگاه</td>
                            <td nowrap="nowrap" style="text-align: center">عنوان مناطق</td>
                            <td nowrap="nowrap" style="text-align: center">نام پیک</td>
                            <td nowrap="nowrap" style="text-align: center;width: 100px">هزینه (تومان)</td>
                            <td nowrap="nowrap" style="text-align: center;width: 100px">خارج از شهر</td>
                            <td style="text-align: center">زمان رسیدن(دقیقه)</td>
                            <td style="text-align: center;width: 90px">وضعیت</td>
                            <td style="text-align: center;width: 90px">تاریخ ایجاد</td>
                            <td style="text-align: center">عملیات</td>
                        </tr>
                        <tr>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_id"></td>
                            <td><input class="search_filter" style="width: 100%" type="text"  id="search_by_market_name"></td>
                            <td><input class="search_filter" style="width: 100%" type="text"  id="search_by_zones"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_price"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_price"></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_discount_amount"></td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)" type="text" id="search_by_discount_type">
                                    <option value="">همه</option>
                                    <option value="percent">درصد</option>
                                    <option value="price">مبلغ</option>
                                </select>
                            </td>
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
                        <tbody id="records_table">
                        <tr>
                            <td colspan="8">در حال دریافت اطلاعات...</td>
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
        //when hidden
        $('#dell_dialog,#peykModal').on('hidden.bs.modal', function(e) {
            $('tr').css('background-color','');
            $('#zones').val('')
            $('#price').val('')
            $('#shippingTime').val('')
            $('#courier').val('')
            $('#outOfCity').val('')
            $('#market_id').val('')
            $('#save').data('id',"0")
            $('#error_data,#error_delete').html('');
        });
        $(document).ready(function () {
            $.ajax({
                method: 'GET',
                url: "/ocms/get_markets",
                success: function(data) {
                    if(data.status==='ok'){
                        let markets=``;
                        $.each(data.markets,function (key,index) {
                            markets+=`<option value="${index.id}">${index.name}</option>`
                        })
                        $('#market_id').html(markets)
                    }
                }
            });
            $(document).on("click", ".addPeyk", function () {
                $('#error_data').html('');
                let id=$(this).data('id');
                if (id===0){
                    $("#peykModal").modal('show');
                }else{
                    $(this).parent().parent().css('background-color','#4EAEE0')
                    $.ajax({
                        method: 'GET',
                        url: `/ocms/peyk/${id}`,
                        success: function(response) {
                            console.log(response)
                            if(response.status==='ok'){
                                let peyk=response.data;
                                $('#zones').val(peyk.zones)
                                $('#price').val(peyk.price)
                                $('#shippingTime').val(peyk.shippingTime)
                                $('#courier').val(peyk.courier)
                                $('#outOfCity').val(peyk.outOfCity)
                                $('#market_id').val(peyk.market_id)
                                $('#status').prop('checked',response.data.status === '1')
                                $('#save').data('id',id)

                                $('#peykModal').modal('show')
                            }
                        },
                        error:function (response) {
                            alert(response.responseJSON.message)
                        }
                    });
                }

            });

            $("#save").click(function () {
                if( $('#name').val() === '' ){
                    $('#error_data').show().text( 'فیلد های مورد نظر را تکمیل نمایید' );
                }
                else{
                    let zones=$('#zones').val();
                    let market_id=$("#market_id").val();
                    let price=$("#price").val();
                    let shippingTime=$("#shippingTime").val();
                    let courier =$("#courier").val();
                    let outOfCity=$("#outOfCity").val();
                    let id=  $('#save').data('id')
                    let status=  $('#status').prop('checked')
                    $.ajax({
                        method: 'POST',
                        url: "/ocms/peyk",
                        data: {zones,market_id,price,shippingTime,outOfCity,courier,id ,status,"_token": "{{ csrf_token() }}"},
                        success: function(data) {
                            if(data.status==='ok'){
                                swal({
                                    type: 'success',
                                    title: data.message
                                });
                                _search(1);
                                $('#peykModal').modal('hide');
                            }
                        },
                        error:function (response) {
                            swal({
                                type: 'error',
                                title: response.responseJSON.message
                            });
                        }
                    });
                }
            });

            $(document).on("click", ".dell_dialog", function () {
                $('#delPeyk').data('id',$(this).data('id'));
                $(this).parent().parent().css('background-color','violet')
                $('#dell_dialog').modal('show');
            });

            $("#delPeyk").click(function () {
                var id = $("#delPeyk").data('id');
                $.ajax({
                    method: 'DELETE',
                    url: "/ocms/peyk/"+ id,
                    data:{"_token":"{{csrf_token()}}"},
                    success: function(data) {
                        if(data.status==='ok'){
                            swal({
                                type: 'success',
                                title: data.message
                            });
                            _search(1);
                            $('#dell_dialog').modal('hide');
                        }
                        else{
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
                    method: 'GET',
                    url: `/ocms/peyk?page=${page}`,
                    data: {"_token": "{{ csrf_token() }}"}
                }).done(function (result) {
                    let peyks=result.peyks;
                    let paginate=result.paginate;
                    let data='';
                    $('#total').text(paginate.total)
                    if (peyks.length===0){
                        $('#recordsTable').html("");
                    }
                    else {
                        $.each(peyks,function (key,item) {
                            data+=`<tr>`;
                            data+=`<td>${item.id}</td>`;
                            data+=`<td>${item.market_name}</td>`;
                            data+=`<td>${item.zones}</td>`;
                            data+=`<td>${item.courier}</td>`;
                            data+=`<td>${formatPrice(item.price)}</td>`;
                            data+=`<td><div class="label ${item.outOfCity==='بله'?'label-success':'label-danger'}">${item.outOfCity}</div></td>`;
                            data+=`<td>${item.shippingTime}</td>`;
                            data+=`<td><div class="label ${item.status==='فعال'?'label-success':'label-danger'}">${item.status}</div></td>`;
                            data+=`<td>${item.created_at}</td>`;
                            data+=`<td>  <button type="button" title="ویرایش" data-id="${item.id}" class="addPeyk btn btn-block btn-info">
                                    <span class="fa fa-pencil"></span>
                                    </button>
                                    <button type="button" title="حذف" data-id="${item.id}" class="dell_dialog btn btn-block btn-danger" data-toggle="modal" data-target="#dell_dialog">
                                    <span class="fa fa-trash"></span>
                                    </button></td>`;

                        })
                        $('#records_table').html(data);

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
                });

            };
            _search(1);
            $(document).on("keyup", ".search_filter", function () {
                _search(1);
            })
            $(document).on("click", ".paginate", function () {
                _search($(this).attr('page'));
            })
        })
    </script>



@endsection
