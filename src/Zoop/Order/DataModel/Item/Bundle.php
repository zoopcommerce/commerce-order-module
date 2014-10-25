<?php

namespace Zoop\Order\DataModel\Item;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Order\DataModel\Item\ItemInterface;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow={"read", "create", "update::*", "delete"})
 * })
 */
class Bundle extends AbstractItem implements ItemInterface
{
    /**
     *
     * @ODM\EmbedMany(targetDocument="Zoop\Order\DataModel\Item\AbstractItem")
     */
    protected $items;

    /**
     * @param ItemInterface $item
     */
    public function addItem(ItemInterface $item)
    {
        if (!$this->getItems()->contains($item)) {
            $this->getItems()->add($item);
        }
    }

    /**
     * @return array
     */
    public function getItems()
    {
        if (!isset($this->items)) {
            $this->items = new ArrayCollection();
        }
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems($items)
    {
        if (is_array($items)) {
            $this->items = new ArrayCollection($items);
        } else {
            $this->items = $items;
        }
    }
}
