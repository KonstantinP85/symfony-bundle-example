<?php

namespace St\AbstractService\Bus\Query;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerQueryBus implements MessengerQueryBusInterface
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $messengerBusQuery
     */
    public function __construct(MessageBusInterface $messengerBusQuery)
    {
        $this->messageBus = $messengerBusQuery;
    }

    /**
     * @param QueryInterface $query
     * @throws \Exception
     */
    public function query(QueryInterface $query)
    {
        return $this->handle($query);
    }
}