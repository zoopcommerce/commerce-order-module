<?php

namespace Zoop\Order\DataModel\Item;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Order\DataModel\Item\PriceSetInterface;
use Zoop\Product\DataModel\ImageSetInterface;
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
abstract class AbstractItem
{
    /**
     * @ODM\String
     */
    protected $brand;

    /**
     * @ODM\String
     * @Shard\Validator\Required
     */
    protected $name;

    /**
     * @ODM\EmbedMany(targetDocument="Zoop\Product\DataModel\ImageSet")
     */
    protected $imageSets;

    /**
     * @ODM\EmbedOne(targetDocument="Zoop\Order\DataModel\Item\PriceSet")
     */
    protected $priceSet;

    /**
     * @ODM\String
     * @Shard\State({
     *     "active",
     *     "in-active",
     *     "refunded"
     * })
     */
    protected $state;

    /**
     * @ODM\Int
     */
    protected $quantity;

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getImageSets()
    {
        if (!isset($this->imageSets)) {
            $this->imageSets = new ArrayCollection;
        }
        return $this->imageSets;
    }

    /**
     * @param array $imageSets
     */
    public function setImageSets($imageSets)
    {
        if (is_array($imageSets)) {
            $this->imageSets = new ArrayCollection($imageSets);
        }
        $this->imageSets = $imageSets;
    }

    /**
     * @param ImageSet $imageSet
     */
    public function addImageSet(ImageSetInterface $imageSet)
    {
        if (!$this->getImageSets()->contains($imageSet)) {
            $this->getImageSets()->add($imageSet);
        }
    }

    /**
     * @return Price
     */
    public function getPriceSet()
    {
        return $this->priceSet;
    }

    /**
     * @param Price $price
     */
    public function setPriceSet(PriceSetInterface $priceSet)
    {
        $this->priceSet = $priceSet;
    }

    /**
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }
}
