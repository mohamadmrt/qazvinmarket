@extends('user.master')
@push('style')
@endpush
@section('content')
    <div id="modals">
    </div>
    <div class="panel-body">
        <div class="row text-center">
        </div>
        <div class="panel panel-default panel-table radius2px">
            <div class="table-responsive">
                <table  class="table table-striped table-hover">
                    <thead>
                    <tr><td>شماره سفارش</td><td>تاریخ سفارش</td><td>مبلغ کل</td><td>وضعیت</td><td>جزئیات</td></tr>
                    </thead>
                    <tbody id="recordsTable"></tbody>
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
    <script>
        (function ($) {
            "use strict";
            function centerModal() {
                $(this).css('display', 'block');
                var $dialog  = $(this).find(".modal-dialog"),
                    offset       = ($(window).height() - $dialog.height()) / 2,
                    bottomMargin = parseInt($dialog.css('marginBottom'), 10);
                if(offset < bottomMargin) offset = bottomMargin;
                $dialog.css("margin-top", offset);
            }

            $('.modal').on('show.bs.modal', centerModal);
            $(window).on("resize", function () {
                $('.modal:visible').each(centerModal);
            });
        })(jQuery);


        function _comment(id){
            let comment=$("#comment"+id).val();
            if(comment.length<10){
                $('#error'+id).text('حداقل طول نظر باید 10 کاراکتر باشد')
            }else{
                $('error'+id).text('');
                let token=localStorage.getItem('token');
                $.ajax({
                    method: 'POST',
                    url: "/api/v1/comment",
                    data:{token,comment,id},
                    success:function (data) {
                        $('#'+id).modal('hide');
                        if (data.status==='ok'){
                            _search(1)
                            alert('نظر شما با موفقیت دریافت شد')
                        }else{
                            alert(data.massage)
                        }
                    },
                    error:function (response) {
                        if (response.status===401)
                            window.location.replace("/")
                    }
                });
            }


        }

        $(document).ready(function () {
            _search = function (page) {
                let token=localStorage.getItem('token');
                $.ajax({
                    method: 'GET',
                    url: `/api/v1/orderList/?page=${page}`,
                    data: {token},
                    success:function (response) {
                        if(response.status==='ok'){
                            let orders=response.order_list;
                            let paginate=response.paginate;
                            let data='';
                            let modal='';
                            $.each(orders,function (key,item) {
                                data+=`<tr title="${item.status.label}" style="${item.status.id===4?'':'background-color:#ffdedb'}"><td>${item.url}</td>`;
                                data+=`<td>${item.date}</td>`;
                                data+=`<td>${item.total}</td>`;
                                data+=`<td>${item.status.label}</td>`;
                                data+=`<td><a class="btn btn-info"  data-toggle="modal" data-target="#${item.id}">جزئیات</a></td>`;
                                data+=`</tr>`;
                                modal+=`<div id="${item.id}" class="modal fade" role="dialog">`;
                                modal+=`<div class="modal-dialog">`;
                                modal+=`<div class="modal-content">`;
                                modal+=`<div class="modal-header">`;
                                modal+=`<button type="button" class="close" data-dismiss="modal">&times;</button>`;
                                modal+=`<h4 class="modal-title">سفارش شماره ${item.id}</h4>`;
                                modal+=`</div>`;
                                modal+=`<div class="modal-body">`;
                                $.each(item.cargos,function (key,cargo) {
                                    modal+=`<div class="panel panel-default">`;
                                    modal+=`<div class="panel-body"><a href="/cargo/${cargo.id}">`
                                    modal+=`<div class="row">`
                                    modal+=`<div class="col-md-3">`
                                    modal+=`<img style="height:100px" src="${cargo.image}">`
                                    modal+=`</div>`
                                    modal+=`<div class="col-md-5">`
                                    modal+=`${cargo.name}<br>`
                                    modal+=`قیمت واحد: ${cargo.main_price}`
                                    modal+=`</div>`
                                    modal+=`<div class="col-md-2">`
                                    modal+=`<strong>${cargo.count} عدد</strong></div>`;
                                    modal+=`<div class="col-md-2">جمع: ${cargo.main_price*cargo.count}</div>`
                                    modal+=`</div>`
                                    modal+=`</a></div>`;
                                    modal+=`</div>`;
                                });
                                modal+=`<div class="panel panel-danger">`;
                                modal+=`<div class="panel-heading">روش ارسال: ${item.shipping_type==='express'?'فوری':'زمانبندی'}</div>`;
                                modal+=`<div class="panel-body">`;
                                modal+=`<p>آدرس ارسال: ${item.address}</p><br><p>هزینه ارسال: ${item.shipping_price}</p>`;
                                modal+=`</div>`;
                                modal+=`</div>`;
                                modal+=`<div class="panel panel-primary">`;
                                modal+=`<div class="panel-heading">نظر شما درباره این خرید</div>`;
                                modal+=`<div class="panel-body">`;
                                if (item.vote.status){
                                    modal+=`<div class="panel panel-warning">`;
                                    modal+=`<div class="panel-heading">نظر شما(${item.vote.vote_status.label})</div>`;
                                    modal+=`<div class="panel-body">`;
                                    modal+=`<p>${item.vote.message}</p>${item.vote.admin_reply?'<br><div class="panel panel-danger"><div class="panel-heading">'+'پاسخ مدیر:'+' '+item.vote.admin_reply+'</div></div>':''}`;
                                    modal+=`</div>`;
                                    modal+=`</div>`;
                                }else{
                                    modal+=`<div class="panel panel-warning">`;
                                    modal+=`<div class="panel-heading">نظر شما</div>`;
                                    modal+=`<div class="panel-body">`;
                                    modal+=`<p><a target="_blank" class="btn btn-success" href="${item.vote.message}">ثبت نظر</a>`;
                                    modal+=`</div>`;
                                    modal+=`</div>`;
                                }
                                modal+=`</div>`;
                                modal+=`</div>`;
                                modal+=`</div>`;
                                modal+=`</div>`;
                                modal+=`</div>`;
                                modal+=`</div>`;


                            })

                            $('#recordsTable').html(data);
                            $('#modals').html(modal);
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
                        }else if( response.status==='fail') {
                            swal({
                                type: 'error',
                                title: 'هیچ سفارشی یافت نشد'
                            })
                        }
                    },
                    error:function (response) {
                        if (response.status===401)
                            window.location.replace("/")
                    }
                });

            };
            _search(1);
        })
        $(document).on('hide.bs.modal',".modal", function(){
            $(".form-control").val('');
        });
    </script>
@endsection
