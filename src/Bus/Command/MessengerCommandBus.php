<?php

namespace St\AbstractService\Bus\Command;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerCommandBus implements MessengerCommandBusInterface
{
    /**
     * @param MessageBusInterface $messengerBusCommand
     */
    public function __construct(private readonly MessageBusInterface $messengerBusCommand)
    {
    }

    /**
     * @param CommandInterface $command
     * @throws \Exception
     */
    public function handle(CommandInterface $command): void
    {
        try {
            $this->messengerBusCommand->dispatch($command);
        } catch (HandlerFailedException $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}