<?php

namespace St\AbstractService\Controller;

use St\AbstractService\Bus\Command\MessengerCommandBus;
use St\AbstractService\Bus\Command\MessengerCommandBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandController extends AbstractController
{
    /**
     * @param MessengerCommandBusInterface $commandBus
     */
    public function __construct(protected readonly MessengerCommandBusInterface $commandBus)
    {
    }
}