<?php

namespace App\Controllers;

use App\Models\OAuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\logout;
use function App\Helpers\user;

class PasswordController extends BaseController
{
    public function changePassword(): string
    {
        $user = user();
        return view('password/PasswordChangeView', ['user' => $user]);
    }

    public function resetPassword(): string
    {
        return view('password/PasswordResetView');
    }
}
