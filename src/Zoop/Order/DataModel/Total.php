<?php

namespace Zoop\Order\DataModel;

use Zoop\Common\DataModel\Currency;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class Total
{
    /**
     *
     * @ODM\Float
     */
    protected $shippingPrice;

    /**
     *
     * @ODM\Float
     */
    protected $productPrice;

    /**
     *
     * @ODM\Int
     */
    protected $productQuantity;

    /**
     *
     * @ODM\Float
     */
    protected $discountPrice;

    /**
     *
     * @ODM\Float
     */
    protected $taxPrice;

    /**
     *
     * @ODM\Float
     */
    protected $orderPrice;

    /**
     *
     * @ODM\EmbedOne(targetDocument="Zoop\Common\DataModel\Currency")
     */
    protected $currency;

    /**
     *
     * @return float
     */
    public function getShippingPrice()
    {
        return $this->shippingPrice;
    }

    /**
     *
     * @param float $shippingPrice
     */
    public function setShippingPrice($shippingPrice)
    {
        $this->shippingPrice = (float) $shippingPrice;
    }

    /**
     *
     * @return float
     */
    public function getProductPrice()
    {
        return $this->productPrice;
    }

    /**
     *
     * @param float $productPrice
     */
    public function setProductPrice($productPrice)
    {
        $this->productPrice = (float) $productPrice;
    }

    /**
     *
     * @return integer
     */
    public function getProductQuantity()
    {
        return $this->productQuantity;
    }

    /**
     *
     * @param integer $productQuantity
     */
    public function setProductQuantity($productQuantity)
    {
        $this->productQuantity = (int) $productQuantity;
    }

    /**
     *
     * @return float
     */
    public function getDiscountPrice()
    {
        return $this->discountPrice;
    }

    /**
     *
     * @param float $discountPrice
     */
    public function setDiscountPrice($discountPrice)
    {
        $this->discountPrice = (float) $discountPrice;
    }

    /**
     *
     * @return float
     */
    public function getTaxPrice()
    {
        return $this->taxPrice;
    }

    /**
     *
     * @param float $taxPrice
     */
    public function setTaxPrice($taxPrice)
    {
        $this->taxPrice = (float) $taxPrice;
    }

    /**
     *
     * @return float
     */
    public function getOrderPrice()
    {
        return $this->orderPrice;
    }

    /**
     *
     * @param float $orderPrice
     */
    public function setOrderPrice($orderPrice)
    {
        $this->orderPrice = (float) $orderPrice;
    }

    /**
     *
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     *
     * @param Currency $currency
     */
    public function setCurrency(Currency $currency)
    {
        $this->currency = $currency;
    }
}
