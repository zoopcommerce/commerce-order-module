<?php

namespace Zoop\Order\DataModel\Item;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="read"),
 *     @Shard\Permission\Basic(roles="store-manager", allow="*")
 * })
 */
class Price
{
    /**
     * @ODM\Float
     */
    protected $wholesale;

    /**
     * @ODM\Float
     */
    protected $list;

    /**
     *
     * @ODM\Float
     */
    protected $subTotal;

    /**
     *
     * @ODM\Float
     */
    protected $discount;

    /**
     *
     * @ODM\Float
     */
    protected $total;

    /**
     *
     * @ODM\Float
     */
    protected $taxIncluded;

    /**
     *
     * @ODM\Float
     */
    protected $shipping;

    /**
     *
     * @return float
     */
    public function getWholesale()
    {
        return $this->wholesale;
    }

    /**
     *
     * @param float $wholesale
     */
    public function setWholesale($wholesale)
    {
        $this->wholesale = (float) $wholesale;
    }

    /**
     *
     * @return float
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     *
     * @param float $list
     */
    public function setList($list)
    {
        $this->list = (float) $list;
    }

    /**
     *
     * @return float
     */
    public function getSubTotal()
    {
        return $this->subTotal;
    }

    /**
     *
     * @param float $subTotal
     */
    public function setSubTotal($subTotal)
    {
        $this->subTotal = (float) $subTotal;
    }

    /**
     *
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     *
     * @param float $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = (float) $discount;
    }

    /**
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     *
     * @param float $total
     */
    public function setTotal($total)
    {
        $this->total = (float) $total;
    }

    /**
     *
     * @return float
     */
    public function getTaxIncluded()
    {
        return $this->taxIncluded;
    }

    /**
     *
     * @param float $taxIncluded
     */
    public function setTaxIncluded($taxIncluded)
    {
        $this->taxIncluded = (float) $taxIncluded;
    }

    /**
     *
     * @return float
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     *
     * @param float $shipping
     */
    public function setShipping($shipping)
    {
        $this->shipping = (float) $shipping;
    }
}
