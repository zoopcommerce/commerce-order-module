<?php

namespace Zoop\Order\DataModel;

use Zoop\Order\DataModel\CommissionInterface;
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
class Commission implements CommissionInterface
{
    /**
     *
     * @ODM\Float
     */
    protected $amount;

    /**
     *
     * @ODM\Float
     */
    protected $charged;

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = (float) $amount;
    }

    /**
     * @return float
     */
    public function getCharged()
    {
        return $this->charged;
    }

    /**
     * @param float $charged
     */
    public function setCharged($charged)
    {
        $this->charged = (float) $charged;
    }
}
