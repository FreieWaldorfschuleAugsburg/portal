<?php

namespace App\Controllers;

use App\Models\AuthException;
use ReflectionException;
use function App\Helpers\getAllCredentialsForRoles;
use function App\Helpers\getEntriesByCategory;
use function App\Helpers\getUserRoles;
use function App\Helpers\isLoggedIn;

class IndexController extends BaseController
{
    /**
     * @throws AuthException
     * @throws ReflectionException
     */
    public function index(): string
    {
        $roles = getUserRoles();
        $entries = getEntriesByCategory($roles);
        $credentials = [];
        if (isLoggedIn()) {
            $credentials = getAllCredentialsForRoles($roles, ['show_on_home' => true]);
        }

        return $this->render("IndexView", ['entries' => $entries, 'credentials' => $credentials]);
    }
}
