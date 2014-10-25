<?php

namespace Zoop\Order\DataModel\Item;

use Zoop\Order\DataModel\Item\PriceTrait;
use Zoop\Order\DataModel\Item\PriceInterface;
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
class TotalPrice implements PriceInterface
{
    use PriceTrait;
}
