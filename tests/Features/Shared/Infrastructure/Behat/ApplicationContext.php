<?php

namespace Witrac\Tests\Features\Shared\Infrastructure\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\RawMinkContext;
use RuntimeException;
use Witrac\Tests\Features\Shared\Infrastructure\Mink\MinkSession;
use Witrac\Tests\Features\Shared\Infrastructure\Mink\MinkSessionRequest;

final class ApplicationContext extends RawMinkContext implements Context
{
    private MinkSession $sessionHelper;
    private Session $minkSession;
    private MinkSessionRequest $request;

    public function __construct(Session $session)
    {
        $this->minkSession = $session;
        $this->sessionHelper = new MinkSession($this->minkSession);
        $this->request = new MinkSessionRequest(new MinkSession($session));
    }

    /**
     * @Given I make a :method request to :path
     */
    public function iMakeARequestTo(string $path, string $method): void
    {
        $this->request->sendRequest($method, $this->locatePath($path));
    }

    /**
     * @Given I make a :method request to :path with body
     */
    public function iMakeARequestToWithBody(string $path, string $method, PyStringNode $body): void
    {
        $this->request->sendRequestWithPyStringNode($method, $this->locatePath($path), $body);
    }

    /**
     * @Then the response content should be
     */
    public function theResponseShouldBe(PyStringNode $expectedResponse): void
    {
        $expected = $this->sanitizeJson($expectedResponse->getRaw());
        $actual = $this->sanitizeJson($this->sessionHelper->getResponse());

        if ($expected !== $actual) {
            $msg = sprintf(
                "The outputs does not match!\n\n-- Expected:\n%s\n\n-- Actual:\n%s",
                $expected,
                $actual
            );
            throw new RuntimeException($msg);
        }
    }

    /**
     * @Then the response content should be empty
     */
    public function theResponseContentShouldBeEmpty(): void
    {
        $actual = trim($this->sessionHelper->getResponse());

        if (false === empty($actual)) {
            throw new RuntimeException(sprintf("The outputs it's not empty!\n\n-- Actual:\n%s", $actual));
        }
    }

    /**
     * @Then the response status code should be :code
     */
    public function theResponseStatusCodeShouldBe(int $code): void
    {
        if ($code !== $this->minkSession->getStatusCode()) {
            $msg = sprintf(
                'The status code <%s> does not match the expected <%s>',
                $this->minkSession->getStatusCode(),
                $code
            );
            throw new RuntimeException($msg);
        }
    }

    private function sanitizeJson(string $json): ?string
    {
        return json_encode(json_decode(trim($json), true)) ?: null;
    }
}
