<?php

namespace App\Controller\Api;

use App\Service\QrcodeService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QrCodeController extends AbstractController
{
    private QrcodeService $qrCodeService;
    private string $menuUrl;

    public function __construct(QrcodeService $qrCodeService, string $menuUrl)
    {
        $this->qrCodeService = $qrCodeService;
        $this->menuUrl = $menuUrl;
    }

    /**
     * @Route("/qr-code", name="app_api_admin_qrcode", methods={"GET"})
     */
    public function default()
    {
        return $this->qrCodeService->getQrCodeResponse($this->menuUrl);
    }
}
