<?php

namespace Mi\VideoManagerPro\SDK\Common\Token;

/**
 * @author Steve Reichenbach <steve.reichenbach@movingimage.com>
 *
 * @codeCoverageIgnore
 */
interface SecurityTokensInterface
{
    /**
     * @return AccessToken
     */
    public function getAccessToken();

    /**
     * @return RefreshToken
     */
    public function getRefreshToken();
}
