<?php

namespace Zoop\Order\DataModel\Item;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ODM\Int
     */
    protected $legacyId;

    /**
     * @ODM\Collection
     */
    protected $suppliers;


    /**
     * @ODM\EmbedMany(
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "Dropdown"       = "Zoop\Order\DataModel\Item\Option\Dropdown",
     *         "FileUpload"     = "Zoop\Order\DataModel\Item\Option\FileUpload",
     *         "Radio"          = "Zoop\Order\DataModel\Item\Option\Radio",
     *         "Text"           = "Zoop\Order\DataModel\Item\Option\Text"
     *     }
     * )
     */
    protected $options;
    
    /**
     * @return ArrayCollection
     */
    public function getOptions()
    {
        if(!isset($this->options)) {
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
        if(!isset($this->suppliers)) {
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
