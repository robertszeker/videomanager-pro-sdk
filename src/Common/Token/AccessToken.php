<?php

namespace Mi\VideoManagerPro\SDK\Common\Token;

/**
 * @author Steve Reichenbach <steve.reichenbach@movingimage.com>
 */
class AccessToken implements TokenInterface
{
    private $accessToken;

    /**
     * @param string $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->accessToken;
    }
}
