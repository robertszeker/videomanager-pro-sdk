<?php

namespace Mi\VideoManagerPro\SDK\Model;

/**
 * @author Patman <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class ChannelTree
{
    private $id;
    private $name;
    private $children;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ChannelTree[]
     */
    public function getChildren()
    {
        return $this->children;
    }
}
