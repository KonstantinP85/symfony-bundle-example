<?php

namespace St\AbstractService\Bus\Query;

interface MessengerQueryBusInterface
{
    public function query(QueryInterface $query);
}