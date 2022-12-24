<thead>
<tr>
    <td nowrap="nowrap"><div align="center">نام سوپرمارکت</div></td>
    <td><div align="center">ip کاربر</div></td>
    <td><div align="center">نام کاربری</div></td>
    <td><div align="center">پسورد</div></td>
    <td><div align="center">تاریخ ورود</div></td>
</tr>
</thead>

<tbody>
@foreach($logs as $log)
    <tr>
        <?php $market= \App\Market::find(1); ?>
        <td>{{$market->name}}</td>
        <td style="text-align:center;">{{$log->ip}}</td>
        <td style="text-align:center;">{{$log->username}}</td>
        <td style="text-align:center;">{{$log->password}}</td>
        <td style="text-align:center;">{{jdate(date('Y-m-d',$log->date_enter))->format('%d %B، %Y')}}</td>
    </tr>
@endforeach

</tbody>
<input id="last-page" type="hidden" value="{{ceil($logCount / 10)}}" />
