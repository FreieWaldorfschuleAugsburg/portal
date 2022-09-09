<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\entries;
use function App\Helpers\getCurrentUser;
use function App\Helpers\handleAuthException;

class IndexController extends BaseController
{
    public function index(): string|RedirectResponse
    {
        helper('auth');

        try {
            $user = getCurrentUser();

            helper('entry');
            return $this->render('IndexView', ['entries' => entries($user)]);
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }
}
