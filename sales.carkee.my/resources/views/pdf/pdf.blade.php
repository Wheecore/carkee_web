<!DOCTYPE html>

<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <title></title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <style>
        .qr-code {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>

<body style="background-color: #fff; font-family: system-ui;">
    @if ($type != 'invoice')
        <div class="qr-code">
          <img src="{{ $qrCode }}" alt="QR Code">
        </div>
    @endif
    <table align="center" cellpadding="0" cellspacing="0" style="color: #000; width: 100%;">
        <tbody>
            <tr>
                <td>
                    <div>
                        <img src="{{ public_path('images/carkee-logo.png') }}"
                            style="width: 250px; margin-bottom: 5px;">
                        <h4 style="font-size: 1.3125rem; font-weight: 700; margin-top: 0; margin-bottom: 5px;">
                            Carkee Automative Sdn Bhd.
                        </h4>
                        <p>9, Jalan Linggis 15/24, Seksyen 15, 40200 Shah Alam, Selangor</p>
                        <p>Telephone: 0123440911 Email: enquiry@carkee.my</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <div style="text-align: left;">
                        <p>{{ $order->created_at }}</p>
                    </div>
                </td>
                <td width="50%">
                    <div style="text-align: right;">
                        @if ($type == 'invoice')
                            <h5 style="margin: unset; font-size: 18px;">INVOICE</h5>
                        @else
                            <h5 style="margin: unset; font-size: 18px;">DELIVERY ORDER</h5>
                        @endif
                        <h6 style="margin: unset; font-size: 14px;">Number: {{ $order->code }}</h6>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table align="center" cellpadding="0" cellspacing="0" style="color: #000; width: 100%;">
        <thead>
            <tr>
                <th width="50%" style="text-align: left;">SOLD TO:</th>
                <th width="50%" style="text-align: left;">DELIVER TO:</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="50%" style="border: 2px solid #333; padding: 5px;">
                    <p style="margin: unset; margin-block-start: unset;"><strong>Customer Code</strong>:
                        {{ $order->customer_code }}</p>
                    <p style="margin: unset;"><strong>{{ $order->name }}</strong></p>
                    <p class="mb-1"><strong>Contact Person</strong>: {{ $order->pic_name ?: '-' }}
                        ({{ $order->pic_name && $order->pic_phone ? $order->pic_phone : '-' }})</p>
                    <p><strong>Tel</strong>: {{ $order->company_phone }}</p>
                </td>
                <td width="50%" style="border: 2px solid #333; padding: 5px;">
                    <p>{{ $order->address }}</p>
                </td>
            </tr>
        </tbody>
    </table>
    <table align="center" cellpadding="0" cellspacing="0" style="color: #000; width: 100%; padding-top: 20px;">
        <thead>
            <tr style="text-align: left;">
                <th style="border: 1px solid #333; padding: 5px; font-size: 15px;">SALES PERSON</th>
                <th style="border: 1px solid #333; padding: 5px; font-size: 15px;">PAYMENT TERMS</th>
                <th style="border: 1px solid #333; padding: 5px; font-size: 15px;">PAYMENT DUE DATE</th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align: left;">
                <td style="border: 1px solid #333; padding: 5px;">{{ $order->staff }}</td>
                <td style="border: 1px solid #333; padding: 5px;">{{ $order->payment_term }}</td>
                <td style="border: 1px solid #333; padding: 5px;">{{ $order->payment_due_date }}</td>
            </tr>
        </tbody>
    </table>
    <table align="center" cellpadding="0" cellspacing="0" style="color: #000; width: 100%; padding-top: 20px;">
        <thead>
            <tr>
                <th width="5%" style="border: 1px solid #333; padding: 5px; font-size: 15px;">S/N</th>
                <th width="5%" style="border: 1px solid #333; padding: 5px; font-size: 15px;">CODE</th>
                <th width="30%" style="border: 1px solid #333; padding: 5px; font-size: 15px;">DESCRIPTION</th>
                <th width="10%" style="border: 1px solid #333; padding: 5px; font-size: 15px;">QTY</th>
                <th width="10%" style="border: 1px solid #333; padding: 5px; font-size: 15px;">FOC</th>
                <th width="10%" style="border: 1px solid #333; padding: 5px; font-size: 15px;">UOM</th>
                @if ($type == 'invoice')
                    <th width="10%" style="border: 1px solid #333; padding: 5px; font-size: 15px;">UNIT PRICE</th>
                    <th width="10%" style="border: 1px solid #333; padding: 5px; font-size: 15px;">DISC %</th>
                    <th width="10%" style="border: 1px solid #333; padding: 5px; font-size: 15px;">AMOUNT</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($order_items as $key => $item)
                <tr>
                    <td style="border: 1px solid #333; padding: 5px;">{{ $key + 1 }}</td>
                    <td style="border: 1px solid #333; padding: 5px;">-</td>
                    <td style="border: 1px solid #333; padding: 5px;">{{ $item->name }}</td>
                    <td style="border: 1px solid #333; padding: 5px;">{{ $item->qty }}</td>
                    <td style="border: 1px solid #333; padding: 5px;">{{ $item->foc }}</td>
                    <td style="border: 1px solid #333; padding: 5px;">{{ $item->uom }}</td>
                    @if ($type == 'invoice')
                        <td style="border: 1px solid #333; padding: 5px;">{{ $item->amount }}</td>
                        <td style="border: 1px solid #333; padding: 5px;">{{ $item->disc }}</td>
                        <td style="border: 1px solid #333; padding: 5px;">
                            {{ $item->qty * $item->amount - ($item->disc / 100) * ($item->qty * $item->amount) }}
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <table align="center" cellpadding="0" cellspacing="0" style="color: #000; width: 100%; padding-top: 20px;">
        <tbody>
            <tr>
                <td width="70%">
                    <h5 style="margin-block-end: 10px; font-size: 18px;"><u>OTHER INFORMATION</u></h5>
                    <h6 style="margin-block-start: unset; font-size: 13px;">Note:</h6>
                    <h6 style="margin-block-start: unset; font-size: 13px;">Terms & Condition:</h6>
                </td>
                <td width="30%">
                    @if ($type == 'invoice')
                        <table align="center" cellpadding="0" cellspacing="0" style="color: #000; padding-top: 20px;">
                            <tbody>
                                <tr>
                                    <th
                                        style="text-align: right; border: 1px solid #333; padding: 5px; font-size: 15px;">
                                        SUBTOTAL (MYR)</th>
                                    <td style="border: 1px solid #333; padding: 5px;">{{ $order->total }}</td>
                                </tr>
                                <tr>
                                    <th
                                        style="text-align: right; border: 1px solid #333; padding: 5px; font-size: 15px;">
                                        TAX (MYR)</th>
                                    <td style="border: 1px solid #333; padding: 5px;">0.00</td>
                                </tr>
                                <tr>
                                    <th
                                        style="text-align: right; border: 1px solid #333; padding: 5px; font-size: 15px;">
                                        TOTAL (MYR)</th>
                                    <td style="border: 1px solid #333; padding: 5px;">{{ $order->total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <table align="center" cellpadding="0" cellspacing="0"
        style="color: #000; width: 100%; padding-top: 20px; border: 2px solid #333; padding: 5px;">
        <tbody>
            <tr>
                <td width="50%">
                    <div style="float: left;">
                        <p style="margin-bottom: 5px; margin-block-start: unset;">Beneficiary Bank: MAYBANK</p>
                        <p style="margin-bottom: 5px;">Beneficiary Account No: 562683215043</p>
                    </div>
                </td>
                <td width="50%">
                    <div style="float: right;">
                        <h5 style="margin-block-end: 10px; font-size: 18px;">Carkee Automative Sdn Bhd.</h5>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
