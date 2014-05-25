<?php

namespace Zoop\Order\DataModel\Item;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Order\DataModel\Item\AbstractSku;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class SingleItem extends AbstractItem
{
    /**
     * @ODM\EmbedOne(targetDocument="Zoop\Order\DataModel\Item\AbstractSku")
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
