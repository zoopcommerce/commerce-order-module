<?php

namespace Zoop\Order\DataModel\Item;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Order\DataModel\Item\Option\OptionInterface;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow={"read", "create", "update::*", "delete"})
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
     * @return array
     */
    public function getOptions()
    {
        if (!isset($this->options)) {
            $this->options = new ArrayCollection;
        }
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        if (is_array($options)) {
            $this->options = new ArrayCollection($options);
        } else {
            $this->options = $options;
        }
    }

    /**
     * @param OptionInterface $option
     */
    public function addOption(OptionInterface $option)
    {
        if (!$this->getOptions()->contains($option)) {
            $this->getOptions()->add($option);
        }
    }

    /**
     *
     * @return array
     */
    public function getSuppliers()
    {
        if (!isset($this->suppliers)) {
            $this->suppliers = new ArrayCollection;
        }
        return $this->suppliers;
    }

    /**
     *
     * @param array $suppliers
     */
    public function setSuppliers($suppliers)
    {
        if (is_array($suppliers)) {
            $this->suppliers = new ArrayCollection($suppliers);
        } else {
            $this->suppliers = $suppliers;
        }
    }

    /**
     * @param string $supplier
     */
    public function addSupplier($supplier)
    {
        if (!$this->getSuppliers()->contains($supplier)) {
            $this->getSuppliers()->add($supplier);
        }
    }
}
