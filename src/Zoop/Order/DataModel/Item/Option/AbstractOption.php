<?php

namespace Zoop\Order\DataModel\Item\Option;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow={"read", "create", "update::*", "delete"})
 * })
 */
abstract class AbstractOption
{
    /**
     *
     * @ODM\String
     */
    protected $label;

    /**
     *
     * @ODM\String
     */
    protected $value;

    /**
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
