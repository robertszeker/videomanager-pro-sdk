<?php

namespace Mi\VideoManagerPro\SDK\Tests;

use JMS\Serializer\Builder\CallbackDriverFactory;
use JMS\Serializer\Metadata\Driver\XmlDriver;
use JMS\Serializer\SerializerBuilder;
use Mi\Guzzle\ServiceBuilder\Loader\JsonLoader;
use Mi\Guzzle\ServiceBuilder\ServiceBuilder;
use Mi\Guzzle\ServiceBuilder\ServiceFactory as BaseServiceFactory;
use Mi\Puli\Metadata\Driver\PuliFileLocator;
use Mi\VideoManagerPro\SDK\Common\ServiceFactory;
use Mi\VideoManagerPro\SDK\Common\Token\OAuth2;
use Mi\VideoManagerPro\SDK\Security\SecurityService;
use Puli\Repository\PathMappingRepository;
use Puli\Repository\Resource\DirectoryResource;
use Webmozart\KeyValueStore\ArrayStore;

/**
 * @author Steve Reichenbach <steve.reichenbach@movingimage.com>
 */
class POCTest extends \PHPUnit_Framework_TestCase
{
    public function _()
    {
        $repo = new PathMappingRepository(new ArrayStore());
        $repo->add('/mi/videomanager-pro-sdk', new DirectoryResource(__DIR__. '/../resources'));

        $driver = new XmlDriver(
            new PuliFileLocator(
                $repo,
                ['Mi\\VideoManagerPro\\SDK\\Common\\Token' => '/mi/videomanager-pro-sdk/serializer/']
            )
        );

        $serializer = SerializerBuilder::create();
        $serializer->setMetadataDriverFactory(new CallbackDriverFactory(function() use ($driver) {
            return $driver;
        }));

        $loader = new JsonLoader($repo);
        $factory = new ServiceFactory(new BaseServiceFactory($serializer->build()), new OAuth2());
        $builder = new ServiceBuilder($loader, $factory, '/mi/videomanager-pro-sdk/common/services.json');

        /** @var SecurityService $service */
        $service = $builder->get('security');
        $response = $service->login('name', 'pw');
//        $response = $service->refresh(21);

        var_dump($response);
    }
}
