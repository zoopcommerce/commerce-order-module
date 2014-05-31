<?php

namespace Zoop\Order\DataModel\Item;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Order\DataModel\Item\Price;
use Zoop\Product\DataModel\ImageSet;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
abstract class AbstractItem
{
    /**
     * @ODM\Int
     */
    protected $legacyId;
    
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
     * @ODM\EmbedOne(targetDocument="Zoop\Order\DataModel\Item\Price")
     */
    protected $price;

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

    public function __construct()
    {
        $this->imageSets = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getLegacyId()
    {
        return $this->legacyId;
    }

    /**
     * @param int $legacyId
     */
    public function setLegacyId($legacyId)
    {
        $this->legacyId = (int) $legacyId;
    }

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
     * @return ArrayCollection
     */
    public function getImageSets()
    {
        return $this->imageSets;
    }

    /**
     * @param ArrayCollection $imageSets
     */
    public function setImageSets(ArrayCollection $imageSets)
    {
        $this->imageSets = $imageSets;
    }

    /**
     * @param ImageSet $imageSet
     */
    public function addImageSet(ImageSet $imageSet)
    {
        $this->imageSets->add($imageSet);
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param Price $price
     */
    public function setPrice(Price $price)
    {
        $this->price = $price;
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
