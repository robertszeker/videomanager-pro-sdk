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
     * @param int   $videoManagerId
     * @param int   $offset
     * @param int   $limit
     * @param array $optionalParameter
     *
     * @return \Mi\VideoManagerPro\SDK\Model\VideoList
     */
    public function getVideoList($videoManagerId, $offset = 0, $limit = 99999999, array $optionalParameter = [])
    {
        $parameters = array_merge(
            $optionalParameter,
            ['videoManagerId' => $videoManagerId, 'offset' => $offset, 'limit' => $limit]
        );

        return $this->execute($this->getCommand('list', $parameters));
    }

    /**
     * @param int $videoManagerId
     * @param int $videoId
     *
     * @return \Mi\VideoManagerPro\SDK\Model\Video
     */
    public function getVideo($videoManagerId, $videoId)
    {
        return $this->execute($this->getCommand('get', ['videoManagerId' => $videoManagerId, 'videoId' => $videoId]));
    }
}
