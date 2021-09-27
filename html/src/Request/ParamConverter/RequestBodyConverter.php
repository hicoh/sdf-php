<?php

namespace App\Request\ParamConverter;

use App\Request\Exception\BadRequestException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class RequestBodyConverter implements ParamConverterInterface
{
    protected string $format;

    protected SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer, string $format = 'json')
    {
        $this->format = $format;
        $this->serializer = $serializer;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        try {
            $object = $this->serializer->deserialize(
                json_encode($request->toArray()),
                $configuration->getClass(),
                $this->format
            );
        } catch (NotNormalizableValueException $exception) {
            $errorMessage = sprintf(
                'Request body [%s] has invalid %s format. %s',
                $this->getParamClass($configuration),
                $this->format,
                $exception->getMessage()
            );
            throw new BadRequestException($errorMessage, 400, $exception);
        } catch (\InvalidArgumentException $exception) {
            throw new BadRequestException($exception->getMessage(), 0, $exception);
        }

        $request->attributes->set($configuration->getName(), $object);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        $class = $configuration->getClass();

        return null !== $class && self::class === $class::getParamConverterClass();
    }

    protected function getParamClass(ParamConverter $configuration): string
    {
        $classname = $configuration->getClass();

        if ($pos = strrpos($classname, '\\')) {
            $classname = substr($classname, $pos + 1);
        }

        return $classname;
    }
}
