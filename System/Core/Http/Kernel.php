<?php

namespace System\Core\Http;

use Symfony\Component\HttpKernel;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as SymfonyControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver as SymfonyArgumentResolver;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\RequestStack as SymfonyRequestStack;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyDispatcher;

class Kernel extends HttpKernel\HttpKernel
{

    public $dispatcher;


    public $controllerResolver;


    public $argumentResolver;


    public $requestStack;


    public function __construct(
        SymfonyDispatcher $dispatcher,
        SymfonyControllerResolver $controllerResolver,
        SymfonyRequestStack $requestStack,
        SymfonyArgumentResolver $argumentResolver
    ){
        $this->dispatcher = $dispatcher;
        $this->controllerResolver = $controllerResolver;
        $this->requestStack = $requestStack;
        $this->argumentResolver = $argumentResolver;
    }

    public function handle(SymfonyRequest $request, $type = parent::MASTER_REQUEST, $catch = true)
    {
        parent::__construct($this->dispatcher, $this->controllerResolver, $this->requestStack, $this->argumentResolver);
        return parent::handle($request);
    }

}
