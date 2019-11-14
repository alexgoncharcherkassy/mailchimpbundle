<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Normalize\MailChimp;

use AlexCk\MailchimpBundle\Model\MailChimp\ListItemCampaignDefaults;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ListItemCampaignDefaultsNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        /** @var ListItemCampaignDefaults $item */
        $item = &$object;

        $data = [
            'from_name' => $item->getFromName(),
            'from_email' => $item->getFromEmail(),
            'subject' => $item->getSubject(),
            'language' => $item->getLanguage(),
        ];

        return $data;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        /** @var ListItemCampaignDefaults $item */
        $item = new $class();

        if ($data) {
            foreach ($data as $fieldName => $fieldValue) {
                switch ($fieldName) {
                    case 'from_name':
                        $item->setFromName($fieldValue);
                        break;
                    case 'from_email':
                        $item->setFromEmail($fieldValue);
                        break;
                    case 'subject':
                        $item->setSubject($fieldValue);
                        break;
                    case 'language':
                        $item->setLanguage($fieldValue);
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
        return ListItemCampaignDefaults::class == $type;
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
        return $data instanceof ListItemCampaignDefaults;
    }
}
