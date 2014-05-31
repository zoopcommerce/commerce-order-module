<?php

namespace Zoop\Order\DataModel\Item;

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
     * @ODM\EmbedOne(targetDocument="Zoop\Product\DataModel\Dimensions")
     */
    protected $dimensions;

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
