<?php

namespace Zoop\Order\DataModel\Item\Option;

use Zoop\Common\DataModel\File;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class FileUpload extends AbstractOption
{
    /**
     *
     * @ODM\ReferenceOne(targetDocument="Zoop\Common\DataModel\File")
     */
    protected $file;

    /**
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     *
     * @param File $file
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }
}
