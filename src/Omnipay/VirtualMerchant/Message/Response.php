<?php

namespace Omnipay\VirtualMerchant\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * VirtualMerchant  Response
 */
class Response extends AbstractResponse
{
    public $raw = null;
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->raw = (string) $data;

        $this->data = array();
        if ($data && count($data)) {
            foreach (explode("\n", $data) as $i) {
                list ($k, $v) = explode("=", $i);
                $this->data[$k] = $v;
            }
        } else {
            throw new InvalidResponseException();
        }
    }

    public function isSuccessful()
    {
        return (isset($this->data['ssl_result'])) && ('0' === $this->data['ssl_result']);
    }

    public function getCode()
    {
        return $this->valueFor('ssl_result');
    }

    public function getReasonCode()
    {
        return $this->valueFor('ssl_result_message');
    }

    public function getMessage()
    {
        return $this->valueFor('errorMessage');
    }

    public function getErrorCode()
    {
        return $this->valueFor('errorCode');
    }

    public function getErrorName()
    {
        return $this->valueFor('errorName');
    }

    public function getAvsCode()
    {
        return $this->valueFor('ssl_avs_response');
    }

    public function getTransactionReference()
    {
        return $this->valueFor('ssl_txn_id');
    }

    public function data()
    {
        return $this->data;
    }

    private function valueFor($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : '';
    }
}
