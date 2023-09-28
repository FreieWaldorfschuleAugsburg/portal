<?php

namespace App\Helpers;

use App\Models\AuthException;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use LdapRecord\Connection;
use LdapRecord\Container;
use LdapRecord\Models\ActiveDirectory\User;
use LdapRecord\Models\Model;
use LdapRecord\Models\ModelNotFoundException;
use LdapRecord\Query\ObjectNotFoundException;

/**
 */
function isLoggedIn(): bool
{
    return !is_null(session('USERNAME'));
}

/**
 * @throws AuthException
 */

function getAdminConnection(): Connection
{
    $default = new Connection([
        'hosts' => [getenv('ad.hosts')],
        'base_dn' => getenv('ad.dn'),
        'username' => getenv("ad.admin.username"),
        'password' => getenv('ad.admin.password')
    ]);

    Container::addConnection($default);
    return $default;
}

/**
 * @throws AuthException
 */
function authenticateUser(string $username, string $password): array|Model
{
    $connection = getAdminConnection();
    try {
        $user = (new User)->where('samaccountname', '=', $username)->firstOrFail();
    } catch (ModelNotFoundException $exception) {
        throw new AuthException();
    }

    if (!$connection->auth()->attempt($user->getDn(), $password)) {
        throw new AuthException();
    }
    return $user;
}

/**
 * @throws AuthException
 */
function login(string $username, string $password): void
{
    try {
        $user = authenticateUser($username, $password);
        $userModel = new UserModel($username, $user->getName(), getUserGroups($user->getDn()));

        session()->set('USERNAME', $userModel->username);
        session()->set('DISPLAYNAME', $userModel->displayName);
        session()->set('DN', $user->getDn());
        session()->setTempdata('GROUPS', $userModel->groups, 600);
        session()->set('ADMIN', isAdmin($userModel->groups));
        session()->set('ABSENCE', hasAbsenceRole($userModel->groups));
        session()->set('ABSENCE_ADMIN', hasAbsenceAdminRole($userModel->groups));
        session()->set('ABSENCE_READ', hasAbsenceReadRole($userModel->groups));
        session()->setTempdata('ROLES', getUserRoles(), 600);
    } catch (AuthException $exception) {
        throw new AuthException('invalidCredentials');
    }
}

function logout(): void
{
    session()->destroy();
}

/**
 * @throws AuthException
 */
function getUserGroups(string $dn): array
{
    getAdminConnection();
    $user = (new User)->find($dn);
    $groupNames = [];
    $groups = $user->groups()->recursive()->get();
    foreach ($groups as $group) {
        $groupNames[] = $group->getName();
    }

    return $groupNames;
}

function hasAbsenceRole(array $groups): bool
{
    return in_array(getenv('role.absences'), $groups, true);
}

function hasAbsenceAdminRole(array $groups): bool
{
    return in_array(getenv('role.absencesAdmin'), $groups, true);
}

function hasAbsenceReadRole(array $groups): bool
{
    return in_array(getenv('role.absencesRead'), $groups, true);
}

function isAdmin(array $groups): bool
{
    return in_array(getenv('role.admin'), $groups, true);
}

/**
 * @throws AuthException
 */
function getCurrentUser(): ?UserModel
{
    if (!session('USERNAME')) {
        return null;
    } else {
        $userName = session('USERNAME');
        $displayName = session('DISPLAYNAME');
        $groups = session('GROUPS');
        if (!session('GROUPS')) {
            $groups = getUserGroups(session('DN'));

        }

        return new UserModel($userName, $displayName, $groups);
    }
}

function handleAuthException(AuthException $exception): RedirectResponse
{
    return redirect('login')->with('error', $exception->getMessage());
}

function findUserByUsername(string $username): array|Model|RedirectResponse|null
{
    try {
        return (new User)->where('samaccountname', '=', $username)->firstOrFail();
    } catch (ObjectNotFoundException $e) {
        return handleAuthException(new AuthException());
    }
}

/**
 * @throws AuthException
 */
function getUserRoles(): array|null
{
    $userRoles = null;
    if (isLoggedIn()) {
        $userRoles = [];
        $groups = getUserGroups(session('DN'));
        $roles = getAllRoles();
        foreach ($roles as $role) {
            foreach ($role->groups as $group) {
                if (in_array($group->internal_name, $groups)) {
                    if (!in_array($role->role_id, $userRoles)) {
                        $userRoles[] = $role->role_id;
                    }
                }
            }
        }
    }
    return $userRoles;
}