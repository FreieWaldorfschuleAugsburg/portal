<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\getEntriesByCategory;
use function App\Helpers\getUserRoles;
use function App\Helpers\getCurrentUser;
use function App\Helpers\handleAuthException;
use function App\Helpers\isLoggedIn;

class IndexController extends BaseController
{
    /**
     * @throws AuthException
     * @throws \ReflectionException
     */
    public function index(): string
    {
        helper(['auth', 'role', 'group', 'entry']);
        $roles = getUserRoles();
        $entries = getEntriesByCategory($roles);
        $credentials = [];
        if (isLoggedIn()) {
            $credentials = getAllCredentialsForRoles($roles, ['show_on_home' => true]);
        }
        return $this->render("IndexView", ['entries' => $entries, 'credentials' => $credentials], true);

    }
}
