<!doctype html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hóa đơn</title>

    <style type="text/css">
     /* Global styles */
* {
    font-family: "DejaVu Sans", sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    line-height: 1.6;
    color: #333;
    padding: 20px;
    background-color: #f9f9f9;
}

table {
    font-size: 14px;
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

tfoot tr td {
    font-weight: bold;
    font-size: 14px;
}

/* Color and Background */
.gray {
    background-color: #f7f7f7;
}

/* Font sizes */
.font {
    font-size: 15px;
}

/* Authority Section */
.authority {
    width: 100%;
    text-align: center;
    margin-top: 30px;
}

.authority h5 {
    margin-top: -5px;
    color: #0066cc;
    text-align: center;
    font-size: 16px;
}

.authority p {
    color: #333;
    font-size: 14px;
    margin-top: 5px;
}

/* Thanks Section */
.thanks p {
    color: #0066cc;
    font-size: 16px;
    font-weight: bold;
    margin-top: 30px;
    text-align: center;
}

/* Header Styling */
.header {
    background: #0066cc;
    color: white;
    padding: 20px;
    text-align: left;
    border-radius: 5px;
    margin-bottom: 20px;
}

.header h2 {
    margin: 0;
    font-size: 24px;
}

.header pre {
    font-size: 14px;
    color: #e6e6e6;
    line-height: 1.4;
    margin-top: 10px;
}

/* Table Styling */
.table-header {
    background-color: #0066cc;
    color: #FFFFFF;
    text-align: left;
    font-weight: bold;
}

.table-header th {
    padding: 10px;
}

.table-row {
    background: #ffffff;
    border-bottom: 1px solid #dddddd;
}

.table-row td {
    padding: 10px;
}

.table-row:nth-child(even) {
    background: #f7f7f7;
}

/* Price Details */
.price-details {
    text-align: right;
    margin-top: 20px;
}

.price-details h2 {
    color: #0066cc;
    margin-bottom: 10px;
    font-size: 20px;
}

.price-details td {
    padding: 5px 10px;
    font-size: 14px;
    color: #333;
}

/* Footer */
.footer {
    text-align: center;
    margin-top: 50px;
    font-size: 14px;
    color: #333;
}

.footer p {
    margin: 5px 0;
}

/* Responsive */
@media (max-width: 768px) {
    .header, .authority, .thanks, .price-details {
        text-align: center;
    }

    table {
        font-size: 12px;
    }
}
    </style>

</head>
<body>

<table width="100%">
    <tr>
        <td valign="top">
            <h2 ><strong>Viet Nam Vi Vu Xin Cam On</strong></h2>
        </td>
        
    </tr>
    <tr>
        <td align="left">
            <pre class="font">
               Phone: 0356960603 <br>
               Địa chỉ: Thành phố Hà Nội <br>
               Email:support@vnvivu.com <br>
            </pre>
        </td>
    </tr>

</table>


<table width="100%" ></table>

<table width="100%"  class="font">
    <tr>
        <td>
            <p class="font" ">
                <strong>Tên:</strong> {{ $booking->customer->first_name . ' ' .  $booking->customer->last_name}} <br>
                <strong>Email:</strong> {{ $booking->customer->email }} <br>
                <strong>Số điện thoại:</strong> {{ $booking->customer->phone }} <br>
                @php
                    $address = sprintf("%s, %s, %s, %s", $booking->customer->address, $booking->customer->province, $booking->customer->city, $booking->customer->country)
                @endphp
                <strong>Địa chỉ:</strong> {{ $address }} <br>
            </p>
        </td>
        <td>
            <p class="font">
                Ngày đặt: {{ date("Y-m-d",strtotime($booking->created_at)) }} <br>
                Loại thanh toán :
                @if($booking->payment_method == PAYMENT_CASH)
                    Tiền mặt
                @elseif($booking->payment_method == PAYMENT_MOMO)
                    Momo
                @endif
            </p>
        </td>
    </tr>
</table>
<br/>
<h3>Phòng</h3>


<table width="100%">
    <thead >
    <tr class="font">
        <th scope="col">#</th>
        <th scope="col">Dịch vụ</th>
        <th scope="col">Số lượng</th>
        <th scope="col">Giá</th>
        <th scope="col">Tổng tiền</th>
    </tr>
    </thead>
    <tbody>
    <tr class="font">
        <td>{{ 1  }}</td>
        <td>{{ $booking->tour->name }}</td>
        <td>{{ $booking->people }}</td>
        <td>{{ number_format($booking->price) }}đ</td>
        <td>{{ number_format($booking->people * $booking->price) }}đ</td>
    </tr>
    @foreach($booking->rooms as $room)
        <tr class="font">
            <td>{{ $loop->index + 2  }}</td>
            <td>{{ $room->name }}</td>
            <td>{{ $room->pivot->number }}</td>
            <td>{{ number_format($room->pivot->price) }}đ</td>
            <td>{{ number_format($room->pivot->number * $room->pivot->price) }}đ</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>
<table width="100%">
    <tr align="right">
        <td align="right">
            <h2><span >Giá:</span></h2>
        </td>
        <td align="left" width="200px">
            <h2>{{ number_format($booking->total / (100 - $booking->discount) * 100) }}₫</h2>
        </td>
    </tr>
    <tr align="right">
        <td align="right">
            <h2><span >Giám giá:</span></h2>
        </td>
        <td align="left">
            <h2>{{ $booking->discount }}%</h2>
        </td>
    </tr>
    <tr align="right">
        <td align="right">
            <h2><span >Tổng giá:</span></h2>
        </td>
        <td align="left">
            <h2>{{ number_format($booking->total) }} ₫</h2>
        </td>
    </tr>
</table>
<div class="thanks mt-3">
    <p>Cảm ơn đã đặt tour của chúng tôi..!!</p>
</div>
<div class="authority">
    <p>-----------------------------------</p>
    <h5>Hóa đơn được tạo bởi: công ty du lịch VNVIVU</h5>
</div>
</body>
</html>
