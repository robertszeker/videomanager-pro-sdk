<?php

namespace Mi\VideoManagerPro\SDK\Tests\Video\Serializer;

use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use Mi\VideoManagerPro\SDK\Model\Video;
use Mi\VideoManagerPro\SDK\Video\Serializer\FormatTimestampListener;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers Mi\VideoManagerPro\SDK\Video\Serializer\FormatTimestampListener
 */
class FormatTimestampListenerTest extends \PHPUnit_Framework_TestCase
{
    private $subscriber;

    /**
     * @test
     */
    public function getSubscribedEvents()
    {
        self::assertCount(1, FormatTimestampListener::getSubscribedEvents());
    }

    /**
     * @test
     */
    public function doNothingIfTypeIsNotAsExpected()
    {
        $event = $this->prophesize(PreDeserializeEvent::class);

        call_user_func($this->subscriber, $event->reveal());
    }

    /**
     * @test
     */
    public function formatTimestamp()
    {
        $event = $this->prophesize(PreDeserializeEvent::class);

        $event->getType()->willReturn(['name' => Video::class]);
        $event->getData()->willReturn(['createdDate' => 2000]);
        $event->setData(['createdDate' => 2])->shouldBeCalled();

        call_user_func($this->subscriber, $event->reveal());
    }

    protected function setUp()
    {
        $this->subscriber = new FormatTimestampListener();
    }
}
