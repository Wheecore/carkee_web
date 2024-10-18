<html xmlns="http://www.w3.org/1999/xhtml"><head>
    {{-- <script type="text/javascript">
     function closethisasap() {
     document.forms["redirectpost"].submit();
      }
    </script> --}}
    </head>
    <link>
    <body>
        <?php
     $packagePrice = 100;
    //============================Get EForm Values=========================================================
    
    
    //=============================JazzCash API Configurations=============================================
    $pp_Amount = $packagePrice * 100;
    
    
    $MerchantID = 'MC75517'; //Your Merchant from transaction Credentials
    $Password = '552y8b5305'; //Your Password from transaction Credentials
    $HashKey = '9885s08142'; //Your HashKey/integrity salt from transaction Credentials
    $ReturnURL = 'https://lottery.carkee.my/api/jazzcash-success';
    
    
    date_default_timezone_set("Asia/karachi");
    
    $Amount = $pp_Amount; //Last two digits will be considered as Decimal thats the reason we are multiplying amount with 100 in line number 11
    $BillReference = "billRef"; //use AlphaNumeric only
    $Description = "Product test description"; //use AlphaNumeric only
    $IsRegisteredCustomer = "No"; // do not change it
    $Language = 'EN'; // do not change it
    $TxnCurrency = 'PKR'; // do not change it
    $TxnDateTime = date('YmdHis');
    $TxnExpiryDateTime = date('YmdHis', strtotime('+1 Days'));
    $TxnRefNumber = 'EHB'.date('YmdHis') . mt_rand(10, 100);
    $TxnType = "MWALLET"; // Leave it empty
    $Version = '1.1';
    $SubMerchantID = ""; // Leave it empty
    $BankID = "TBANK"; // Leave it empty
    $ProductID = "RETL"; // Leave it empty
    $ppmpf_1 = "1"; // use to store extra details (use AlphaNumeric only)
    $ppmpf_2 = "1"; // use to store extra details (use AlphaNumeric only)
    $ppmpf_3 = "3"; // use to store extra details (use AlphaNumeric only)
    $ppmpf_4 = "4"; // use to store extra details (use AlphaNumeric only)
    $ppmpf_5 = "5"; // use to store extra details (use AlphaNumeric only)
    
    //========================================Hash Array for making Secure Hash for API call================================
    $HashArray = [$Amount, $BankID, $BillReference, $Description, $IsRegisteredCustomer,
        $Language, $MerchantID, $Password, $ProductID, $ReturnURL, $TxnCurrency, $TxnDateTime,
        $TxnExpiryDateTime, $TxnRefNumber, $TxnType, $Version, $ppmpf_1, $ppmpf_2, $ppmpf_3,
        $ppmpf_4, $ppmpf_5];
    
    $SortedArray = $HashKey;
    for ($i = 0; $i < count($HashArray); $i++) {
        if ($HashArray[$i] != 'undefined' and $HashArray[$i] != null and $HashArray[$i] != "") {
            $SortedArray .= "&" . $HashArray[$i];
        }
    }
    $Securehash = hash_hmac('sha256', $SortedArray, $HashKey);
    
        ?>
    
        <form method="post" action="https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/" >
            <input type="hidden" name="pp_Version" value="<?php echo $Version; ?>" />
            <input type="hidden" name="pp_TxnType" placeholder="TxnType" value="<?php echo $TxnType; ?>" />
            <input type="hidden" name="pp_Language" value="<?php echo $Language; ?>" />
            <input type="hidden" name="pp_MerchantID" value="<?php echo $MerchantID; ?>" />
            <input type="hidden" name="pp_SubMerchantID" value="<?php echo $SubMerchantID; ?>" />
            <input type="hidden" name="pp_Password" value="<?php echo $Password; ?>" />
            <input type="hidden" name="pp_TxnRefNo" value="<?php echo $TxnRefNumber; ?>" />
            <input type="hidden" name="pp_Amount" value="<?php echo $Amount; ?>" />
            <input type="hidden" name="pp_TxnCurrency" value="<?php echo $TxnCurrency; ?>" />
            <input type="hidden" name="pp_TxnDateTime" value="<?php echo $TxnDateTime; ?>" />
            <input type="hidden" name="pp_BillReference" value="<?php echo $BillReference ?>" />
            <input type="hidden" name="pp_Description" value="<?php echo $Description; ?>" />
            <input type="hidden" name="pp_IsRegisteredCustomer" value="<?php echo $IsRegisteredCustomer; ?>" />
            <input type="hidden" id="pp_BankID" name="pp_BankID" value="<?php echo $BankID ?>">
            <input type="hidden" id="pp_ProductID" name="pp_ProductID" value="<?php echo $ProductID ?>">
            <input type="hidden" name="pp_TxnExpiryDateTime" value="<?php echo $TxnExpiryDateTime; ?>" />
            <input type="hidden" name="pp_ReturnURL" value="<?php echo $ReturnURL; ?>" />
            <input type="hidden" name="pp_SecureHash" value="<?php echo $Securehash; ?>" />
            <input type="hidden" name="ppmpf_1" placeholder="ppmpf_1" value="<?php echo $ppmpf_1; ?>" />
            <input type="hidden" name="ppmpf_2" placeholder="ppmpf_2" value="<?php echo $ppmpf_2; ?>" />
            <input type="hidden" name="ppmpf_3" placeholder="ppmpf_3" value="<?php echo $ppmpf_3; ?>" />
            <input type="hidden" name="ppmpf_4" placeholder="ppmpf_4" value="<?php echo $ppmpf_4; ?>" />
            <input type="hidden" name="ppmpf_5" placeholder="ppmpf_5" value="<?php echo $ppmpf_5; ?>" /><br> <br> <br>
    
            <div class="row margin-top-5">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="input-group-text text-center" style="display: block;">Pay With</div>
                    <div class="text-center" style="margin-top: 5%;">
                        <a id="payBtn" class="btn btn-primary py-2">Back</a>
                        <button type="submit" class="btn btn-info py-2">Pay</button>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </form>
    {{-- <h1>Please wait you will be redirected soon to <br >Jazzcash Payment Page</h1> --}}
     {{-- <form name="redirectpost" method="POST" action="{{Config::get('constants.jazzcash.TRANSACTION_POST_URL')}}">
         <?php 
        //  $post_data = Session::get('post_data');
         ?>
     @foreach($post_data as $key => $value)
        <input type="text" name="{{ $key }}" value="{{ $value }}">
     @endforeach
    <button type="submit">submit</button>
     </form> --}}
     </body>
     </html>