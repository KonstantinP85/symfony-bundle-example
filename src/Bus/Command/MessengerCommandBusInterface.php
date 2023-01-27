<?php

namespace St\AbstractService\Bus\Command;

interface MessengerCommandBusInterface
{
    public function handle(CommandInterface $command): void;
}