<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .firstImage{
            display:inline-block;
            width:35%;
            margin-left: 4rem;
        }
        .first{
            font-style: italic;
            font-size: 4rem;
            color:#008000;
            font-weight: 600;
            margin:2px 1px;
            font-weight: 900;
        }
        .header{
            width:80%;
            display:flex;
            align-items: center;
            margin:auto;
            justify-content: space-between;
        }
        .all{
        }
        .second{
            font-family: Arial, Helvetica, sans-serif;
        }
        .h2{}
        .secondItem{
            margin:auto;
            width:80%;
        }
        .thirdPortion{
            width:80%;
            display: flex;
            justify-content:space-between;
            margin:auto;
            font-family: Arial, Helvetica, sans-serif;
        }
        .fourthPortion{
            font-family: Arial, Helvetica, sans-serif;
            margin:auto;
            width:80%;
        }
        .line{
            line-height: 12px;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 80%;
            margin:auto;
            border:1px solid #000000 !important;
            text-align: left;
        }
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            text-align: left;
            border:1px solid #000000 !important;
        }

        tr:nth-child(even) {

        }
        .table-secondary{
            background-color: 	#808080;
        }
        .bottom{
            font-family: arial, sans-serif;
            width: 80%;
            margin:auto;
        }
        .bottomCenter{
            width:95%;
            margin:auto;
        }
        .orchid{
            display:flex;
            justify-content: space-between;
        }
        .footer{
            font-family: arial, sans-serif;
            width:100%;
            margin:auto;
            text-align: center;
            line-height: .6rem;
            font-size: 22px;
            font-weight: 500;
        }
        .tre{
            text-align: center !important;
            padding: 8px 75px;
        }
        .th1 {
            border: 1px solid #dddddd;
            background-color: grey;
            padding: 8px;
        }
        .red{
            color:red;
            background-color: grey;
            height:28px;
        }
    </style>
</head>
<body>
<div class="container all">
    <div class="row">
        {{--      Header Section Start--}}
        <div class="header">
            <div><img class="firstImage" src="{{base_path('/public/orchid.png')}}"></div>
            <div class="h2">
                <p class="first">Orchid Architect's <p>
                <p class="second">  Architect,English,Landscape,Interior & Exterior Consultancy.
                </p>
            </div>
        </div>
        <div class="secondItem">
            <hr  style = 'background-color:#32CD32; opacity:1 !important; border-width:0; color:#000000; height:2px; lineheight:0; width:100%; margin-bottom:0px !important;'>
            <hr  style = 'background-color:#000000; opacity:1 !important; margin-top:0px !important; border-width:0; color:#000000; height:2px; lineheight:0; display: inline-block; text-align: left; width:100%;'>
        </div>
        <div class="thirdPortion">
            <p style="margin-left:4rem;">
                Ref<span class="mx-1">:</span>
            </p>
            <p style="margin-right:4rem;">Date<span class="mx-1">:</span>  </p>
        </div>
        <div class="fourthPortion">
            <div class="line">
                <p>Date:  Wednesday,24 March 2021</p>
                <p>To</p>
                <p ><b>Company Name: {{$leed->clientName}}</b></p>
                <p>Contact: {{$leed->email}}</p>
                <p><b>Mobile: {{$leed->phoneNo}}</b></p>
                <p><b>Subject: {{$quotes->subject}} </b></p>
                <p >Honorabel Sir;</p>
            </div>
            <p >
                {{$quotes->body}}
            </p>
        </div>
        <table >
            <thead >
            <tr >
                <th class="th1">#</th>
                <th class="th1">Description</th>
                <th class="th1 tre">Description</th>
                <th class="th1">Unit</th>
                <th class="th1">Qty</th>
                <th class="th1">Rate</th>
                <th class="th1">Total Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($carts as $cart)
                <?php
                $cartInfo = json_decode($cart['houseAreaCartInfo']);
                $houseType = \App\Models\CRM\HouseAreaType::find($cart->houseAreaTypeId);
                ?>
                <tr class="">
                    <td></td>
                    <th class="red tre">{{$houseType->name}}</th>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach($cartInfo as $info)
                    <?php
                    $decorType = \App\Models\CRM\DecorationType::find($info->selectedDecor);
                    ?>
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$decorType->name}}</td>
                        <td>{{$info->selectedUnit}}</td>
                        <td>{{$info->selectedQty}}</td>
                        <td>{{$info->selectedRate}}</td>
                        <td>{{$info->line_total}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>{{$info->selectedDes}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            @endforeach
            <tr>
                <th></th>
                <th>Total Amount</th>
                <th></th>
                <th></th>
                <td>{{$quotes->totalAmount}}</td>
            </tr>
            <tr>
                <th></th>
                <th>Vat</th>
                <th></th>
                <th></th>
                <td>{{$quotes->totalVat}}</td>
            </tr>
            <tr>
                <th></th>
                <th>Discount</th>
                <th></th>
                <th></th>
                <td>{{$quotes->discount}}</td>
            </tr>
            <tr>
                <th></th>
                <th class="text-bold">Grand Total amount</th>
                <th></th>
                <th></th>
                <td>{{$quotes->grandTotal}}</td>
            </tr>
            </tbody>
        </table>
        <div class="bottom">
            <p style="font-weight: 900;font-size: 24px"><b>In word: Seventeen lakh Thirty Nine Thousand Seven Hundred Sixty Taka Only</b></p>
            <div class="bottomCenter">
                <p style="font-weight: 900;font-size: 19px;margin-left: 2rem;"><b>Terms and conditions for payment schedule:</b></p>
                <div style="margin-left: 7rem;">
                    <p>&#8667; 40% payment to be made along with confirmed word order.</p>
                    <p>&#8667; 50% payment to be made along with confirmed word order.</p>
                    <p >&#8667; 60% payment to be made along with confirmed word order.</p>
                </div>
                <p style="margin-bottom: 0px"> Duration of word completion: .....working days</p>
                <p style="margin-bottom: 0px">Please call us for any sort of inquires</p>
                <p>Thanks and best ragards</p>
                <div class=" orchid">
                    <div>
                        <p style="height: 3rem"></p>
                        <p style="border-top: 2px solid black; width:7rem;" class="mt-3"></p>
                        <p>Orchid Architect's<br>
                            Chief Executive Officer</p>
                    </div>
                    <div>
                        <p style="height: 3rem"></p>

                        <p style="border-bottom: 2px solid black; width:7rem;" class="mt-3"></p>
                        <p>Client</p>
                    </div>
                </div>
            </div>
            <hr  style = 'background-color:#32CD32; opacity:1 !important; border-width:0; color:#000000; height:2px; lineheight:0; width:100%; margin-bottom:0px !important;'>
            <hr  style = 'background-color:#000000; opacity:1 !important; margin-top:1px !important; border-width:0; color:#000000; height:2px; lineheight:0; display: inline-block; text-align: left; width:100%;'>
            <div class="footer">
                <p>House # 252/1/A, West Monipur Barek Mollar Mor,60'Road,Mirpur-2 Dhaka-1216</p>
                <p>Cell:01738-573747,01748-747651,Phone:02-55077910 E-mail:orchidarch.bd@gmail.com</p>
                <p style="letter-spacing: 3px"> www.orchidarchitect.com</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
