<?php

namespace Zoop\Order\DataModel\Item;

use Zoop\Common\File\DataModel\FileInterface;
use Zoop\Order\DataModel\Item\DigitalSkuInterface;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow={"read", "create", "update::*", "delete"})
 * })
 */
class DigitalSku extends AbstractSku implements DigitalSkuInterface
{
    /**
     * @ODM\ReferenceOne(targetDocument="Zoop\Common\File\DataModel\File")
     */
    protected $file;

    /**
     *
     * @ODM\String
     * @ODM\Index(unique=true)
     * @Shard\Validator\Chain({
     *     @Shard\Validator\Required,
     *     @Shard\Validator\Slug
     * })
     */
    protected $slug;

    /**
     *
     * @ODM\Int
     */
    protected $numberOfDownloads = 0;

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     *
     * @return integer
     */
    public function getNumberOfDownloads()
    {
        return $this->numberOfDownloads;
    }

    /**
     *
     * @param integer $numberOfDownloads
     */
    public function setNumberOfDownloads($numberOfDownloads)
    {
        $this->numberOfDownloads = (int) $numberOfDownloads;
    }

    /**
     * Increases the download count
     */
    public function incrementNumberOfDownloads()
    {
        $this->numberOfDownloads++;
    }

    /**
     * Decreases the download count
     */
    public function decrementNumberOfDownloads()
    {
        if ($this->numberOfDownloads > 0) {
            $this->numberOfDownloads--;
        }
    }

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
