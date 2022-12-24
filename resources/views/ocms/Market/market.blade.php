@extends('ocms.master')

@section('content')
    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div >

                <div  style="height: 50px;padding-top: 10px;">
                    <a title="افزودن سوپرمارکت جدید" href="{{route('markets.create')}}" class="btn btn-info btn-lg">
                        <span class="fas fa-plus-circle"></span>   افزودن سوپرمارکت
                    </a>
                </div>
                <br>
                <br>

        </div>
    </div>
<div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
    <div align="center">
<div class="panel panel-default panel-table radius2px">
    <div class="table-responsive">
        <table  class="table table-bordered table-hover">
            <thead style="background-color: #969696;">
            <tr >
                <td nowrap="nowrap"><div align="center">شناسه سوپرمارکت</div></td>
                <td nowrap="nowrap"><div align="center">نام سوپرمارکت</div></td>
                <td nowrap="nowrap"><div align="center">تلفن</div></td>
                <td nowrap="nowrap"><div width='30%' align="center">شماره همراه</div></td>
                <td nowrap="nowrap"><div align="center">آدرس</div></td>
                <td><div align="center">عملیات</div></td>

            </tr>
            <tr>
                <td><input class="search_filter" style="width: 100%" type="text" id="search_by_created_date"></td>
                <td><input class="search_filter" style="width: 100%" type="text" id="search_by_resturant"></td>
                <td><input class="search_filter" style="width: 100%" type="text" id="search_by_user_name"></td>
                <td><input class="search_filter" style="width: 100%" type="text" id="search_by_user_tel"></td>
                <td><input class="search_filter" style="width: 100%" type="text" id="search_by_area"></td>
                <td><input class="search_filter" style="width: 100%" type="text" id="search_by_address"></td>

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
        $(document).on("keyup", ".search_filter", function () {
            _search(1);
        })
        _search = function (page) {
            let orderType=$('#orderType').val();
            let params={};
            params.search_by_end_date = $('#search_by_end_date').val()?$('#search_by_end_date').val():'';
            params.search_by_name = $('#search_by_name').val()?$('#search_by_name').val():'';
            params.search_by_is_lated = $('#search_by_is_lated').val()?$('#search_by_is_lated').val():'';
            params.search_by_bank = $('#search_by_bank').val()?$('#search_by_bank').val():'';
            params.search_by_porder_date = $('#search_by_porder_date').val()?$('#search_by_porder_date').val():'';
            params.search_by_porder = $('#search_by_porder').val()?$('#search_by_porder').val():'';
            params.search_by_id = $('#search_by_id').val()?$('#search_by_id').val():' ';
            params.search_by_user_name = $('#search_by_user_name').val()?$('#search_by_user_name').val():'';
            params.search_by_area = $('#search_by_area').val()?$('#search_by_area').val():'';
            params.search_by_user_tel = $('#search_by_user_tel').val()?$('#search_by_user_tel').val():'';
            params.search_by_address = $('#search_by_address').val()?$('#search_by_address').val():'';
            params.search_by_peyk_name = $('#search_by_peyk_name').val()?$('#search_by_peyk_name').val():'';
            params.search_by_amount = $('#search_by_amount').val()?$('#search_by_amount').val():'';

            $.ajax({
                method: 'GET',
                url: `/ocms/marketList/?page=${page}&s=${orderType}`,
                data: {params:params},
                success:function (result) {
                    if (result === 'null'){
                        swal({
                            type: 'error',
                            title: 'هیچ فروشگاهی یافت نشد'
                        })
                    }
                    else{
                        let orders=result.data.data;
                        let paginate=result.data;
                        let data='';
                        $.each(orders,function (key,item) {
                            data+=`<tr style="background-color: ${item.status==='0'?'#ee7d72':''}" title="${item.status==="0"?'خوانده نشده':''}" >`;
                            data+=`<td>${item.id}</td>`;
                            data+=`<td>${item.name}</td>`;
                            data+=`<td>${item.tel}</td>`;
                            data+=`<td>${item.mobile}</td>`;
                            data+=`<td>${item.address}</td>`;
                            data+=`<td>
                                    ${item.service==='1'?'<button title="غیر فعال کردن فروشگاه" type="button" class="btn btn-danger btn-block" onclick="_status('+item.id+')"><span class="fas fa-lock"></span></button>':'<button title="فعال کردن فروشگاه" type="button" class="btn btn-primary btn-block" onclick="_status('+item.id+')"><span class="fas fa-lock-open"></span></button>'}
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
        _status=function(id){
                    $.ajax({
                        type: "POST",
                        url: "/ocms/active_market",
                        data:{id:id,_token:'{{csrf_token()}}'},
                        success: function (data) {
                            if(data.status==='ok'){
                                swal({
                                    title: 'پیغام سیستم!',
                                    text: 'عملیات موفق',
                                    type: 'success',
                                    confirmButtonText: 'باشه'
                                }).then((result) => {_search($('#page-number'))});
                            }
                            else{
                                swal({
                                    title: 'پیغام سیستم!',
                                    text: 'خطایی رخ داد!',
                                    type: 'error',
                                    confirmButtonText: 'باشه'
                                })
                            }
                        }
                    });
        }
    </script>



@endsection
