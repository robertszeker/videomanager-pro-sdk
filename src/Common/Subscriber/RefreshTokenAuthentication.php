<?php

namespace Mi\VideoManagerPro\SDK\Common\Subscriber;

use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Stream\Stream;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class RefreshTokenAuthentication implements SubscriberInterface
{
    private $description;
    private $refreshToken;

    /**
     * @param Description    $description
     * @param string $refreshToken
     */
    public function __construct(Description $description, $refreshToken = null)
    {
        $this->description = $description;
        $this->refreshToken = $refreshToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvents()
    {
        return ['prepared' => ['onPrepared', 'last']];
    }

    public function onPrepared(PreparedEvent $event)
    {
        $this->refreshToken = 'eyJhbGciOiJSUzI1NiJ9.eyJqdGkiOiIyOGI5NTZiNS1iNjUxLTQyMTMtYTU2ZS01ZDYxZDY0ZDAwNzMiLCJleHAiOjE0Mzk0Nzk3MTUsIm5iZiI6MCwiaWF0IjoxNDM5NDc2MTE1LCJpc3MiOiJWaWRlb01hbmFnZXJQcm8iLCJzdWIiOiIzYWQzYTBkZS0wNGU4LTQ2MjMtYWQyOC0yZjE4ZThjMTZmNzAiLCJ0eXAiOiJSRUZSRVNIIiwiYXpwIjoidmlkZW8tbWFuYWdlci1wcm8tdWkiLCJzZXNzaW9uX3N0YXRlIjoiMDcwMDM4NDMtNTI2NS00OGU1LTk1MzctYzk2MzA4ZGZlNjNkIiwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbIlZNUFJPLUFQSSJdfSwicmVzb3VyY2VfYWNjZXNzIjp7InZpZGVvLW1hbmFnZXItcHJvLXVpIjp7InJvbGVzIjpbIlVJLVVTRVIiXX0sImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJ2aWV3LXByb2ZpbGUiXX19fQ.Bqr5uOh8vCBV4d0C0oUekLy5vvLzYBVWCEy2bE8Tb0UiUvKQOwIO2XBe0LZ9KH9Brhj1vNTJ9OrBbFhfhRsryvCVSsBynpItwV0tkjTXxgGsnZaMgKLDJ9QclxSsf4FijH0czwXVvHxjG3m7rz1cXsj9qYgfiSZsJcq7qe-_uD4LDAOPNcgs17RFMT0FaDIRNV1xLvH9ysTbUE-uB00pZDO0RticmpOBdc8JaNQv-fjm3nhYO7UabkClksQ_pDlAbagWQJqXtKnjdOXqIlPCP2HPgjRtxwP2B5PL2POkf0qyOOEaaRMC_LC93p6wSf089nxJqmrVx0_v2tRN9qulew';
        if ($this->refreshToken === null) {
            return;
        }

        $command   = $event->getCommand();
        $operation = $this->description->getOperation($command->getName());

        if ($operation->getData('refresh-token-auth') === true) {
            $event->getRequest()->setBody(Stream::factory(json_encode(['refreshToken' => $this->refreshToken])));
        }
    }
}
