<?php

namespace Zoop\Order\DataModel\Item;

use Zoop\Order\DataModel\Item\SkuInterface;
use Zoop\Order\DataModel\Item\ItemInterface;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow={"read", "create", "update::*", "delete"})
 * })
 */
class SingleItem extends AbstractItem implements ItemInterface
{
    /**
     * @ODM\EmbedOne(
     *      discriminatorField="type",
     *      discriminatorMap={
     *         "PhysicalSku"    = "Zoop\Order\DataModel\Item\PhysicalSku",
     *         "DigitalSku"     = "Zoop\Order\DataModel\Item\DigitalSku"
     *      }
     * )
     */
    protected $sku;

    /**
     * @return SkuInterface
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param SkuInterface $sku
     */
    public function setSku(SkuInterface $sku)
    {
        $this->sku = $sku;
    }
}
