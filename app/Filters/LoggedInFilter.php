<?php

namespace App\Filters;

use App\Models\AuthException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use function App\Helpers\isLoggedIn;

class LoggedInFilter implements \CodeIgniter\Filters\FilterInterface
{
    /**
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (is_null(session('USERNAME'))) {
            return redirect()->to(site_url('login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }

}