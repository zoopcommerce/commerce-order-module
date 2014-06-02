<?php

namespace Zoop\Order\DataModel\Item;

use Zoop\Order\DataModel\Item\UnitPrice;
use Zoop\Order\DataModel\Item\TotalPrice;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class Price
{
    /**
     *
     * @ODM\EmbedOne(targetDocument="Zoop\Order\DataModel\Item\UnitPrice")
     */
    protected $unit;

    /**
     *
     * @ODM\EmbedOne(targetDocument="Zoop\Order\DataModel\Item\TotalPrice")
     */
    protected $total;

    /**
     * 
     * @return UnitPrice
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * 
     * @return TotalPrice
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * 
     * @param UnitPrice $unit
     */
    public function setUnit(UnitPrice $unit)
    {
        $this->unit = $unit;
    }

    /**
     * 
     * @param TotalPrice $total
     */
    public function setTotal(TotalPrice $total)
    {
        $this->total = $total;
    }
}
