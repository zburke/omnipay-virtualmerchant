<?php

namespace Omnipay\VirtualMerchant\Message;

/**
 * VirtualMerchant Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndpoint = 'https://www.myvirtualmerchant.com/VirtualMerchant/process.do';
    protected $developerEndpoint = 'https://demo.myvirtualmerchant.com/VirtualMerchantDemo/process.do';

    public function getVmMerchantId()
    {
        return $this->getParameter('vmMerchantId');
    }

    public function setVmMerchantId($value)
    {
        return $this->setParameter('vmMerchantId', $value);
    }

    public function getVmUserId()
    {
        return $this->getParameter('vmUserId');
    }

    public function setVmUserId($value)
    {
        return $this->setParameter('vmUserId', $value);
    }

    public function getVmPin()
    {
        return $this->getParameter('vmPin');
    }

    public function setVmPin($value)
    {
        return $this->setParameter('vmPin', $value);
    }

    public function getDeveloperMode()
    {
        return $this->getParameter('developerMode');
    }

    public function setDeveloperMode($value)
    {
        return $this->setParameter('developerMode', $value);
    }

    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function setCustomerId($value)
    {
        return $this->setParameter('customerId', $value);
    }

    protected function getBaseData()
    {
        $data = array();
        $data['ssl_merchant_id'] = $this->getVmMerchantId();
        $data['ssl_user_id'] = $this->getVmUserId();
        $data['ssl_pin'] = $this->getVmPin();
        $data['ssl_transaction_type'] = $this->action;
        $data['ssl_show_form'] = 'false';
        $data['ssl_result_format'] = 'ASCII';
        
        return $data;
    }

    protected function getBillingData()
    {
        $data = array();
        $data['ssl_amount'] = $this->getAmount();
        $data['ssl_invoice_number'] = $this->getDescription();

        if ($card = $this->getCard()) {
            // customer billing details
            $data['ssl_first_name'] = $card->getBillingFirstName();
            $data['ssl_last_name'] = $card->getBillingLastName();
            $data['ssl_company'] = $card->getBillingCompany();
            $data['ssl_avs_address'] = $card->getBillingAddress1();
            $data['ssl_address2'] = $card->getBillingAddress2();

            $data['ssl_city'] = $card->getBillingCity();
            $data['ssl_state'] = $card->getBillingState();
            $data['ssl_avs_zip'] = $card->getBillingPostcode();
            $data['ssl_country'] = $card->getBillingCountry();
            $data['ssl_phone'] = $card->getBillingPhone();
            $data['ssl_email'] = $card->getEmail();

            // customer shipping details
            $data['ssl_ship_to_first_name'] = $card->getShippingFirstName();
            $data['ssl_ship_to_last_name'] = $card->getShippingLastName();
            $data['ssl_ship_to_company'] = $card->getShippingCompany();
            $data['ssl_ship_to_address1'] = $card->getShippingAddress1();
            $data['ssl_ship_to_address2'] = $card->getShippingAddress2();
            $data['ssl_ship_to_city'] = $card->getShippingCity();
            $data['ssl_ship_to_state'] = $card->getShippingState();
            $data['ssl_ship_to_zip'] = $card->getShippingPostcode();
            $data['ssl_ship_to_country'] = $card->getShippingCountry();
        }

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post($this->getEndpoint(), null, $data)->send();

        return $this->response = new Response($this, $httpResponse->getBody());
    }

    public function getEndpoint()
    {
        return $this->getDeveloperMode() ? $this->developerEndpoint : $this->liveEndpoint;
    }
}
