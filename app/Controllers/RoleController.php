<?php

namespace App\Controllers;

use App\Entities\Role;
use App\Models\AuthException;
use App\Models\GroupModel;
use App\Models\RoleModel;
use CodeIgniter\HTTP\RedirectResponse;
use Ramsey\Uuid\Uuid;
use ReflectionException;
use function App\Helpers\createGroupEntity;
use function App\Helpers\deleteRole;
use function App\Helpers\getAllActiveDirectoryGroups;
use function App\Helpers\getRole;
use function App\Helpers\saveRole;

class RoleController extends BaseController
{
    /**
     * @throws AuthException
     */
    public function index(): string
    {
        $db = db_connect();
        $roles = $db->table('portal_roles')->get()->getResult();
        $polishedRoles = array();

        foreach ($roles as $role) {
            $groupModel = new GroupModel();
            $groups = $groupModel->where('role_id', $role->role_id)->findAll();
            $roleEntity = new Role();
            $roleEntity->role_id = $role->role_id;
            $roleEntity->role_name = $role->role_name;
            $roleEntity->groups = $groups;
            $polishedRoles[] = $roleEntity;
        }

        return $this->render('roles/RoleView', [
            'roles' => $polishedRoles
        ]);
    }

    /**
     * @throws AuthException
     */
    public function create(): string
    {
        $groups = getAllActiveDirectoryGroups();

        return $this->render('roles/CreateRoleView', [
            'groups' => $groups]);
    }

    /**
     * @throws AuthException
     */
    public function edit($roleId): string
    {
        $role = getRole($roleId);
        $groups = getAllActiveDirectoryGroups();
        return $this->render('roles/EditRoleView', [
            'groups' => $groups,
            'role' => $role
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function update($roleId): RedirectResponse
    {
        $role = getRole($roleId);
        $role->role_name = $this->request->getPost('name');
        $role->groups = $this->request->getPost('group');
        saveRole($role);
        return redirect('roles');
    }

    /**
     * @throws ReflectionException
     */
    public function store(): RedirectResponse
    {
        $roleName = $this->request->getPost('name');
        $role = new Role();
        $roleModel = new RoleModel();
        $role->role_id = Uuid::uuid4();
        $role->role_name = $roleName;
        $roleModel->insert($role);
        $groups = $this->request->getPost('group');
        foreach ($groups as $group) {
            $groupModel = new GroupModel();
            $groupModel->insert(createGroupEntity($group, $role->role_id));
        }

        return redirect('roles');
    }

    public function delete($roleId): RedirectResponse
    {
        deleteRole($roleId);
        return redirect("roles");
    }
}