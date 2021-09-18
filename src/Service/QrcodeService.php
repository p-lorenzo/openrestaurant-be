<?php

namespace App\Service;

use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Exception;

class QrcodeService
{
    private BuilderInterface $qrCodeBuilder;

    public function __construct(BuilderInterface $qrCodeBuilder)
    {
        $this->qrCodeBuilder = $qrCodeBuilder;
    }

    /**
     * Genera il QRCode
     * @throws Exception
     */
    public function getQrCodeResponse(string $url): QrCodeResponse
    {
        $result = $this->qrCodeBuilder->data($url)->build();
        $qrCodeResponse = new QrCodeResponse($result);
        return $qrCodeResponse;
    }

}
