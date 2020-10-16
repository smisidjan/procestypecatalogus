<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Service\ProcessService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class ProcessSubscriber implements EventSubscriberInterface
{
    private $params;
    private $processService;
    private $serializer;

    public function __construct(ParameterBagInterface $params, ProcessService $processService, SerializerInterface $serializer)
    {
        $this->params = $params;
        $this->processService = $processService;
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['getProcess', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function getProcess(ViewEvent $event)
    {
        $processType = $event->getControllerResult();
        $route = $event->getRequest()->get('_route');
        $method = $event->getRequest()->getMethod();
        $extend = $event->getRequest()->query->get('extend');

        if ($extend != 'true' || $route != 'api_process_types_get_item') {
            return;
        }

        $process = $this->processService->extendProcess($processType);

        return $process;
    }
}
