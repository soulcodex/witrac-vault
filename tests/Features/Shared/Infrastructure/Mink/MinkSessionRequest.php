<?php

namespace Witrac\Tests\Features\Shared\Infrastructure\Mink;

use Behat\Gherkin\Node\PyStringNode;
use Symfony\Component\DomCrawler\Crawler;

final class MinkSessionRequest
{
    private MinkSession $sessionHelper;

    public function __construct(MinkSession $sessionHelper)
    {
        $this->sessionHelper = $sessionHelper;
    }

    public function sendRequest(string $method, string $url, array $optionalParams = []): void
    {
        $this->request($method, $url, $optionalParams);
    }

    public function sendRequestWithPyStringNode(string $method, string $url, PyStringNode $body): void
    {
        $this->request($method, $url, ['content' => $body->getRaw()]);
    }

    public function request(string $method, string $url, array $optionalParams = []): Crawler
    {
        return $this->sessionHelper->sendRequest($method, $url, $optionalParams);
    }
}