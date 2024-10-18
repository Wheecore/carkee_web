<?php
/**
 * Created by PhpStorm.
 * User: ishfaq rahim
 * Date: 9/17/2021
 * Time: 7:42 PM
 */
//namespace IPay88\Payment\Request;

class Payment {

    protected $_merchantCode;
    protected $_merchantKey;

    public function __construct()
    {
        parent::__construct();
        $this->_merchantCode = 'xxxxxx'; //MerchantCode confidential
        $this->_merchantKey = 'xxxxxxxxx'; //MerchantKey confidential
    }

    public function index()
    {
        $request = new IPay88\Payment\Request($this->_merchantKey);
        $this->_data = array(
            'merchantCode' => $request->setMerchantCode($this->_merchantCode),
            'paymentId' =>  $request->setPaymentId(1),
            'refNo' => $request->setRefNo('EXAMPLE0001'),
            'amount' => $request->setAmount('0.50'),
            'currency' => $request->setCurrency('MYR'),
            'prodDesc' => $request->setProdDesc('Testing'),
            'userName' => $request->setUserName('Your name'),
            'userEmail' => $request->setUserEmail('email@example.com'),
            'userContact' => $request->setUserContact('0123456789'),
            'remark' => $request->setRemark('Some remarks here..'),
            'lang' => $request->setLang('UTF-8'),
            'signature' => $request->getSignature(),
            'responseUrl' => $request->setResponseUrl('http://example.com/response'),
            'backendUrl' => $request->setBackendUrl('http://example.com/backend')
        );

        IPay88\Payment\Request::make($this->_merchantKey, $this->_data);
    }

    public function response()
    {
        $response = (new IPay88\Payment\Response)->init($this->_merchantCode);
        echo "<pre>";
        print_r($response);
    }
}