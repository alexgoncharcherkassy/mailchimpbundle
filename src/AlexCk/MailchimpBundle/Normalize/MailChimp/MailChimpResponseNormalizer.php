<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Normalize\MailChimp;

use AlexCk\MailchimpBundle\Model\MailChimp\ListItem;
use AlexCk\MailchimpBundle\Model\MailChimp\MailChimpResponse;
use AlexCk\MailchimpBundle\Model\MailChimp\MailChimpWebHook;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class MailChimpResponseNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        /** @var MailChimpResponse $item */
        $item = &$object;

        $data = [
            'lists' => $item->getLists(),
            'webhooks' => $item->getWebhooks(),
        ];

        return $data;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $data = json_decode($data, true);

        /** @var MailChimpResponse $item */
        $item = new $class();

        if ($data) {
            foreach ($data as $fieldName => $fieldValue) {
                switch ($fieldName) {
                    case 'lists':
                        foreach ($fieldValue as $value) {
                            /** @var ListItem $listItem */
                            $listItem = $this->serializer->denormalize($value, ListItem::class, 'json', []);

                            $item->addList($listItem);
                        }
                        break;
                    case 'webhooks':
                        foreach ($fieldValue as $value) {
                            /** @var MailChimpWebHook $listItem */
                            $listItem = $this->serializer->denormalize($value, MailChimpWebHook::class, 'json', []);

                            $item->addWebhook($listItem);
                        }
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
        return MailChimpResponse::class == $type;
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
        return $data instanceof MailChimpResponse;
    }
}
