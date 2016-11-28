<?php

namespace System\Core\Http;

use Symfony\Component\HttpKernel;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as SymfonyResolver;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyDispatcher;

class Kernel extends HttpKernel\HttpKernel
{

    public $dispatcher;


    public $resolver;


    public function __construct(SymfonyDispatcher $dispatcher, SymfonyResolver $resolver)
    {
        $this->dispatcher = $dispatcher;
        $this->resolver = $resolver;
    }

    public function handle(SymfonyRequest $request, $type = parent::MASTER_REQUEST, $catch = true)
    {
        parent::__construct($this->dispatcher, $this->resolver);
        return parent::handle($request);
    }

}
