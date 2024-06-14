<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class PrintHelper extends Controller
{
    public function __construct() {
        helper('bmp_to_escpos_helper');
    }

    public function getLogoEscpos() {
        $logoPath = WRITEPATH . 'assets/images/logo_cocodream.bmp';
        $escposLogo = imageToEscpos($logoPath);

        if ($escposLogo === null) {
            return $this->response->setJSON(['error' => 'Failed to convert image']);
        } else {
            return $this->response->setJSON(['escposLogo' => base64_encode($escposLogo)]);
        }
    }
}
