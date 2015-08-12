<?php

namespace Mi\VideoManagerPro\SDK\Common\Token;

/**
 * @author Steve Reichenbach <steve.reichenbach@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class SecurityTokens implements SecurityTokensInterface
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
