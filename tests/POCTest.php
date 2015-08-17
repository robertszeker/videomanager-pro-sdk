<?php

namespace Mi\VideoManagerPro\SDK\Tests;

use GuzzleHttp\Client;
use JMS\Serializer\Builder\CallbackDriverFactory;
use JMS\Serializer\Metadata\Driver\XmlDriver;
use JMS\Serializer\SerializerBuilder;
use Mi\Guzzle\ServiceBuilder\Loader\JsonLoader;
use Mi\Guzzle\ServiceBuilder\ServiceBuilder;
use Mi\Guzzle\ServiceBuilder\ServiceFactory as BaseServiceFactory;
use Mi\Puli\Metadata\Driver\PuliFileLocator;
use Mi\VideoManagerPro\SDK\Common\ServiceFactory;
use Mi\VideoManagerPro\SDK\Model\OAuth2;
use Mi\VideoManagerPro\SDK\Security\SecurityService;
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

        $refreshToken = '';

        $repo = new PathMappingRepository(new ArrayStore());
        $repo->add('/mi/videomanager-pro-sdk', new DirectoryResource(__DIR__. '/../resources'));

        $driver = new XmlDriver(
            new PuliFileLocator(
                $repo,
                [
                    'Mi\\VideoManagerPro\\SDK\\Model' => '/mi/videomanager-pro-sdk/serializer',
                ]
            )
        );

        $serializer = SerializerBuilder::create();
        $serializer->setMetadataDriverFactory(new CallbackDriverFactory(function() use ($driver) {
            return $driver;
        }));

        $client = new Client(['base_url' => 'https://vmpro-qa.movingimage.com/']);
        $oAuth2Token = new OAuth2('', $refreshToken);

        $factory = new ServiceFactory(new BaseServiceFactory($serializer->build(), $client), $oAuth2Token);

        $loader = new JsonLoader($repo);
        $builder = new ServiceBuilder($loader, $factory, '/mi/videomanager-pro-sdk/common/services.json');

        /** @var SecurityService $service */
        $service = $builder->get('security');
        $response = $service->login('name', 'pw');
//        $response = $service->refresh(21);

        print_r($response);
    }
}
