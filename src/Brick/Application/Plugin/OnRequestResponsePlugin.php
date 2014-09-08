<?php

namespace Brick\Application\Plugin;

use Brick\Application\Events;
use Brick\Application\Event\ControllerParameterEvent;
use Brick\Application\Event\ResponseEvent;
use Brick\Application\Plugin;
use Brick\Application\Controller\Interfaces\OnRequestInterface;
use Brick\Application\Controller\Interfaces\OnResponseInterface;
use Brick\Event\EventDispatcher;

/**
 * Calls `onRequest()` and `onResponse()` on controllers implementing OnRequestInterface and OnResponseInterface.
 */
class OnRequestResponsePlugin implements Plugin
{
    /**
     * {@inheritdoc}
     */
    public function register(EventDispatcher $dispatcher)
    {
        $dispatcher->addListener(Events::CONTROLLER_READY, [$this, 'invokeOnRequest']);
        $dispatcher->addListener(Events::RESPONSE_RECEIVED, [$this, 'invokeOnResponse']);
    }

    /**
     * @internal
     *
     * @param ControllerParameterEvent $event
     *
     * @return void
     */
    public function invokeOnRequest(ControllerParameterEvent $event)
    {
        $controller = $event->getControllerInstance();

        if ($controller instanceof OnRequestInterface) {
            $controller->onRequest($event->getRequest());
        }
    }

    /**
     * @internal
     *
     * @param ResponseEvent $event
     *
     * @return void
     */
    public function invokeOnResponse(ResponseEvent $event)
    {
        $controller = $event->getControllerInstance();

        if ($controller instanceof OnResponseInterface) {
            $controller->onResponse($event->getResponse());
        }
    }
}