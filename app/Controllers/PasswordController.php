<?php

namespace App\Controllers;

use App\Models\InsufficientPasswordException;
use App\Models\InvalidEmailException;
use App\Models\InvalidUsernameException;
use App\Models\LDAPException;
use App\Models\OAuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\changePassword;
use function App\Helpers\decodeToken;
use function App\Helpers\initPasswordReset;
use function App\Helpers\user;

class PasswordController extends BaseController
{
    /**
     * @throws OAuthException
     */
    public function changePassword(): string
    {
        $user = user();
        return view('password/PasswordChangeView', ['user' => $user]);
    }

    /**
     * @throws OAuthException
     */
    public function handleChangePassword(): RedirectResponse
    {
        $user = user();

        $newPassword = esc(trim($this->request->getPost('newPassword')));
        $newPasswordConfirm = esc(trim($this->request->getPost('newPasswordConfirm')));

        if ($newPassword != $newPasswordConfirm) {
            return redirect()->back()->with('error', lang('password.change.passwordMismatch'));
        }

        try {
            changePassword($user->getUsername(), $newPassword);
        } catch (InsufficientPasswordException) {
            return redirect()->back()->with('error', lang('password.change.insufficientPassword'));
        } catch (LDAPException $e) {
            return redirect()->back()->with('error', sprintf(lang('password.change.ldapError'), $e->getMessage()));
        }

        return redirect()->back()->with('success', lang('password.change.success'));
    }

    public function resetPassword(): RedirectResponse|string
    {
        $token = esc(trim($this->request->getGet('token')));
        if ($token) {
            if (!decodeToken($token)) {
                return redirect('reset_password')->with('error', lang('password.reset.invalidToken'));
            }

            return view('password/PasswordResetView', ['token' => $token]);
        }

        return view('password/PasswordResetStartView');
    }

    public function handleResetPassword(): string|RedirectResponse
    {
        $token = esc(trim($this->request->getPost('token')));
        if ($token) {
            $token = decodeToken($token);
            if (!$token) {
                return redirect('reset_password')->with('error', lang('password.reset.invalidToken'));
            }

            $newPassword = esc(trim($this->request->getPost('newPassword')));
            $newPasswordConfirm = esc(trim($this->request->getPost('newPasswordConfirm')));
            $username = $token->username;

            if ($newPassword != $newPasswordConfirm) {
                return redirect()->back()->with('error', lang('password.reset.passwordMismatch'));
            }

            try {
                changePassword($username, $newPassword);
            } catch (InsufficientPasswordException) {
                return redirect()->back()->with('error', lang('password.reset.insufficientPassword'));
            } catch (LDAPException $e) {
                return redirect()->back()->with('error', sprintf(lang('password.reset.ldapError'), $e->getMessage()));
            }

            return view('password/PasswordResetSuccessView');
        }

        $username = esc(trim($this->request->getPost('username')));
        $email = esc(trim($this->request->getPost('email')));

        try {
            initPasswordReset($username, $email);
        } catch (InvalidEmailException) {
            return redirect()->back()->withInput()->with('error', lang('password.reset.start.invalidEmail'));
        } catch (InvalidUsernameException) {
            return redirect()->back()->withInput()->with('error', lang('password.reset.start.invalidUsername'));
        } catch (LDAPException $e) {
            return redirect()->back()->with('error', sprintf(lang('password.reset.ldapError'), $e->getMessage()));
        }

        return view('password/PasswordResetConfirmView');
    }
}
