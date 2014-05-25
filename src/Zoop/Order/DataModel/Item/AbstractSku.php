<?php

namespace Zoop\Order\DataModel\Item;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Inventory\DataModel\AbstractInventory;
use Zoop\Order\DataModel\Item\Option\AbstractOption;

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
     *
     * @ODM\Int
     */
    protected $legacyId;

    /**
     *
     * @ODM\Collection
     */
    protected $suppliers;

    /**
     * @ODM\ReferenceOne(
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
     * @ODM\EmbedMany(targetDocument="Zoop\Order\DataModel\Item\Option\AbstractOption")
     */
    protected $options;
    
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

    /**
     * @return ArrayCollection
     */
    public function getOptions()
    {
        if(!$this->options instanceof ArrayCollection) {
            $this->options = new ArrayCollection;
        }
        return $this->options;
    }

    /**
     * @param ArrayCollection $options
     */
    public function setOptions(ArrayCollection $options)
    {
        $this->options = $options;
    }

    /**
     * @param AbstractOption $options
     */
    public function addOption(AbstractOption $option)
    {
        $this->getOptions()->add($option);
    }
    
    /**
     *
     * @return ArrayCollection
     */
    public function getSuppliers()
    {
        if(!$this->suppliers instanceof ArrayCollection) {
            $this->suppliers = new ArrayCollection;
        }
        return $this->suppliers;
    }

    /**
     *
     * @param ArrayCollection $suppliers
     */
    public function setSuppliers(ArrayCollection $suppliers)
    {
        $this->suppliers = $suppliers;
    }

    /**
     * @param string $supplier
     */
    public function addSupplier($supplier)
    {
        $this->getSuppliers()->add($supplier);
    }

    /**
     *
     * @return int
     */
    public function getLegacyId()
    {
        return $this->legacyId;
    }

    /**
     *
     * @param int $legacyId
     */
    public function setLegacyId($legacyId)
    {
        $this->legacyId = (int) $legacyId;
    }
}
