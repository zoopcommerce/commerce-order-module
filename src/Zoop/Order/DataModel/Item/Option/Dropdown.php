<?php

namespace Zoop\Order\DataModel\Item\Option;

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
class Dropdown extends AbstractOption implements OptionInterface
{

}
