<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>PDF</title>
<style>
@font-face{
    font-family: ipaexg;
    font-style: normal;
    font-weight: normal;
    src:url('{{ storage_path('fonts/ipaexg.ttf')}}');
}
body {
font-family: ipaexg;
color:rgb(58, 56, 56);
}
section{
    width: 180mm;
    height: 250mm;
    margin: 5mm;
    margin: 5mm;
    page-break-after: auto;
}
h1{
   text-align: center;
   margin-bottom: 20mm;
}
h2{
   text-align: center;
   margin-bottom: 0mm;
   padding: 0;
}
h4{
   margin: 0mm;
   padding: 0;
}
.mycompany{
    text-align: center;
}
.text-right{
    text-align: right;
}
</style>
</head>
@php
    
@endphp
<body>
    @foreach($orders as $order)
    <section class="text-center">
        <div class="mycompany">
           <h2> ABC Company Ltd.</h2>
           <h4>1-1-1, Shirogane,Chuouku,Tokyo, Japan <br>
            TEL: 03-0000-0000<br>
           </h4>
        </div>
        <h1 class="text-center">PURCHASE ORDER</h1>
        <h4 class="text-right">ORDER No. : {{$order->order_number}}</h4>
        <h4 class="text-right">DATE : {{$orders->issue_date}}</h4>
        {{--makers section--}}
        <h4>{{$order->maker->name}}</h4>
        <h4>{{$order->maker->address}}</h4>
        <h4>{{$order->maker->tel}}</h4>
        <h4>{{$order->maker->person_in_charge}}</h4>

        <hr>
        <h5>
        <table border="2px" cellspacing="0" cellpadding="9" >
            <tr class="text-center">
                <td width="50mm"><h4>Product Name</h4></td>
                <td width="25mm"><h4>Quantity</h4></td>
                <td width="25mm"><h4>Unit Price</h4></td>
                <td width="25mm"><h4>Amount</h4></td>
            </tr>
            <tr>
                <td width="80mm"><h4>{{$order->product_name}}</h4></td>
                <td><h4>{{$order->quantity}}</h4></td>
                <td><h4>{{$order->purchase_price}}</h4></td>
                <td><h4>{{$order->quantity * $order->purchase_price}}</h4></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><h4>Total</h4></td>
                <td><h4>{{$order->quantity * $order->purchase_price}}</h4></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        </h5>

        <br><br><br>                        
        <h4>Delivery Date : {{$order->expected_arrival_date}}</h4><br>
        <h4>Payment : 100% TT after receiving goods</h4>
        
    </section>
    @endforeach
    
</body>
</html>