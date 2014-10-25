<?php

namespace Zoop\Order\DataModel;

use Zoop\Order\DataModel\HistoryInterface;
use Zoop\Shard\Stamp\DataModel\CreatedOnTrait;
use Zoop\Shard\Stamp\DataModel\CreatedByTrait;
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
class History implements HistoryInterface
{
    use CreatedOnTrait;
    use CreatedByTrait;

    /**
     *
     * @ODM\String
     */
    protected $state;

    /**
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }
}
