<?php

namespace Zoop\Order\DataModel\Item\Option;

use Zoop\Common\File\DataModel\FileInterface;
use Zoop\Order\DataModel\Item\Option\FileUploadInterface;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow={"read", "create", "update::*", "delete"})
 * })
 */
class FileUpload extends AbstractOption implements FileUploadInterface
{
    /**
     *
     * @ODM\ReferenceOne(targetDocument="Zoop\Common\File\DataModel\File")
     */
    protected $file;

    /**
     *
     * @return FileInterface
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     *
     * @param FileInterface $file
     */
    public function setFile(FileInterface $file)
    {
        $this->file = $file;
    }
}
