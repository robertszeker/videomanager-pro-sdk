<?php

namespace Mi\VideoManagerPro\SDK\Response\Security;

use Mi\VideoManagerPro\SDK\Common\Token\OAuth2;

/**
 * @author Steve Reichenbach <steve.reichenbach@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class Login
{
    private $accessToken;
    private $refreshToken;
    private $videoManagerList;
    private $validForVideoManager;

    /**
     * @return OAuth2
     */
    public function getOAuth2Token()
    {
        return new OAuth2($this->accessToken, $this->refreshToken);
    }

    /**
     * @return VideoManager[]
     */
    public function getVideoManagerList()
    {
        return $this->videoManagerList;
    }

    /**
     * @return int
     */
    public function getValidForVideoManager()
    {
        return $this->validForVideoManager;
    }
}
