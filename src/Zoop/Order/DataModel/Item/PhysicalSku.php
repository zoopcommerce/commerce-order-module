<?php

namespace Zoop\Order\DataModel\Item;

use Zoop\Product\DataModel\DimensionsInterface;
use Zoop\Order\DataModel\Item\PhysicalSkuInterface;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow={"read", "create", "update::*", "delete"})
 * })
 */
class PhysicalSku extends AbstractSku implements PhysicalSkuInterface
{
    /**
     * @ODM\EmbedOne(targetDocument="Zoop\Product\DataModel\Dimensions")
     */
    protected $dimensions;

    /**
     * @return DimensionsInterface
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * @param DimensionsInterface $dimensions
     */
    public function setDimensions(DimensionsInterface $dimensions)
    {
        $this->dimensions = $dimensions;
    }
}
