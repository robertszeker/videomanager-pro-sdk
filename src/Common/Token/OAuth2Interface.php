<?php

namespace Mi\VideoManagerPro\SDK\Common\Token;

/**
 * @author Steve Reichenbach <steve.reichenbach@movingimage.com>
 *
 * @codeCoverageIgnore
 */
interface OAuth2Interface
{
    /**
     * @return string
     */
    public function getAccessToken();

    /**
     * @return string
     */
    public function getRefreshToken();
}
