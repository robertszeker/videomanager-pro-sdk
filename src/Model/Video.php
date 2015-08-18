<?php

namespace Mi\VideoManagerPro\SDK\Model;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class Video
{
    private $id;
    private $title;
    private $thumbnail;
    private $description;
    private $createdDate;
    private $uploadDate;
    private $length;
    private $replacementCount;
    private $customMetadata;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * schema relative thumbnail url
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @return \DateTime
     */
    public function getUploadDate()
    {
        return $this->uploadDate;
    }

    /**
     * video length in seconds
     *
     * @return integer
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * count how often the source file was replaced
     *
     * @return integer
     */
    public function getReplacementCount()
    {
        return $this->replacementCount;
    }

    /**
     * @return array
     */
    public function getCustomMetadata()
    {
        return $this->customMetadata;
    }
}
