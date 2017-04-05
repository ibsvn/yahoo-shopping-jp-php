<?php

namespace Shippinno\YahooShoppingJp\Request;

use DateTimeZone;
use InvalidArgumentException;
use LogicException;
use Shippinno\YahooShoppingJp\Enum\ShipStatus;
use Shippinno\YahooShoppingJp\Exception\InvalidRequestException;

class UpdateOrderShippingStatusRequest extends AbstractRequest
{
    private $params = [];

    public function __construct()
    {
    }

    /**
     * @param string $sellerId
     * @return self
     */
    public function setSellerId(string $sellerId): self
    {
        if (isset($this->params['SellerId'])) {
            throw new LogicException('SellerId is already set.');
        }

        $this->params['SellerId'] = $sellerId;

        return $this;
    }

    /**
     * @param string $orderId
     * @return self
     */
    public function setOrderId(string $orderId): self
    {
        if (isset($this->params['Target']['OrderId'])) {
            throw new LogicException('OrderId is already set.');
        }

        $this->params['Target']['OrderId'] = $orderId;

        return $this;
    }

    /**
     * @param bool $isPointFix
     * @return self
     */
    public function setIsPointFix(bool $isPointFix): self
    {
        if (isset($this->params['Target']['IsPointFix'])) {
            throw new LogicException('IsPointFix is already set.');
        }

        $this->params['Target']['IsPointFix'] = $isPointFix ? 'true' : 'false';

        return $this;
    }

    /**
     * @param string $operationUser
     * @return self
     */
    public function setOperationUser(string $operationUser): self
    {
        if (isset($this->params['Target']['OperationUser'])) {
            throw new LogicException('OperationUser is already set.');
        }

        $this->params['Target']['OperationUser'] = $operationUser;

        return $this;
    }

    /**
     * @param ShipStatus $shipStatus
     * @return self
     */
    public function setShipStatus(ShipStatus $shipStatus): self
    {
        if (isset($this->params['Ship']['ShipStatus'])) {
            throw new LogicException('ShipStatus is already set.');
        }

        $this->params['Ship']['ShipStatus'] = $shipStatus->getValue();

        return $this;
    }

    /**
     * @param string $shipMethod
     * @return self
     */
    public function setShipMethod(string $shipMethod): self
    {
        if (isset($this->params['Ship']['ShipMethod'])) {
            throw new LogicException('ShipMethod is already set.');
        }

        if(!preg_match('/^postage(\d+)$/',$shipMethod,$m)
            || !in_array($m[1],['1','2','3','4','5','6','7','8',
                '9','10','11','12','13','14','16'])){
            throw new InvalidArgumentException('ShipMethod is invalid.');
        }

        $this->params['Ship']['ShipMethod'] = $shipMethod;

        return $this;
    }

    /**
     * @param string $shipNotes
     * @return self
     */
    public function setShipNotes(string $shipNotes): self
    {
        if (isset($this->params['Ship']['ShipNotes'])) {
            throw new LogicException('ShipNotes is already set.');
        }

        if(strlen($shipNotes) > 500){
            throw new InvalidArgumentException('ShipNotes is invalid.');
        }

        $this->params['Ship']['ShipNotes'] = $shipNotes;

        return $this;
    }

    /**
     * @param string $shipInvoiceNumber1
     * @return self
     */
    public function setShipInvoiceNumber1(string $shipInvoiceNumber1): self
    {
        if (isset($this->params['Ship']['ShipInvoiceNumber1'])) {
            throw new LogicException('ShipInvoiceNumber1 is already set.');
        }

        $this->params['Ship']['ShipInvoiceNumber1'] = $shipInvoiceNumber1;

        return $this;
    }

    /**
     * @param string $shipInvoiceNumber2
     * @return self
     */
    public function setShipInvoiceNumber2(string $shipInvoiceNumber2): self
    {
        if (isset($this->params['Ship']['ShipInvoiceNumber2'])) {
            throw new LogicException('ShipInvoiceNumber2 is already set.');
        }

        $this->params['Ship']['ShipInvoiceNumber2'] = $shipInvoiceNumber2;

        return $this;
    }

    /**
     * @param string $shipUrl
     * @return self
     */
    public function setShipUrl(string $shipUrl): self
    {
        if (isset($this->params['Ship']['ShipUrl'])) {
            throw new LogicException('ShipUrl is already set.');
        }

        $this->params['Ship']['ShipUrl'] = '![CDATA['.$shipUrl.']]';

        return $this;
    }

    /**
     * @param \DateTimeImmutable $shipDate
     * @return self
     */
    public function setShipDate(\DateTimeImmutable $shipDate): self
    {
        if (isset($this->params['Ship']['ShipDate'])) {
            throw new LogicException('ShipDate is already set.');
        }

        $this->params['Ship']['ShipDate'] = $shipDate
                                                ->setTimeZone(new DateTimeZone('Asia/Tokyo'))
                                                ->format('Ymd');

        return $this;
    }

    /**
     * @param \DateTimeImmutable $arrivalDate
     * @return self
     */
    public function setArrivalDate(\DateTimeImmutable $arrivalDate): self
    {
        if (isset($this->params['Ship']['ArrivalDate'])) {
            throw new LogicException('ArrivalDate is already set.');
        }

        $this->params['Ship']['ArrivalDate'] = $arrivalDate
                                                    ->setTimeZone(new DateTimeZone('Asia/Tokyo'))
                                                    ->format('Ymd');

        return $this;
    }

    /**
     * getParams
     * @return array
     */
    public function getParams(): array
    {
        $this->validateRequest();

        return $this->params;
    }

    /**
     * @throws InvalidRequestException
     */
    private function validateRequest(): void
    {
        $requiredParams = [
            'SellerId'=>'',
            'OrderId'=>'Target',
            'IsPointFix'=>'Target',
            'ShipStatus'=>'Ship'];

        foreach ($requiredParams as $key => $dir){
            if($dir === '') {
                if (!isset($this->params[$key])) {
                    throw new InvalidRequestException($key . ' is required.');
                }
            }else{
                if (!isset($this->params[$dir][$key])) {
                    throw new InvalidRequestException($key . ' is required.');
                }
            }
        }

    }
}