<?php

namespace Omnipay\VirtualMerchant;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    protected $voidOptions;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->purchaseOptions = array(
            'amount' => '10.00',
            'card' => $this->getValidCard(),
        );

        $this->captureOptions = array(
            'amount' => '10.00',
            'transactionReference' => '12345',
        );

        $this->voidOptions = array(
            'transactionReference' => '12345',
        );
    }

    public function testAuthorizeSuccess()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        $response = $this->gateway->authorize($this->purchaseOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('39024765209342', $response->getTransactionReference());
    }

    public function testAuthorizeFailure()
    {
        $this->setMockHttpResponse('AuthorizeFailure.txt');

        $response = $this->gateway->authorize($this->purchaseOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('5002', $response->getErrorCode());
        $this->assertSame('Amount Invalid', $response->getErrorName());
        $this->assertSame('The amount supplied in the authorization request appears to be invalid.', $response->getMessage());
    }

    public function testCaptureSuccess()
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');

        $response = $this->gateway->capture($this->captureOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('290357203452', $response->getTransactionReference());
    }

    public function testCaptureFailure()
    {
        $this->setMockHttpResponse('CaptureFailure.txt');

        $response = $this->gateway->capture($this->captureOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('5040', $response->getErrorCode());
        $this->assertSame('Invalid Transaction ID', $response->getErrorName());
        $this->assertSame('The transaction ID is invalid for this transaction type', $response->getMessage());
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->gateway->purchase($this->purchaseOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('0239845734650927', $response->getTransactionReference());
    }

    public function testPurchaseFailure()
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');

        $response = $this->gateway->purchase($this->purchaseOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('5002', $response->getErrorCode());
        $this->assertSame('Amount Invalid', $response->getErrorName());
        $this->assertSame('The amount supplied in the authorization request appears to be invalid.', $response->getMessage());
    }
    
    public function testVoidSuccess()
    {
        $this->setMockHttpResponse('VoidSuccess.txt');

        $response = $this->gateway->void($this->voidOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('948572093458720', $response->getTransactionReference());
    }

    public function testVoidFailure()
    {
        $this->setMockHttpResponse('VoidFailure.txt');

        $response = $this->gateway->void($this->voidOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('5040', $response->getErrorCode());
        $this->assertSame('Invalid Transaction ID', $response->getErrorName());
        $this->assertSame('The transaction ID is invalid for this transaction type', $response->getMessage());
    }
    
    public function testVmMerchantIdFailure()
    {
        $this->setMockHttpResponse('AuthenticateVmMerchantIdFailure.txt');
        
        $response = $this->gateway->void($this->voidOptions)->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('4012', $response->getErrorCode());
        $this->assertSame('VID/UID Invalid', $response->getErrorName());
        $this->assertSame('The VirtualMerchant ID and/or User ID supplied in the authorization request is invalid.', $response->getMessage());
    }
    
    public function testVmUserIdFailure()
    {
        $this->setMockHttpResponse('AuthenticateVmUserIdFailure.txt');
        
        $response = $this->gateway->void($this->voidOptions)->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('4001', $response->getErrorCode());
        $this->assertSame('VID, UID and PIN Invalid', $response->getErrorName());
        $this->assertSame('The VirtualMerchant ID, User ID and/or PIN supplied in the authorization request is invalid.', $response->getMessage());
    }
    
    public function testVmPinFailure()
    {
        $this->setMockHttpResponse('AuthenticateVmPinFailure.txt');
        
        $response = $this->gateway->void($this->voidOptions)->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('4015', $response->getErrorCode());
        $this->assertSame('PIN Invalid', $response->getErrorName());
        $this->assertSame('The PIN supplied in the authorization request is invalid.', $response->getMessage());
    }
}
