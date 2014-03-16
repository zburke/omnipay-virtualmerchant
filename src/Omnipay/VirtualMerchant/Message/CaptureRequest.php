<?php

namespace Omnipay\VirtualMerchant\Message;

/**
 * VirtualMerchant Capture Request
 */
class CaptureRequest extends AbstractRequest
{
    protected $action = 'cccomplete';

    public function getData()
    {
        $data = $this->getBaseData();
        $data['ssl_txn_id'] = $this->getTransactionId();
        
        return array_merge($data, $this->getBillingData());
    }
}
