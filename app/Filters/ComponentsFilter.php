<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use function App\Helpers\user;

class ComponentsFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): ResponseInterface
    {
        $beforeContent = view('components/header');
        if (is_null($arguments) || !in_array('noNavbar', $arguments)) {
            helper('oauth');

            $appName = $_GET['app_name'] ?? null;
            $appUrl = $_GET['app_url'] ?? null;
            $beforeContent .= view('components/navbar', ['user' => user(), 'appName' => esc($appName), 'appUrl' => esc($appUrl)]);
        }

        $afterContent = "";
        if (is_null($arguments) || !in_array('noFooter', $arguments)) {
            $afterContent .= view('components/footer');
        }

        $response->setBody($beforeContent . $response->getBody() . $afterContent);

        return $response;
    }
}