<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\Database\Exceptions\DataException;
use ReflectionException;
use function App\Helpers\getAllRoles;
use function App\Helpers\getUserRoles;
use Ramsey\Uuid\Uuid;

class CredentialController extends BaseController
{

    /**
     * @throws AuthException
     * @throws ReflectionException
     */
    public function index(): string
    {
        $roles = getUserRoles();
        $credentials = getAllCredentialsForRoles($roles);
        return $this->render('credentials/CredentialsView', ['credentials' => $credentials]);

    }

    /**
     * @throws AuthException
     */
    public function create(): string
    {
        return $this->render('credentials/CreateCredentialsView', ['roles' => getAllRoles()]);
    }

    /**
     * @throws AuthException
     */
    public function view(string $credentialId): string
    {
        $roles = getUserRoles();
        $credentials = getCredentials($credentialId, $roles);
        return $this->render('credentials/ViewCredentialsView', ['credentials' => $credentials]);

    }


    /**
     * @throws AuthException
     */
    public function edit(string $credentialId): string
    {
        $credentials = getCredentials($credentialId);
        return $this->render('credentials/EditCredentialsView', ['credentials' => $credentials, 'roles' => getAllRoles()]);

    }


    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        $request = $this->request;
        $credentials = createCredentials($request, Uuid::uuid4());
        $credentialFields = createCredentialFields($request, $credentials->credential_id);
        try {
            insertCredentials($credentials, $credentialFields);
        } catch (ReflectionException $e) {
        }
        return redirect('credentials');
    }

    public function update(string $credentialId): \CodeIgniter\HTTP\RedirectResponse
    {
        $request = $this->request;
        try {
            $credentials = createCredentials($request, $credentialId);
            updateCredentials($credentialId, $request, $credentials);
        } catch (ReflectionException $e) {
        }
        return redirect('credentials');
    }

    public function delete(string $credentialId): \CodeIgniter\HTTP\RedirectResponse
    {
        try {
            deleteCredentials($credentialId);
        } catch (DataException $exception) {

        }
        return redirect('credentials');
    }


}