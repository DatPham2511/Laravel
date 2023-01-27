<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>Khuyến mãi Đạt Store <a href="https://datstore.com/laravel/public">https://datstore.com/laravel/public</a></h3>
    @if($coupon['coupon_condition']==1)
        <p>Shop tặng bạn mã giảm {{$coupon['coupon_number']}}%: {{$coupon['coupon_code']}}</p>
    @else
    <p>Shop tặng bạn mã giảm {{number_format($coupon['coupon_number'],0,',','.')}} vnđ: {{$coupon['coupon_code']}}</p>
    @endif
    <p>Mã giảm bắt đầu từ ngày {{$coupon['coupon_date_start']}} đến hết ngày {{$coupon['coupon_date_end']}}</p>
</body>
</html>


