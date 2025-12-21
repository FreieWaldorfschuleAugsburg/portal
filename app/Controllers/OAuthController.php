<?php

namespace App\Controllers;

use App\Models\OAuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\logout;

class OAuthController extends BaseController
{
    /**
     * @throws OAuthException
     */
    public function logout(): RedirectResponse
    {
        return logout();
    }
}
