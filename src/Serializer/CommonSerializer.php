<?php

namespace St\AbstractService\Serializer;

use St\AbstractService\Converter\FormatEnum;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class CommonSerializer
{
    /**
     * @var Serializer
     */
    private Serializer $serializer;

    public function __construct()
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->disableExceptionOnInvalidPropertyPath()
            ->getPropertyAccessor();

        $propertyNormalizer = new PropertyNormalizer();
        $arrayDenormalized = new ArrayDenormalizer();
        $objectNormalizer = new ObjectNormalizer(null, null, $propertyAccessor, new ReflectionExtractor());

        $this->serializer = new Serializer([$arrayDenormalized, $objectNormalizer, $propertyNormalizer], [new JsonEncoder()]);
    }

    /**
     * @param $body
     * @param $format
     * @return array
     */
    public function decode($body, $format): array
    {
        return $this->serializer->decode($body, $format);
    }

    /**
     * @param array $denormalizedData
     * @param string $toClass
     * @param string|null $format
     * @param array $context
     * @return object|array
     */
    public function denormalize(array $denormalizedData, string $toClass, string $format = null, array $context = []): object|array
    {
        return $this->serializer->denormalize($denormalizedData, $toClass, $format, $context);
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @param array $context
     * @return array
     * @throws ExceptionInterface
     */
    public function normalize(mixed $data, string $format = null, array $context = []): array
    {
        return $this->serializer->normalize($data, $format, $context);
    }
}