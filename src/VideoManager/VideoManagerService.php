<?php

namespace Mi\VideoManagerPro\SDK\Security;

use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Mi\VideoManagerPro\SDK\Model\VideoManager;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class VideoManagerService extends GuzzleClient
{
    /**
     * @return VideoManager[]
     */
    public function getVideoManagerList()
    {
        return $this->execute($this->getCommand('getVideoManagerList'));
    }
}
