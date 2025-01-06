<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
</head>

<body style="font-family: sans-serif">

    <table style="width: 100%;">
        <tr>
            <th
                style="width: 75%;
        text-align: left;
        font-family: system-ui;
        letter-spacing: 2px;
        color: darkblue;">
                TAX INVOICE</th>
            <th style="width: 25%;">ORIGINAL FOR RECIPIENT</th>

        </tr>
        <tr>
            <td style="width: 75%;">
                <h1 style="font-size: 24px;
                font-family: system-ui;margin-bottom: 10px">Steel Ghar</h1>
                <span style="font-size: 16px;font-family: sans-serif;">
                    GSTIN : <strong>XXXXX XXXXX XX</strong> <br>
                    Address line one, Address line one<br>
                    city name, satae - pincode <br>
                    Phone: +91 xxxxxxxxxx</span>

            </td>
            <td style="width: 25%;">
                <img src="https://theprintplanet.co.in/steelghar/console/public/storage/images/logo.jpeg"
                    alt="" style="width: 250px;"><br>
                <!-- <p style="color: white;">.</p> -->
            </td>
        </tr>
    </table>

    <table style="width: 100%;margin-top: 10px;font-family: sans-serif;">
        <tr>
            <td style="width: 30%;
            text-align: left;
            font-size: 18px;
            ">Invoice #:
                <strong>{{ $order->order_id }}</strong>
            </td>
            <td style="width: 40%;
            text-align: left;
            font-size: 18px;
           ">Invoice Date:
                <strong>{{ $order->created_at->format('d M Y') }}</strong>
            </td>

        </tr>

    </table>


    <table style="width: 100%;margin-top: 10px;font-family: sans-serif;">
        <tr>
            <td style="width: 30%;text-align: left;">Customer Details:</td>
            <td style="width: 45%;text-align: left;">Customer Address:</td>

        </tr>
        <tr>
            <td style="width: 30%;text-align: left;"><strong style="font-size: 18px;">{{ $customer->name }}
                </strong><br>{{ $customer->phone }}
                <br>{{ $customer->email }}
            </td>
            <td style="width: 45%;text-align: left;">{{ $address->address }}<br>{{ $address->address2 }}
                {{ $address->city }},{{ $address->state }} - {{ $address->pincode }}
                <br>
                {{ $address->landmark }}
            </td>

        </tr>
    </table>





    <table
        style="width: 100%;border-bottom: 2px solid rgba(131, 129, 129, 0.438);;
    border-collapse: collapse; margin-top:10px;margin-bottom:10px">
        <tr style="background-color: #96D4D4; border-bottom: 2px solid #010e59; border-top: 2px solid #010e59;">
            <th style="width: 5%;text-align: left; ">#</th>
            <th style="width: 30%;text-align: left;">Product</th>
            <th style="width: 15%;text-align: left;">Weight</th>
            <th style="width: 5%;text-align: left;">Length</th>
            <th style="width: 20%;text-align: right;">Amount</th>
        </tr>

        @foreach ($orderItems as $item)
            <tr style="border-bottom: 2px solid rgba(131, 129, 129, 0.438);">
                <td style="width: 5%;text-align: left;">{{ $loop->iteration }} </td>
                <td style="width: 30%;text-align: left;padding: 8px">{{ $item->product_name }}
                    <br>{{ $item->attribute }}
                </td>
                <td style="width: 15%;text-align: left;">{{ $item->weight }}</td>
                <td style="width: 5%;text-align: left;">{{ $item->length }}</td>
                <td style="width: 20%;text-align: right;">{{ $item->price }}</td>
            </tr>
        @endforeach
        <tr style="">
            <td style="width: 5%;text-align: left;"> </td>

            <td style="width: 15%;text-align: left;"></td>
            <td style="width: 5%;text-align: right;" colspan="2">Subtotal</td>
            <td style="width: 20%;text-align: right;">{{ $order->sub_total }}</td>
        </tr>
        <tr style="">
            <td style="width: 5%;text-align: left;"> </td>

            <td style="width: 15%;text-align: left;"></td>
            <td style="width: 5%;text-align: right;" colspan="2">Shipping Charge</td>
            <td style="width: 20%;text-align: right;">{{ $order->shipping_charge }}</td>
        </tr>
        <tr style="">
            <td style="width: 5%;text-align: left;"> </td>

            <td style="width: 15%;text-align: left;"></td>
            <td style="width: 5%;text-align: right;" colspan="2">Handling Charge</td>
            <td style="width: 20%;text-align: right;">{{ $order->handling_charge }}</td>
        </tr>
        <tr style="">
            <td style="width: 5%;text-align: left;"> </td>

            <td style="width: 15%;text-align: left;"></td>
            <td style="width: 5%;text-align: right;" colspan="2">GST</td>
            <td style="width: 20%;text-align: right;">{{ $order->gst }}</td>
        </tr>
        <tr style="">
            <td style="width: 5%;text-align: left;"> </td>

            <td style="width: 15%;text-align: left;"></td>
            <td style="width: 5%;text-align: right;" colspan="2">Grand Total</td>
            <td style="width: 20%;text-align: right;">{{ $order->payable_amount }}</td>
        </tr>
    </table>


    <b>Note:</b>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
    </p>
    <b>Terms and conditions:</b>
    <ol>
        <li>Lorem ipsum dolor sit, amet consectetur </li>
        <li>voluptatem vero, atque enim hic quidem</li>
        <li>Ea quasi nam ipsum, ipsam unde dolore.</li>
        <li>laboriosam ea perferendis debitis</li>
    </ol>

</body>

</html>
