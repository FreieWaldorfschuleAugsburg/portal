<?php

namespace App\Controllers;

use App\Models\InvalidEmailException;
use App\Models\InvalidUsernameException;
use App\Models\OAuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\initPasswordReset;
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
        return view('password/PasswordResetIndexView');
    }

    public function resetPasswordEmail(): string
    {
        return view('password/PasswordResetEmailView');
    }

    public function handleResetPasswordEmail(): string|RedirectResponse
    {
        $username = esc(trim($this->request->getPost('username')));
        $email = esc(trim($this->request->getPost('email')));

        try {
            initPasswordReset($username, $email);
        } catch (InvalidEmailException) {
            return redirect()->back()->withInput()->with('error', lang('password.reset.method.email.invalidEmail'));
        } catch (InvalidUsernameException) {
            return redirect()->back()->withInput()->with('error', lang('password.reset.method.email.invalidUsername'));
        }

        return view('password/PasswordResetInitView');
    }

    public function resetPasswordTeacher(): string
    {
        return view('password/PasswordResetTeacherView');
    }
}
