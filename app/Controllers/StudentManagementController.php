<?php

namespace App\Controllers;

use App\Models\InsufficientPasswordException;
use App\Models\LDAPException;
use App\Models\OAuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\changePassword;
use function App\Helpers\getADUser;
use function App\Helpers\getStudents;
use function App\Helpers\openLDAPConnection;
use function App\Helpers\user;

class StudentManagementController extends BaseController
{
    /**
     * @throws LDAPException
     */
    public function index(): string
    {
        $students = getStudents();

        return view('studentManagement/StudentManagementView', ['students' => $students]);
    }

    /**
     * @throws LDAPException
     */
    public function resetPassword(string $username): RedirectResponse|string
    {
        openLDAPConnection();
        $adUser = getADUser($username);
        if (!str_ends_with($adUser['distinguishedName'][0], getenv('ldap.studentDN'))) {
            return redirect('students')->with('error', 'studentManagement.userNoStudent');
        }

        return view('studentManagement/StudentPasswordResetView', ['name' => $adUser['cn'][0]]);
    }

    /**
     * @throws LDAPException
     * @throws OAuthException
     */
    public function handleResetPassword(string $username): RedirectResponse|string
    {
        openLDAPConnection();
        $adUser = getADUser($username);
        if (!str_ends_with($adUser['distinguishedName'][0], getenv('ldap.studentDN'))) {
            return redirect('students')->with('error', 'studentManagement.userNoStudent');
        }

        $newPassword = esc(trim($this->request->getPost('newPassword')));
        $newPasswordConfirm = esc(trim($this->request->getPost('newPasswordConfirm')));

        if ($newPassword != $newPasswordConfirm) {
            return redirect()->back()->with('error', lang('studentManagement.passwordMismatch'));
        }

        try {
            changePassword($username, $newPassword, user()->getDisplayName());
        } catch (InsufficientPasswordException) {
            return redirect()->back()->with('error', lang('studentManagement.insufficientPassword'));
        } catch (LDAPException $e) {
            return redirect()->back()->with('error', sprintf(lang('studentManagement.ldapError'), $e->getMessage()));
        }

        return redirect('students')->with('success', lang('studentManagement.passwordResetSuccess'));
    }
}
