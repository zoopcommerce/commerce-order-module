<?php

namespace Zoop\Order\DataModel\Item;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Product\DataModel\Shipping;
use Zoop\Product\DataModel\Dimensions;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class PhysicalSku extends AbstractSku
{
    /**
     *
     * @ODM\EmbedOne(targetDocument="Zoop\Product\DataModel\Shipping")
     */
    protected $shipping;

    /**
     * @ODM\EmbedOne(targetDocument="Zoop\Product\DataModel\Dimensions")
     */
    protected $dimensions;

    public function __construct()
    {
        $this->suppliers = new ArrayCollection();
    }

    /**
     * @return Shipping
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param Shipping $shipping
     */
    public function setShipping(Shipping $shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * @return Dimensions
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * @param Dimensions $dimensions
     */
    public function setDimensions(Dimensions $dimensions)
    {
        $this->dimensions = $dimensions;
    }
}
