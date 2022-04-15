<?php

declare(strict_types=1);

namespace Witrac\Shared\Infrastructure\Symfony;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Witrac\Shared\Domain\Utils;

final class AddJsonBodyToRequestListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $requestContents = $request->getContent();

        if (
            empty($requestContents) &&
            !str_starts_with('application/json', $request->headers->get('Content-Type'))
        ) {
            return;
        }

        $jsonData = Utils::jsonDecode($requestContents);
        if (!$jsonData) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Invalid json data');
        }

        $jsonDataLowerCase = [];

        foreach ($jsonData as $key => $value) {
            $jsonDataLowerCase[preg_replace_callback(
                '/_(.)/',
                static fn ($matches) => strtoupper($matches[1]),
                $key
            )] = $value;
        }

        $request->request->replace($jsonDataLowerCase);
    }
}
