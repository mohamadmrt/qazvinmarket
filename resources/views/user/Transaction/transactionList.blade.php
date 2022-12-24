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
                    <tr><td>نوع تراکنش</td><td>تاریخ</td><td>مبلغ (تومان)</td><td>وضعیت</td><td>شیوه پرداخت</td><td>شماره پیگیری</td></tr>
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



        $(document).ready(function () {
            _search = function (page) {
                let token=localStorage.getItem('token');
                $.ajax({
                    method: 'GET',
                    url: `/api/v1/total_transactions/?page=${page}`,
                    data: {token},
                    success:function (response) {
                        if(response.status==='ok'){
                            let transactions=response.transactions;
                            let paginate=response.paginate;
                            let data='';
                            let modal='';
                            $.each(transactions,function (key,item) {
                                data+=`<tr title="${item.status.label}" style="${item.status.id===4?'':'background-color:#ffdedb'}"><td>${item.type}</td>`;
                                data+=`<td>${item.date}</td>`;
                                data+=`<td>${item.price}</td>`;
                                data+=`<td>${item.status.label}</td>`;
                                data+=`<td>${item.bank}</td>`;
                                data+=`<td>${item.SaleReferenceId}</td>`;
                                data+=`</tr>`;
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
