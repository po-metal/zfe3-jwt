<?php

declare(strict_types=1);

namespace Jwt\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Jwt\Service\JwtService;

class TokenHandler implements RequestHandlerInterface
{
    private $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [];
        return new JsonResponse(['access_token' => $this->getJwtService()->signIn($data)]);
    }

    public function getJwtService() : JwtService
    {
        return $this->jwtService;
    }
}
