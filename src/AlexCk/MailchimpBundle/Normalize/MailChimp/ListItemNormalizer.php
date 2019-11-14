<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Normalize\MailChimp;

use AlexCk\MailchimpBundle\Model\MailChimp\ListItem;
use AlexCk\MailchimpBundle\Model\MailChimp\ListItemCampaignDefaults;
use AlexCk\MailchimpBundle\Model\MailChimp\ListItemContact;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class ListItemNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        /** @var ListItem $item */
        $item = &$object;

        $data = [
            'name' => $item->getName(),
            'contact' => $this->serializer->normalize($item->getContact(), 'json', []),
            'campaign_defaults' => $this->serializer->normalize($item->getCampaignDefaults(), 'json', []),
            'permission_reminder' => $item->getPermissionReminder(),
            'email_type_option' => $item->isEmailTypeOption(),
        ];

        return $data;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        /** @var ListItem $item */
        $item = new $class();

        if ($data) {
            foreach ($data as $fieldName => $fieldValue) {
                switch ($fieldName) {
                    case 'id':
                        $item->setId($fieldValue);
                        break;
                    case 'name':
                        $item->setName($fieldValue);
                        break;
                    case 'permission_reminder':
                        $item->setPermissionReminder($fieldValue);
                        break;
                    case 'email_type_option':
                        $item->setEmailTypeOption($fieldValue);
                        break;
                    case 'contact':
                        $item->setContact($this->serializer->denormalize($fieldValue, ListItemContact::class, 'json', []));
                        break;
                    case 'campaign_defaults':
                        $item->setCampaignDefaults($this->serializer->denormalize($fieldValue, ListItemCampaignDefaults::class, 'json', []));
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
        return ListItem::class == $type;
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
        return $data instanceof ListItem;
    }
}
