<?php

namespace Mi\VideoManagerPro\SDK\Video;

use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Mi\VideoManagerPro\SDK\Model\VideoList;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class VideoService extends GuzzleClient
{
    /**
     * @param integer $videoManagerId
     *
     * @return VideoList
     */
    public function getAllVideos($videoManagerId)
    {
        return $this->execute($this->getCommand('list', ['videoManagerId' => $videoManagerId,'limit' => 99999999]));
    }
}
