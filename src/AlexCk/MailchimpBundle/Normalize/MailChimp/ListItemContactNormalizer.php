<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Normalize\MailChimp;

use AlexCk\MailchimpBundle\Model\MailChimp\ListItemContact;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ListItemContactNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        /** @var ListItemContact $item */
        $item = &$object;

        $data = [
            'company' => $item->getCompany(),
            'address1' => $item->getAddress1(),
            'address2' => $item->getAddress2(),
            'city' => $item->getCity(),
            'zip' => $item->getZip(),
            'country' => $item->getCountry(),
            'phone' => $item->getPhone(),
            'state' => $item->getState(),
        ];

        return $data;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        /** @var ListItemContact $item */
        $item = new $class();

        if ($data) {
            foreach ($data as $fieldName => $fieldValue) {
                switch ($fieldName) {
                    case 'company':
                        $item->setCompany($fieldValue);
                        break;
                    case 'address1':
                        $item->setAddress1($fieldValue);
                        break;
                    case 'address2':
                        $item->setAddress2($fieldValue);
                        break;
                    case 'city':
                        $item->setCity($fieldValue);
                        break;
                    case 'zip':
                        $item->setZip($fieldValue);
                        break;
                    case 'country':
                        $item->setCountry($fieldValue);
                        break;
                    case 'phone':
                        $item->setPhone($fieldValue);
                        break;
                    case 'state':
                        $item->setState($fieldValue);
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
        return ListItemContact::class == $type;
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
        return $data instanceof ListItemContact;
    }
}
