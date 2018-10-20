<?php

declare(strict_types=1);

namespace Jwt\Factory\Handler;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Jwt\Service\JwtService;
use Jwt\Handler\TokenHandler;

class TokenHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $jwtService = new JwtService();
        return new TokenHandler($jwtService);
    }
}
