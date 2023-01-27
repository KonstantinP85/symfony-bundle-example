<?php

namespace St\AbstractService\Controller;

use St\AbstractService\Bus\Query\MessengerQueryBusInterface;

class QueryController extends AbstractController
{
    /**
     * @param MessengerQueryBusInterface $queryBus
     */
    public function __construct(protected readonly MessengerQueryBusInterface $queryBus)
    {
    }
}