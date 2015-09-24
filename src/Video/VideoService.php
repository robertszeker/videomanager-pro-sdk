<?php

namespace Mi\VideoManagerPro\SDK\Video;

use GuzzleHttp\Command\Guzzle\GuzzleClient;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class VideoService extends GuzzleClient
{
    /**
     * @param int $videoManagerId
     *
     * @return \Mi\VideoManagerPro\SDK\Model\VideoList
     */
    public function getAllVideos($videoManagerId)
    {
        return $this->execute($this->getCommand('list', ['videoManagerId' => $videoManagerId,'limit' => 99999999]));
    }

    /**
     * @param int $videoManagerId
     * @param int $videoId
     *
     * @return \Mi\VideoManagerPro\SDK\Model\Video
     */
    public function getVideo($videoManagerId, $videoId)
    {
        return $this->execute($this->getCommand('get', ['videoManagerId' => $videoManagerId,'videoId' => $videoId]));
    }
}
