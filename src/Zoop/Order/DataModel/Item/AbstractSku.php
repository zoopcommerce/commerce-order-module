<?php

namespace Zoop\Order\DataModel\Item;

use Zoop\Inventory\DataModel\AbstractInventory;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
abstract class AbstractSku
{
    /**
     * @ODM\String
     *
     */
    protected $id;

    /**
     * @ODM\ReferenceMany(
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "discrete"    = "Zoop\Inventory\DataModel\DiscreteInventory",
     *         "infinite"    = "Zoop\Inventory\DataModel\InfiniteInventory"
     *     },
     *     mappedBy="order"
     * )
     */
    protected $inventory;

    /**
     * @return array
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * @param array $inventory
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * @param AbstractInventory $inventory
     */
    public function addInventory(AbstractInventory $inventory)
    {
        $this->inventory->add($inventory);
    }
}
