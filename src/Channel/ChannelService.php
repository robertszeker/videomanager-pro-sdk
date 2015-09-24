<?php

namespace Mi\VideoManagerPro\SDK\Channel;

use GuzzleHttp\Command\Guzzle\GuzzleClient;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class ChannelService extends GuzzleClient
{
    /**
     * @param int $videoManagerId
     *
     * @return \Mi\VideoManagerPro\SDK\Model\ChannelTree
     */
    public function getAllChannels($videoManagerId)
    {
        return $this->execute($this->getCommand('list', ['videoManagerId' => $videoManagerId]));
    }
}
