@extends('ocms.master')

@section('content')
    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div align="center">
            <div class="panel panel-default panel-table radius2px" style="height: 100px; padding: 20px;">

                <div  style="height: 50px;padding-top: 10px;text-align: center;">
                    <h4>صورت عملیات ورود مدیر سوپرمارکت به پنل کاربری</h4>
                </div>
            </div>
            <div class="panel panel-default panel-table radius2px">
                <div class="table-responsive">
                    <table id="records_table"  class="table table-striped  table-bordered">
                    </table>
                    <div class=" " style="text-align:center; direction:rtl; margin-top:35px ;margin-bottom: 35px;">
                        <button id="first-page" class="btn" style="float:none;margin: 1px"> << </button>
                        <button id="prev-page" class="btn" style="float:none;margin: 1px"> < </button>
                        <button id="page-number" class="btn btn-success" style="float:none;margin: 1px"> 1 </button>
                        <button id="next-page" class="btn" style="float:none;margin: 1px"> > </button>
                        <button id="last-page" class="btn" style="float:none;margin: 1px"> >> </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {

            _search = function (page) {
                $.ajax({
                    method: 'POST',
                    url: `/ocms/marketLogList?page=${page}`,
                    data: {'page_number' : $('#page-number').text() ,"_token": "{{ csrf_token() }}"}
                }).done(function (result) {
//                    console.log(result);
                    if (result == 'null'){
                        swal({
                            type: 'error',
                            title: 'هیچ لاگ سوپرمارکتی وجود ندارد'
                        })
                    }
                    else {
                        $('#records_table').html(result);
                        if (parseInt($('#page-number').text()) == 1)
                            $('#first-page, #prev-page').attr('disabled', 'disabled');
                        else
                            $('#first-page, #prev-page').removeAttr('disabled');

                        if (parseInt($('#page-number').text()) >= $('#last-page').val())
                            $('#last-page, #next-page').attr('disabled', 'disabled');
                        else
                            $('#last-page, #next-page').removeAttr('disabled');
                    }
                });

            };

            _search(1);

            $('#next-page').click(function(){

                if (parseInt($('#page-number').text()) >= parseInt($('#last-page').val()))
                    return;

                $('#page-number').text( parseInt($('#page-number').text()) + 1 );
                _search(1);
            });

            $('#prev-page').click(function(){

                if ($('#page-number').text() == '1')
                    return;

                $('#page-number').text( parseInt($('#page-number').text()) - 1 );
                _search(1);
            });

            $('#first-page').click(function(){

                $('#page-number').text( 1 );
                _search(1);
            });

            $('#last-page').click(function(){

                $('#page-number').text( $('#last-page').val() );
                _search(1);
            });


        })

    </script>

@endsection
