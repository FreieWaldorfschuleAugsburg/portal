<?php

namespace App\Controllers;

use App\Models\AuthException;
use App\Models\CredentialModel;
use CodeIgniter\HTTP\IncomingRequest;
use function App\Helpers\getAllRoles;
use function App\Helpers\getUserRoles;
use Ramsey\Uuid\Uuid;

class CredentialController extends BaseController
{

    /**
     * @throws \ReflectionException
     * @throws AuthException
     */
    public function index()
    {
        $roles = getUserRoles();
        $credentials = getAllCredentialsForRoles($roles);
        return $this->render('credentials/CredentialsView', ['credentials' => $credentials]);

    }

    public function create()
    {
        return $this->render('credentials/CreateCredentialsView', ['roles' => getAllRoles()]);
    }

    public function view(string $credentialId)
    {
        $roles = getUserRoles();
        $credentials = getCredentials($credentialId, $roles);
        return $this->render('credentials/ViewCredentialsView', ['credentials' => $credentials]);

    }


    public function edit(string $credentialId)
    {
        $credentials = getCredentials($credentialId);
        return $this->render('credentials/EditCredentialsView', ['credentials' => $credentials, 'roles' => getAllRoles()]);

    }


    /**
     * @throws \ReflectionException
     */
    public function store()
    {
        $request = $this->request;
        $credentials = createCredentials($request, Uuid::uuid4());
        $credentialFields = createCredentialFields($request, $credentials->credential_id);
        try {
            insertCredentials($credentials, $credentialFields);
        } catch (\ReflectionException $e) {
        }
        return redirect('credentials');
    }

    public function update(string $credentialId)
    {
        $request = $this->request;
        try {
            $credentialModel = new CredentialModel();
            $credentials = createCredentials($request, $credentialId);
//            echo "<pre>";
//            print_r($credentials);
//            echo "</pre>";
            updateCredentials($credentialId, $request, $credentials);
        } catch (\ReflectionException $e) {
        }
        return redirect('credentials');
    }


}