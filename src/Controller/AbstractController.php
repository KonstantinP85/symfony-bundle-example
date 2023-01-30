<?php

namespace St\AbstractService\Controller;

use St\AbstractService\Converter\Converter;
use St\AbstractService\Serializer\CommonSerializer;
use St\AbstractService\Validator\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractController
{
    /**
     * @param array $data
     * @return JsonResponse
     */
    protected function successResponse(array $data = []): JsonResponse
    {
        return new JsonResponse(array_merge([
                'status' => 'success'
            ], count($data) == 0 ? [] : ['result' => $data])
        );
    }

    /**
     * @param string|null $message
     * @return JsonResponse
     */
    protected function errorResponse(string $message = null): JsonResponse
    {
        return new JsonResponse(array_merge([
                'status' => 'error'
            ], is_null($message) ? [] : ['result' => $message])
        );
    }

    /**
     * @param string $data
     * @return JsonResponse
     */
    protected function badParamsResponse(string $data): JsonResponse
    {
        return new JsonResponse(array_merge([
                'status' => 'error'
            ], ['result' => json_decode($data, false)])
        );
    }

    /**
     * @return Converter
     */
    protected function getConverter(): Converter
    {
        return new Converter(new CommonSerializer(), new Validator());
    }
}