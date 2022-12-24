@extends('user.master')
@section('content')
    @push('style')
        <style>
            ._dbd-ls .list-group-item {
                border: 0;
                border-top-width: 0px;
                border-top-style: none;
                border-top-color: currentcolor;
                border-top: 1px solid #ddd;
            }
            a.list-group-item {
                color: #337AB7;
                font-size: 13px;
                font-weight: 800;
            }
            i.a.list-group-item{
                padding-left: 5px;
                margin-left: 5px;
            }
            .list-group-item {
                position: relative;
                display: block;
                padding: 2px 15px;
                margin-bottom: -1px;
                background-color: #fff;
                border: 1px solid #ddd;
            }
            .list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
                color: #fff;
            }
            .list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
                border-top: 0;
                border-top-color: currentcolor;
                border-color: #0275d8;
                border-top-color: rgb(2, 117, 216);
            }
            .fa {
                font: normal normal normal 14px/1 FontAwesome;
                font-size: 14px;
                font-size: inherit;
                text-rendering: auto;
                -webkit-font-smoothing: antialiased;
                padding-left: 5px;
            }
            .page{
                height: 500px;
            }

            label{
                display: inline-block;
                margin-bottom: 5px;
                color: #666;
                clear: both;
            }
        </style>
    @endpush
    <div class="panel-body">
        <div id="ErrorMessage"></div>
        <div class="panel panel-success form-inline">
            <div class="panel-heading"><i class="fas fa-dollar-sign"></i> افزایش اعتبار کیف پول</div>
            <div class="panel-body">
                        <form id="form" novalidate="novalidate">
                        <div class="form-group col-md-4">
                            <label class="control-label" for="amount">ورود مبلغ</label>
                            <input id="amount" name="amount" class="form-control" placeholder="افزایش مبلغ (ریال)" type="text">
                        </div>
                        <div class="form-group col-md-5">
                            <label class="control-label col-sm-12" for="pay">روش پرداخت :</label>
                                <label class="radio-inline" style="margin-right: 0;"><input checked type="radio" name="pay" value="1">درگاه بانک ملت <font color="#990000">(پذیرنده کلیه کارتهای بانکی)</font></label>
                        </div>
                        <div class="form-group col-md-2">
                                <input type="submit" name="request" value="پرداخت اینترنتی" class="btn btn-primary info">
                        </div>
                        </form>

            </div>
        </div>
        <div class="panel panel-default panel-table">
            <div class="panel-heading"><i class="fas fa-history"></i> تاریخچه کیف پول (مانده فعلی:<span id="walletTotal" class="text-danger"></span>)</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table  class="table table-striped table-hover">
                        <thead>
                        <tr><td>شناسه</td><td>تاریخ</td><td>مبلغ تراکنش</td><td>نوع تراکنش</td><td>شماره پیگیری</td><td>بانک</td><td>وضعیت</td><td>مانده</td></tr>
                        </thead>
                        <tbody id="recordsTable">
                        <tr><td>dsfsd</td></tr>
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
    <script>
        function postRefId(refIdValue) {
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", "https://bpm.shaparak.ir/pgwchannel/startpay.mellat");
            form.setAttribute("target", "_self");
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("name", "RefId");
            hiddenField.setAttribute("value", refIdValue);
            form.appendChild(hiddenField);
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

        $(document).ready(function() {
            _search = function (page) {
                let token=localStorage.getItem('token');
                $.ajax({
                    method: 'GET',
                    url: `/api/v1/walletList/?page=${page}`,
                    data: {"token":token}
                }).done(function (response) {
                    if(response.status==='ok'){
                        let orders=response.data.data[0];
                        let walletTotal=response.data.walletTotal;
                        let paginate=response.data.data.paginate;
                        let data='';
                        $.each(orders,function (key,item) {
                            data+=`<tr title="${item.status===4?'موفق':'ناموفق'}" style="${item.status===4?'':'background-color:#ffdedb'}"><td>${item.id}</td>`;
                            data+=`<td>${item.date}</td>`;
                            data+=`<td>${formatPrice(item.deposit)}</td>`;
                            data+=`<td>${item.description!=null?item.description:''}</td>`;
                            data+=`<td>${item.payment_id}</td>`;
                            data+=`<td>${item.bank}</td>`;
                            data+=`<td>${item.status===4?'موفق':'ناموفق'}</td>`;
                            data+=`<td>${item.total}</td>`;
                        })
                        $('#recordsTable').html(data);
                        $('#walletTotal').html(formatPrice(walletTotal)+' '+localStorage.getItem('priceUnit'));
                        localStorage.setItem('wallet',walletTotal)
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

                });

            };
            _search(1);
            $("#form").validate({
                rules: {
                    amount:  {
                        required: true,
                        digits: true,
                        min : 1000,
                        max : 5000000
                    }
                },
                messages: {
                    amount: "مبلغ را صحیح و حداقل 1000 ریال وارد نمایید."
                }
            });
        });

        $('#form').on('submit',function (e) {
            if ($("#form").valid()) {
                e.preventDefault(e);
                let token=localStorage.getItem('token');
                $.ajax({
                    method: 'POST',
                    url: "{{url('api/v1/walletCharge')}}",
                    data: {'amount' : $('#amount').val(),'token':token },
                }).done(function (response) {
                    console.log(response.status);
                    if (response.status === "fail") {
                        let error='<div class="alert alert-danger"><li>'+response.message+'</li></div>';
                        $('#ErrorMessage').html(error);
                    }
                    else{
                        $('#ErrorMessage').html('');
                        $('#content').html(data);
                    }
                }).error(function (response) {
                    let error='<div class="alert alert-danger"><li>'+JSON.parse(response.responseText).message+'</li></div>';
                    $('#ErrorMessage').html(error);
                });
            }
        });
    </script>
@endsection
