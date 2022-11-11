<?php

namespace App\Helpers;

use App\Models\AuthException;
use App\Models\UserModel;
use CodeIgniter\Exceptions\ModelException;
use CodeIgniter\HTTP\RedirectResponse;
use LdapRecord\Auth\BindException;
use LdapRecord\Connection;
use LdapRecord\Container;
use LdapRecord\Models\ActiveDirectory\User;
use LdapRecord\Models\ActiveDirectory\Group;
use LdapRecord\Models\ModelNotFoundException;
use LdapRecord\Query\ObjectNotFoundException;

/**
 */
function isLoggedIn(): bool
{
    return !is_null(session('USERNAME'));
}

function hideForNonAdmin()
{
    return session('ADMIN') ? '' : 'hidden';
}

/**
 * @throws AuthException
 */
function hideForLoggedOut()
{
    return isLoggedIn() ? '' : 'hidden';
}


/**
 * @throws AuthException
 */


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
function authenticateUser(string $username, string $password): array|\LdapRecord\Models\Model
{
    $connection = getAdminConnection();

    try {
        $user = (new \LdapRecord\Models\ActiveDirectory\User)->where('samaccountname', '=', $username)->firstOrFail();
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
 * @throws ObjectNotFoundException
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
    $user = (new \LdapRecord\Models\ActiveDirectory\User)->find($dn);
    $groupNames = [];
    $groups = $user->groups()->recursive()->get();

    foreach ($groups as $group) {
        $groupNames[] = $group->getName();
    }

    return $groupNames;
}

function isAdmin(array $groups): bool
{

    if (in_array(getenv('admin.role.name'), $groups, true)) {
        return true;
    }

    return false;
}


/**
 * @throws AuthException
 */
function getCurrentUser(): ?UserModel

{
    if (!session('USERNAME')) {
        return null;
    } else try {
        $userName = session('USERNAME');
        $displayName = session('DISPLAYNAME');
        $groups = session('GROUPS');
        if (!session('GROUPS')) {
            $groups = getUserGroups(session('DN'));

        }
        return new UserModel($userName, $displayName, $groups);

    } catch (ModelNotFoundException $exception) {
        throw new AuthException('user not found');
    }
}

function protectRoute(bool $admin = false)
{

    if ($admin) {

        if (is_null(session('ADMIN'))) {
            redirect('login');
        }


    }


}


function handleAuthException(AuthException $exception): RedirectResponse
{
    return redirect('login')->with('error', $exception->getMessage());
}


/**
 * @throws ObjectNotFoundException
 */
function findUserByUsername(string $username): array|\LdapRecord\Models\Model|RedirectResponse|null
{
    try {
        return (new \LdapRecord\Models\ActiveDirectory\User)->where('samaccountname', '=', $username)->firstOrFail();
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


