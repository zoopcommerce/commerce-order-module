<?php

namespace Zoop\Order\DataModel\Item;

use Zoop\Order\DataModel\Item\AbstractSku;
use Zoop\Order\DataModel\Item\ItemInterface;
use Zoop\Order\DataModel\Item\PhysicalSku;
use Zoop\Order\DataModel\Item\DigitalSku;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
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
     * @return AbstractSku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param AbstractSku $sku
     */
    public function setSku(AbstractSku $sku)
    {
        $this->sku = $sku;
    }
}
