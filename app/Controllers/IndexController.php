<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\getEntriesByCategory;
use function App\Helpers\getUserRoles;
use function App\Helpers\getCurrentUser;
use function App\Helpers\handleAuthException;

class IndexController extends BaseController
{
    /**
     * @throws AuthException
     */
    public function index(): string
    {
        helper(['auth', 'role', 'group', 'entry']);
        $roles = getUserRoles();
        $entries = getEntriesByCategory($roles);
        return $this->render("IndexView", ['entries' => $entries], true);

    }
}
