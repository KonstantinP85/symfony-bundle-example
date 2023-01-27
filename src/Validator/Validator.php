<?php

namespace St\AbstractService\Validator;

use Doctrine\Common\Annotations\AnnotationReader;
use St\AbstractService\Exception\BadRequestParamsException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    public function __construct()
    {
        $this->validator = Validation::createValidatorBuilder()
            ->setDoctrineAnnotationReader(new AnnotationReader())
            ->enableAnnotationMapping()
            ->getValidator();
    }

    /**
     * @param string $dtoClass
     * @param array $requestData
     * @throws BadRequestParamsException
     */
    public function requestValidator(string $dtoClass, array $requestData): void
    {
        try {
            $reflectionClass = new \ReflectionClass($dtoClass);
        } catch (\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }

        $errors = [];
        foreach ($reflectionClass->getProperties() as $property) {

            if (!array_key_exists($property->getName(), $requestData)) {
                $requestData[$property->getName()] = null;
            }

            $viol = $this->validator->validatePropertyValue($dtoClass, $property->getName(), $requestData[$property->getName()]);
            for ($i = 0; $i < count($viol); $i++) {
                $errors[$property->getName()] = $viol[$i]->getMessage();
            }
        }

        if (count($errors) > 0) {
            throw new BadRequestParamsException($errors);
        }
    }

    /**
     * @param string $dtoClassName
     * @param array $denormalizedData
     * @param bool $isCollection
     */
    public function responseValidator(string $dtoClassName, array $denormalizedData, bool $isCollection): void
    {
        if ($isCollection) {
            foreach ($denormalizedData as $data) {
                $this->responseValidator($dtoClassName, $data, false);
            }

            return;
        }
    }
}