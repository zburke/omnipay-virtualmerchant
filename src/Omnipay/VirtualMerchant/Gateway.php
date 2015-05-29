<?php

namespace Omnipay\VirtualMerchant;

use Omnipay\VirtualMerchant\Message\AuthorizeRequest;
use Omnipay\VirtualMerchant\Message\PurchaseRequest;
use Omnipay\VirtualMerchant\Message\CaptureRequest;
use Omnipay\Common\AbstractGateway;

/**
 * Elavon VirtualMerchant  Class
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'VirtualMerchant';
    }

    public function getDefaultParameters()
    {
        return array(
            'vmMerchantId' => '',
            'vmUserId' => '',
            'vmPin' => '',
            'developerMode' => false,
        );
    }

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

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\VirtualMerchant\Message\AuthorizeRequest', $parameters);
    }
    
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\VirtualMerchant\Message\CaptureRequest', $parameters);
    }
    
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\VirtualMerchant\Message\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\VirtualMerchant\Message\RefundRequest', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\VirtualMerchant\Message\VoidRequest', $parameters);
    }
}
