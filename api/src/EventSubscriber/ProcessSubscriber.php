<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\Exception\InvalidArgumentException;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use App\Service\ProcessService;

class ProcessSubscriber implements EventSubscriberInterface
{
	private $params;
	private $processService;
	private $serializer;
	
	public function __construct(ParameterBagInterface $params, ProcessService $processService, SerializerInterface $serializer)
	{
		$this->params = $params;
		$this->processService = $processService;
		$this->serializer= $serializer;
	}
	
	public static function getSubscribedEvents()
	{
		return [
				KernelEvents::VIEW => ['getProcess', EventPriorities::PRE_VALIDATE],
		];
		
	}
	
	public function getProcess(GetResponseForControllerResultEvent $event)
	{
		$process = $event->getControllerResult();
		$route =  $event->getRequest()->get('_route');
		$method = $event->getRequest()->getMethod();
		$extend = $event->getRequest()->query->get('extend');
		
		if ( $extend != "true" || $route !='api_processes_get_item') {
			return;
		}
		
		$process = $this->processService->extendProcess($process);
		
		return $process;
	}	
}
