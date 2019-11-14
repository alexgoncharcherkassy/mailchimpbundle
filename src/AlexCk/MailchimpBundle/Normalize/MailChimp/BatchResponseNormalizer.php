<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Normalize\MailChimp;

use AlexCk\MailchimpBundle\Model\MailChimp\BatchResponse;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BatchResponseNormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        /** @var BatchResponse $item */
        $item = new $class();

        if ($data) {
            foreach ($data as $fieldName => $fieldValue) {
                switch ($fieldName) {
                    case 'id':
                        $item->setId($fieldValue);
                        break;
                    case 'status':
                        $item->setStatus($fieldValue);
                        break;
                    case 'total_operations':
                        $item->setTotalOperations($fieldValue);
                        break;
                    case 'finished_operations':
                        $item->setFinishedOperations($fieldValue);
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
        return BatchResponse::class == $type;
    }
}
