<?php

namespace Mi\VideoManagerPro\SDK\tests;

use GuzzleHttp\Client;
use JMS\Serializer\Builder\CallbackDriverFactory;
use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\Metadata\Driver\XmlDriver;
use JMS\Serializer\SerializerBuilder;
use Mi\Guzzle\ServiceBuilder\Loader\JsonLoader;
use Mi\Guzzle\ServiceBuilder\ServiceBuilder;
use Mi\Guzzle\ServiceBuilder\ServiceFactory as BaseServiceFactory;
use Mi\Puli\Metadata\Driver\PuliFileLocator;
use Mi\VideoManagerPro\SDK\Common\ServiceFactory;
use Mi\VideoManagerPro\SDK\Common\Token\OAuth2Interface;
use Mi\VideoManagerPro\SDK\Model\OAuth2;
use Mi\VideoManagerPro\SDK\Security\SecurityService;
use Mi\VideoManagerPro\SDK\Video\Serializer\FormatTimestampListener;
use Mi\VideoManagerPro\SDK\Video\VideoService;
use Puli\Repository\PathMappingRepository;
use Puli\Repository\Resource\DirectoryResource;
use Webmozart\KeyValueStore\ArrayStore;

/**
 * @author Steve Reichenbach <steve.reichenbach@movingimage.com>
 */
class POCTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        self::markTestSkipped('test is only for poc');

        $oAuth2Token = new OAuth2('', '');

        /** @var SecurityService $service */
        $service = $this->getServiceBuilder($oAuth2Token)->get('security');
        $response = $service->login('username', 'password');
        //$response = $service->refresh(21);

        /** @var VideoService $service */
        $service = $this->getServiceBuilder($response->getOAuth2Token())->get('video');

        $response = $service->getAllVideos(21);

        print_r($response);
    }

    /**
     * @param OAuth2Interface $OAuth2Token
     *
     * @return ServiceBuilder
     */
    private function getServiceBuilder(OAuth2Interface $OAuth2Token)
    {
        $client = new Client(['base_url' => 'https://api.video-cdn.net']);

        $factory = new ServiceFactory(new BaseServiceFactory($this->getSerializerBuilder()->build(), $client), $OAuth2Token);

        $loader = new JsonLoader($this->getPuliRepo());
        $builder = new ServiceBuilder($loader, $factory, '/mi/videomanager-pro-sdk/common/services.json');

        return $builder;
    }

    /**
     * @return PathMappingRepository
     */
    private function getPuliRepo()
    {
        $repo = new PathMappingRepository(new ArrayStore());
        $repo->add('/mi/videomanager-pro-sdk', new DirectoryResource(__DIR__.'/../resources'));

        return $repo;
    }

    /**
     * @return SerializerBuilder
     */
    private function getSerializerBuilder()
    {
        $driver = new XmlDriver(
            new PuliFileLocator(
                $this->getPuliRepo(),
                [
                    'Mi\\VideoManagerPro\\SDK\\Model' => '/mi/videomanager-pro-sdk/serializer',
                ]
            )
        );

        $serializer = SerializerBuilder::create();
        $serializer->setMetadataDriverFactory(new CallbackDriverFactory(function () use ($driver) {
            return $driver;
        }));

        $serializer->configureListeners(function (EventDispatcher $dispatcher) {
            $dispatcher->addListener('serializer.pre_deserialize', new FormatTimestampListener());
        });

        return $serializer;
    }
}
