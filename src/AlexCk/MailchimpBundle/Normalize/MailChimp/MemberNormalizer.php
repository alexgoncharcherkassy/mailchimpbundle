<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Normalize\MailChimp;

use AlexCk\MailchimpBundle\Model\MailChimp\Member;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class MemberNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        /** @var Member $item */
        $item = &$object;

        $data = [
            'email_address' => $item->getEmail(),
            'status' => $item->getStatus(),
            'merge_fields' => $this->serializer->normalize($item->getMergeFields(), 'json', [])
        ];

        return $data;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        /** @var Member $item */
        $item = new $class();

        if ($data) {
            foreach ($data as $fieldName => $fieldValue) {
                switch ($fieldName) {
                    case 'id':
                        $item->setId($fieldValue);
                        break;
                    case 'email_address':
                        $item->setEmail($fieldValue);
                        break;
                    case 'status':
                        $item->setStatus($fieldValue);
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
        return Member::class == $type;
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
        return $data instanceof Member;
    }
}
