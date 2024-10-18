<html>
  <head>
    <title>iPay88 Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    .loader {
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #3498db;
      width: 120px;
      height: 120px;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
      margin: auto;
    }

    /* Safari */
    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    </style>
  </head>
  <body>
    <form method="post" name="ePayment" id="ePayment" action="https://payment.ipay88.com.my/ePayment/entry.asp">
      <input type="hidden" name="MerchantKey" value="{{ env('IPAY88_MERCHANT_KEY') }}">
      <input type="hidden" name="MerchantCode" value="{{ env('IPAY88_MERCHANT_CODE') }}">
      <input type="hidden" name="PaymentId" value="">
      <input type="hidden" name="RefNo" value="{{ $order->code }}">
      <input type="hidden" name="Amount" value="{{ $amount }}">
      <input type="hidden" name="Currency" value="MYR">
      <input type="hidden" name="ProdDesc" value="Order #{{ $order->code }}">
      <input type="hidden" name="UserName" value="{{ Auth::user()->name }}">
      <input type="hidden" name="UserEmail" value="{{ Auth::user()->email }}">
      <input type="hidden" name="UserContact" value="{{ Auth::user()->phone }}">
      <input type="hidden" name="Remark" value="">
      <input type="hidden" name="Lang" value="UTF-8">
      <input type="hidden" name="SignatureType" value="SHA256">
      <input type="hidden" name="Signature" value="{{ $hash }}">
      <input type="hidden" name="ResponseURL" value="{{ route('ipay88.response') }}">
      <input type="hidden" name="BackendURL" value="{{ route('ipay88.backend') }}">
      <input type="submit" value="Proceed with Payment" id="checkout-button" style="display: none;" name="Submit">
    </form>
    <div class="loader"></div>
    <br><br>
    <p style="width: 250px; margin: auto;">Don't close the tab. The payment is being processed . . .</p>
    <script type="text/javascript">
      document.getElementById("checkout-button").click();
      document.getElementById('ePayment').submit();
    </script>
    
  </body>
</html>
