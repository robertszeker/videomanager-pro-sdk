<?php

namespace Mi\VideoManagerPro\SDK\Security;

use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Mi\VideoManagerPro\SDK\Model\Login;
use Mi\VideoManagerPro\SDK\Model\OAuth2;

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
     * @return Login
     */
    public function login($username, $password)
    {
        return $this->execute($this->getCommand('login', ['username' => $username,'password' => $password]));
    }

    /**
     * @param int $videoManagerId
     *
     * @return OAuth2
     */
    public function refresh($videoManagerId)
    {
        return $this->execute(
            $this->getCommand('refresh', ['videoManagerId' => $videoManagerId])
        );
    }
}
