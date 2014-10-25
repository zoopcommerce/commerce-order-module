<?php

namespace Zoop\Order\DataModel\Item;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

trait PriceTrait
{
    /**
     * Wholesale price
     *
     * @ODM\Float
     */
    protected $wholesale;

    /**
     * List price
     *
     * @ODM\Float
     */
    protected $list;

    /**
     * Sale price
     *
     * @ODM\Float
     */
    protected $sale;

    /**
     * List - Discount
     *
     * @ODM\Float
     */
    protected $subTotal;

    /**
     * Tax included
     *
     * @ODM\Float
     */
    protected $taxIncluded;

    /**
     * Shipping cost
     *
     * @ODM\Float
     */
    protected $shipping;

    /**
     * Cart / order level discount
     *
     * @ODM\Float
     */
    protected $cartDiscount;

    /**
     * Shipping level discount
     *
     * @ODM\Float
     */
    protected $shippingDiscount;

    /**
     * Product level discount
     *
     * @ODM\Float
     */
    protected $productDiscount;

    /**
     * @return float
     */
    public function getWholesale()
    {
        return (float) $this->wholesale;
    }

    /**
     * @return float
     */
    public function getList()
    {
        return (float) $this->list;
    }

    /**
     * @return float
     */
    public function getSale()
    {
        return (float) $this->sale;
    }

    /**
     * @return float
     */
    public function getSubTotal()
    {
        return (float) $this->subTotal;
    }

    /**
     * @return float
     */
    public function getTaxIncluded()
    {
        return (float) $this->taxIncluded;
    }

    /**
     * @return float
     */
    public function getShipping()
    {
        return (float) $this->shipping;
    }

    /**
     * @return float
     */
    public function getCartDiscount()
    {
        return (float) $this->cartDiscount;
    }

    /**
     * @return float
     */
    public function getShippingDiscount()
    {
        return (float) $this->shippingDiscount;
    }

    /**
     * @return float
     */
    public function getProductDiscount()
    {
        return (float) $this->productDiscount;
    }

    /**
     *
     * @param type $wholesale
     */
    public function setWholesale($wholesale)
    {
        $this->wholesale = $wholesale;
    }

    /**
     *
     * @param type $list
     */
    public function setList($list)
    {
        $this->list = $list;
    }

    /**
     *
     * @param type $sale
     */
    public function setSale($sale)
    {
        $this->sale = $sale;
    }

    /**
     *
     * @param type $subTotal
     */
    public function setSubTotal($subTotal)
    {
        $this->subTotal = $subTotal;
    }


    /**
     *
     * @param type $taxIncluded
     */
    public function setTaxIncluded($taxIncluded)
    {
        $this->taxIncluded = $taxIncluded;
    }

    /**
     *
     * @param type $shipping
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     *
     * @param type $cartDiscount
     */
    public function setCartDiscount($cartDiscount)
    {
        $this->cartDiscount = $cartDiscount;
    }

    /**
     *
     * @param type $shippingDiscount
     */
    public function setShippingDiscount($shippingDiscount)
    {
        $this->shippingDiscount = $shippingDiscount;
    }

    /**
     *
     * @param type $productDiscount
     */
    public function setProductDiscount($productDiscount)
    {
        $this->productDiscount = $productDiscount;
    }
}
