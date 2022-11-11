<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\HTTP\RedirectResponse;
use LdapRecord\Query\ObjectNotFoundException;
use function App\Helpers\getCurrentUser;
use function App\Helpers\handleAuthException;
use function App\Helpers\isLoggedIn;
use function App\Helpers\login;
use function App\Helpers\logout;

class AuthenticationController extends BaseController
{
    /**
     * @throws AuthException
     */
    public function login(): string|RedirectResponse
    {
        helper('auth');

        try {
            if (isLoggedIn()) {
                return redirect('/');
            }
        } catch (AuthException $e) {
            return handleAuthException($e);
        }

        // This will never throw an exception since we're not rendering the navbar
        return $this->render(name: 'LoginView', data: NULL, renderNavbar: true);
    }

    /**
     * @throws AuthException
     */
    public function handleLogin()
    {
        $username = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('password'));

        helper('auth');

        try {
            login($username, $password);

        } catch (AuthException $e) {
            return handleAuthException($e);
        }
        return redirect('/');
    }

    public function logout(): RedirectResponse
    {
        helper('auth');
        logout();
        return redirect('/');
    }
}