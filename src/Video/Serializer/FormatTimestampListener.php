<?php

namespace Mi\VideoManagerPro\SDK\Video\Serializer;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use Mi\VideoManagerPro\SDK\Model\Video;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class FormatTimestampListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ['event' => 'serializer.pre_deserialize', 'method' => '__invoke'],
        ];
    }

    /**
     * @param PreDeserializeEvent $event
     */
    public function __invoke(PreDeserializeEvent $event)
    {
        if ($event->getType()['name'] !== Video::class) {
            return;
        }

        $data = $event->getData();

        $this->formatTimestamp($data, 'createdDate');
        $this->formatTimestamp($data, 'uploadDate');

        $event->setData($data);
    }

    /**
     * @param array  $data
     * @param string $key
     */
    private function formatTimestamp(array &$data, $key)
    {
        if (array_key_exists($key, $data) === false) {
            return;
        }

        $data[$key] = $data[$key] / 1000;
    }
}
