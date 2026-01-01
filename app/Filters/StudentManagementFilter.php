<?php

namespace App\Filters;

use App\Models\OAuthException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use function App\Helpers\isPermitted;
use function App\Helpers\isStudentManagementPermitted;
use function App\Helpers\login;
use function App\Helpers\user;

class StudentManagementFilter implements FilterInterface
{
    /**
     * @throws OAuthException
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('oauth');

        $user = user();
        if (is_null($user)) {
            return login();
        }

        if (!isStudentManagementPermitted($user)) {
            return redirect('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}