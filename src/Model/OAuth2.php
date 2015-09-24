<?php

namespace Mi\VideoManagerPro\SDK\Model;

use Mi\VideoManagerPro\SDK\Common\Token\OAuth2Interface;

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
     * @param $accessToken
     * @param $refreshToken
     */
    public function __construct($accessToken, $refreshToken)
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }
}
