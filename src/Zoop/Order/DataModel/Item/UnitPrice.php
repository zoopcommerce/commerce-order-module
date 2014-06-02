<?php

namespace Zoop\Order\DataModel\Item;

use Zoop\Order\DataModel\Item\PriceTrait;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class UnitPrice
{
    use PriceTrait;
}
