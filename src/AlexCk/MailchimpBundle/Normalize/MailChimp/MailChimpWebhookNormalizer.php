<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Normalize\MailChimp;

use AlexCk\MailchimpBundle\Model\MailChimp\MailChimpWebHook;
use AlexCk\MailchimpBundle\Model\MailChimp\MailChimpWebHooksEvent;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class MailChimpWebhookNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        /** @var MailChimpWebHook $item */
        $item = &$object;

        $data = [
            'url' => $item->getUrl(),
            'events' => $this->serializer->normalize($item->getEvents(), 'json', []),
            'sources' => $this->serializer->normalize($item->getSources(), 'json', []),
        ];

        return $data;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        /** @var MailChimpWebHook $item */
        $item = new $class();

        if ($data) {
            foreach ($data as $fieldName => $fieldValue) {
                switch ($fieldName) {
                    case 'id':
                        $item->setId($fieldValue);
                        break;
                    case 'url':
                        $item->setUrl($fieldValue);
                        break;
                    case 'events':
                        $item->setEvents($this->serializer->denormalize($fieldValue, MailChimpWebHooksEvent::class, 'json', []));
                        break;
                }
            }
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return MailChimpWebHook::class == $type;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $this->supportsClass($data);
    }

    private function supportsClass($data)
    {
        return $data instanceof MailChimpWebHook;
    }
}
