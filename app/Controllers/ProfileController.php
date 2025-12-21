<?php

namespace App\Controllers;

use App\Models\OAuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\logout;
use function App\Helpers\user;

class ProfileController extends BaseController
{
    public function index(): string
    {
        $user = user();
        return view('profile/ProfileView', ['user' => $user]);
    }
}
