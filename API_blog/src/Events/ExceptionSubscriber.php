<?php

declare(strict_types=1);

namespace App\Events;

use App\Factory\JsonResponseInterface;
use App\Normalizer\NormalizerInterface;
use App\Services\ExceptionNormalizerFormatterInterface;
use Exception;
use PhpParser\Node\Stmt\Break_;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private static array $normalizers;
    private SerializerInterface $serializer;
    private $exceptionNormalizerFormatter;
    private JsonResponseInterface $jsonResponse;

    public function __construct(
        SerializerInterface $serializer,
        ExceptionNormalizerFormatterInterface $exceptionNormalizerFormatter,
        JsonResponseInterface $jsonResponse
        )
    {
        $this->serializer = $serializer;   
        $this->exceptionNormalizerFormatter = $exceptionNormalizerFormatter;
        $this->jsonResponse = $jsonResponse;
    }
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [['proccessException', 0]]
        ];
    }

    public function proccessException(ExceptionEvent $event)
    {
        $result = null;
        /**
         * @var \Exception $exception
         */
        $exception = $event->getThrowable();

        /**
         *  @var NormalizerInterface $normalizer
         */
        foreach( self::$normalizers as $key => $normalizer) {
            if($normalizer->supports($exception)) {
                $result = $normalizer->normalize($exception);
                break;
            }
        }

        if(null === $result) {
            $result = $this->exceptionNormalizerFormatter->format(
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }

        //$body = $this->serializer->serialize($result, 'json');

        //$response = new Response($body, $result['code']);
        //$response->headers->set('Content-Type', 'application/json');

        $event->setResponse($this->jsonResponse->getJsonResponse(
            $result['code'],
            $this->serializer->serialize($result, 'json')
        ));
    }

    public function addNormalizer(NormalizerInterface $normalizer)
    {
        self::$normalizers[] = $normalizer;
    }
}
