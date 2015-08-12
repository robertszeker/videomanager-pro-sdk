<?php

namespace Mi\VideoManagerPro\SDK\Tests;

use JMS\Serializer\SerializerBuilder;
use Mi\Guzzle\ServiceBuilder\Loader\JsonLoader;
use Mi\Guzzle\ServiceBuilder\ServiceBuilder;
use Mi\Guzzle\ServiceBuilder\ServiceFactory as BaseServiceFactory;
use Mi\VideoManagerPro\SDK\Common\ServiceFactory;
use Mi\VideoManagerPro\SDK\Common\Token\SecurityTokens;
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

        $serializer = SerializerBuilder::create();
        $loader = new JsonLoader($repo);
        $factory = new ServiceFactory(new BaseServiceFactory($serializer->build()), new SecurityTokens());
        $builder = new ServiceBuilder($loader, $factory, '/mi/videomanager-pro-sdk/common/services.json');

        /** @var SecurityService $service */
        $service = $builder->get('security');
        $response = $service->login('username', 'pw');

        var_dump($response);
    }
}
