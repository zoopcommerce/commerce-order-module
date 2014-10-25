<?php

namespace Zoop\Order\DataModel\Item;

use Zoop\Order\DataModel\Item\PriceSetInterface;
use Zoop\Order\DataModel\Item\PriceInterface;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow={"read", "create", "update::*"}),
 *     @Shard\Permission\Basic(
 *          roles={
 *              "zoop::admin",
 *              "partner::admin",
 *              "company::admin",
 *              "store::admin"
 *          },
 *          allow="delete"
 *     )
 * })
 */
class PriceSet implements PriceSetInterface
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
     * @return PriceInterface
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     *
     * @return PriceInterface
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     *
     * @param PriceInterface $unit
     */
    public function setUnit(PriceInterface $unit)
    {
        $this->unit = $unit;
    }

    /**
     *
     * @param PriceInterface $total
     */
    public function setTotal(PriceInterface $total)
    {
        $this->total = $total;
    }
}
