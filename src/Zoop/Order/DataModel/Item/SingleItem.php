<?php

namespace Zoop\Order\DataModel\Item;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Order\DataModel\Item\Option\AbstractOption;
use Zoop\Order\DataModel\Item\AbstractSku;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 */
class SingleItem
{
    /**
     *
     * @ODM\String
     */
    protected $brand;

    /**
     *
     * @ODM\Collection
     */
    protected $suppliers;

    /**
     * @ODM\EmbedMany(
     *     strategy = "set",
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "dropdown" = "Zoop\Order\DataModel\Item\Option\Dropdown",
     *         "file"     = "Zoop\Order\DataModel\Item\Option\FileUpload",
     *         "radio"    = "Zoop\Order\DataModel\Item\Option\Radio",
     *         "text"     = "Zoop\Order\DataModel\Item\Option\Text"
     *     }
     * )
     */
    protected $options;

    /**
     * @ODM\EmbedOne(
     *     discriminatorField = "type",
     *     discriminatorMap = {
     *         "physical"  = "Zoop\Order\DataModel\Item\PhysicalSku",
     *         "digital"   = "Zoop\Order\DataModel\Item\DigitalSku"
     *     }
     * )
     */
    protected $sku;

    public function __construct()
    {
        $this->suppliers = new ArrayCollection();
    }

    /**
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     *
     * @param string $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     *
     * @return ArrayCollection
     */
    public function getSuppliers()
    {
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
     *
     * @return AbstractOption
     */
    public function getOptionsValues()
    {
        return $this->optionsValues;
    }

    /**
     *
     * @param AbstractOption $optionsValues
     */
    public function setOptionsValues(AbstractOption $optionsValues)
    {
        $this->optionsValues = $optionsValues;
    }

    /**
     *
     * @return AbstractSku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     *
     * @param AbstractSku $sku
     */
    public function setSku(AbstractSku $sku)
    {
        $this->sku = $sku;
    }
}
