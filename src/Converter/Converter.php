<?php

namespace St\AbstractService\Converter;

use St\AbstractService\Bus\Command\CommandInterface;
use St\AbstractService\Bus\Query\QueryInterface;
use St\AbstractService\Exception\BadRequestParamsException;
use St\AbstractService\Serializer\CommonSerializer;
use St\AbstractService\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

class Converter
{
    public function __construct(
        private readonly CommonSerializer $serializer,
        private readonly Validator $validator
    ) {

    }

    /**
     * @param array $denormalizedData
     * @param string $toDtoClass
     * @param bool $isCollection
     * @return object|array
     */
    public function convertResponseToDto(array $denormalizedData, string $toDtoClass, bool $isCollection = true): object|array
    {
        $this->validator->responseValidator($toDtoClass, $denormalizedData, $isCollection);

        $toDtoClass = $isCollection ? $toDtoClass . '[]' : $toDtoClass;

        return $this->serializer->denormalize($denormalizedData, $toDtoClass, FormatEnum::JSON_FORMAT->value);
    }

    /**
     * @param string $dtoClass
     * @param Request $request
     * @return object
     * @throws BadRequestParamsException
     */
    public function convertRequestToDto(string $dtoClass, Request $request): object
    {
        $requestData = array_merge(
            $request->query->all(),
            $request->request->all(),
        );

        $this->validator->requestValidator($dtoClass, $requestData);

        return $this->serializer->denormalize($requestData, $dtoClass, null,
            [AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true]
        );
    }

    /**
     * @param string $dtoClass
     * @param object|array $entity
     * @return object
     * @throws ExceptionInterface
     */
    public function convertEntityToDto(string $dtoClass, object|array $entity): object
    {
        $arrayEntity = $this->serializer->normalize($entity);

        if (is_array($entity)) $dtoClass = $dtoClass . '[]';

        return  $this->serializer->denormalize($arrayEntity, $dtoClass);
    }
}