<?php

namespace Mi\VideoManagerPro\SDK\Common;

use Mi\Guzzle\ServiceBuilder\ServiceFactoryInterface;
use Mi\VideoManagerPro\SDK\Common\Subscriber\AccessTokenAuthentication;
use Mi\VideoManagerPro\SDK\Common\Subscriber\RefreshTokenData;
use Mi\VideoManagerPro\SDK\Common\Token\OAuth2Interface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ServiceFactory implements ServiceFactoryInterface
{
    private $baseServiceFactory;
    private $oAuth2Token;
    private $baseUrlPrefix;

    /**
     * @param ServiceFactoryInterface $baseServiceFactory
     * @param OAuth2Interface $oAuth2Token
     */
    public function __construct(
        ServiceFactoryInterface $baseServiceFactory,
        OAuth2Interface $oAuth2Token
    ) {
        $this->baseServiceFactory = $baseServiceFactory;
        $this->oAuth2Token = $oAuth2Token;
    }

    /**
     * {@inheritdoc}
     */
    public function factory($config)
    {
        $this->addPrefixToBaseUrl($config);

        $service = $this->baseServiceFactory->factory($config);
        $service->getEmitter()->attach(
            new AccessTokenAuthentication($service->getDescription(), $this->oAuth2Token->getAccessToken())
        );
        $service->getEmitter()->attach(
            new RefreshTokenData($service->getDescription(), $this->oAuth2Token->getRefreshToken())
        );

        return $service;
    }

    /**
     * @param string $prefix
     */
    public function setBaseUrlPrefix($prefix)
    {
        $this->baseUrlPrefix = $prefix;
    }

    /**
     * @param array $config
     */
    private function addPrefixToBaseUrl(array &$config)
    {
        if (!array_key_exists('baseUrl', $config['description'])) {
            return;
        }

        $config['description']['baseUrl'] = rtrim($this->baseUrlPrefix, '/') . $config['description']['baseUrl'];
    }
}
