<?php

namespace App\Controllers;

use Imagick;
use function App\Helpers\addImage;
use function App\Helpers\createGradient;

class TestController extends BaseController

{

    public function index()
    {
//        helper('image');
//
//        $gradient = createGradient("#1306BB", "#7C13BF");
//        $logo = new Imagick();
//        $template = file_get_contents("http://localhost/portal/public/assets/img/officelogo.png");
//        $logo->readImageBlob($template);
//
//        $gradient = addImage($gradient, $logo);
//
//
//        ob_clean();
//        $this->response->setHeader('Content-Type', 'image/png');
//        echo $gradient;
        return $this->render('test/test');

    }


}

?>