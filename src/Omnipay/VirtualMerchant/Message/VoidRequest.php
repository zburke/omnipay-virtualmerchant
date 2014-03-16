<?php

namespace Omnipay\VirtualMerchant\Message;

/**
 * VirtualMerchant Sale Request
 */
class VoidRequest extends AbstractRequest
{
    protected $action = 'ccvoid';

    public function getData()
    {
        $data = $this->getBaseData();
        $data['ssl_txn_id'] = $this->getTransactionId();
        
        return array_merge($data, $this->getBillingData());
    }
}
