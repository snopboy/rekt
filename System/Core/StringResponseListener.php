<?php

namespace System\Core;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class StringResponseListener implements EventSubscriberInterface {

	public function onView(GetResponseForControllerResultEvent $event)
	{
		$response = $event->getControllerResult();

		if (is_string($response)) {
			$event->setResponse($symfonyResponse = new Response($response));
		}
		//
		// Not needed for now, Symfony has out-of-the-box support for JSON responses.
		// Leaving this commented for future-use, customize the response options.
		//
		/*elseif (is_array($response) || is_object($response)) {
			$event->setResponse(new JsonResponse($response));
			$symfonyResponse->headers->set('Content-Type', 'application/json');
		}
		else {
			die(1,
				sprintf('Unhandled response,<br /> <code>%s</code>', var_dump($response))
			);
		}*/
	}

	static function getSubscribedEvents()
	{
		return array('kernel.view' => 'onView');
	}
}
