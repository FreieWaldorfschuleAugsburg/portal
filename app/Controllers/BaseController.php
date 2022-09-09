<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use function App\Helpers\getCurrentUser;
use function App\Helpers\user;

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    /**
     * @throws AuthException
     */
    public function render($name, $data = null, $renderNavbar = true): string
    {
        $renderedContent = view('components/header');

        if ($renderNavbar) {
            helper('auth');
            $renderedContent .= view('components/navbar', ['user' => getCurrentUser()]);
        }

        if (!is_null($data)) {
            $renderedContent .= view($name, $data);
        } else {
            $renderedContent .= view($name);
        }

        $renderedContent .= view('components/footer');
        return $renderedContent;
    }
}
