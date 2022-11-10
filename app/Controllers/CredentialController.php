<?php

namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;
use function App\Helpers\getAllRoles;
use function App\Helpers\protectRoute;

class CredentialController extends BaseController
{

    public function index()
    {
        $credentials = getAllCredentials();

        return $this->render('credentials/CredentialsView', ['credentials' => $credentials]);

    }

    public function create()
    {
        return $this->render('credentials/CreateCredentialsView', ['roles' => getAllRoles()]);
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
        $credentials = createCredentials($request);
        $credentialFields = createCredentialFields($request, $credentials->credential_id);
        try {
            insertCredentials($credentials, $credentialFields);
        } catch (\ReflectionException $e) {
        }
        return redirect('credentials');
    }


}