<?php

namespace Zoop\Order\DataModel\Item;

use Zoop\Order\DataModel\Item\Price;
use Zoop\Product\DataModel\ImageSet;

interface ItemInterface
{
    public function getLegacyId();

    public function setLegacyId($legacyId);

    public function getName();

    public function setName($name);

    public function getImageSets();

    public function setImageSets(ArrayCollection $imageSets);

    public function addImageSet(ImageSet $imageSet);

    public function getPrice();

    public function setPrice(Price $price);

    public function getQuantity();

    public function setQuantity($quantity);
}
