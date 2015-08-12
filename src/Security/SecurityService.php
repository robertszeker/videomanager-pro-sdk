<?php

namespace Mi\VideoManagerPro\SDK\Security;

use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Mi\VideoManagerPro\SDK\Common\Token\SecurityTokens;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class SecurityService extends GuzzleClient
{
    /**
     * @param string $username
     * @param string $password
     *
     * @return SecurityTokens
     */
    public function login($username, $password)
    {
        return $this->execute($this->getCommand('login', ['username' => $username,'password' => $password]));
    }

    /**
     * @param int $videoManagerId
     *
     * @return SecurityTokens
     */
    public function refresh($videoManagerId)
    {
        return $this->execute(
            $this->getCommand('refresh', ['videoManagerId' => $videoManagerId])
        );
    }
}
