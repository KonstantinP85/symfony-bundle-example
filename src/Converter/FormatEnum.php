<?php

namespace St\AbstractService\Converter;

use Symfony\Component\Serializer\Encoder\JsonEncoder;

enum FormatEnum: string
{
    case JSON_FORMAT = 'json';
}
