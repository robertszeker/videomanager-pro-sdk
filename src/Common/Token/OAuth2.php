<?php

namespace Mi\VideoManagerPro\SDK\Common\Token;

/**
 * @author Steve Reichenbach <steve.reichenbach@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class OAuth2 implements OAuth2Interface
{
    private $accessToken;
    private $refreshToken;

    /**
     * @inheritdoc
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @inheritdoc
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }
}
