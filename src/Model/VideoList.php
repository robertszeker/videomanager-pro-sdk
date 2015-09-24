<?php

namespace Mi\VideoManagerPro\SDK\Model;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class VideoList
{
    private $total;
    private $videos;

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return Video[]
     */
    public function getVideos()
    {
        return $this->videos;
    }
}
