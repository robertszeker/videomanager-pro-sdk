<?php

namespace Mi\VideoManagerPro\SDK\Common\Token;

/**
 * @author Steve Reichenbach <steve.reichenbach@movingimage.com>
 */
class RefreshToken implements TokenInterface
{
    private $refreshToken;

    /**
     * @param string $refreshToken
     */
    public function __construct($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->refreshToken;
    }
}
