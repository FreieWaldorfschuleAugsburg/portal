<?php

use App\Entities\CredentialField;
use App\Entities\Credentials;
use App\Models\CredentialModel;
use App\Models\CredentialFieldModel;
use CodeIgniter\HTTP\IncomingRequest;
use Ramsey\Uuid\Uuid;

/**
 * @throws ReflectionException
 * @throws \App\Models\AuthException
 *
 */


function getAllCredentialsForRoles($roles = null, $filter = null): array

{
    $admin = session('ADMIN');
    $credentialBuilder = db_connect()->table('portal_credentials_joined');
    $allCredentials = [];
    if (!$filter) {
        $allCredentials = $credentialBuilder->get()->getResult();
    } else {
        foreach ($filter as $index => $filterValue) {
            $filteredResults = $credentialBuilder->getWhere([$index => $filterValue])->getResult();
            foreach ($filteredResults as $filteredResult) {
                if (!in_array($filteredResult, $allCredentials)) {
                    $allCredentials[] = $filteredResult;
                }
            }
        }
    }
    $credentials = [];
    foreach ($allCredentials as $credential) {
        $credential->credential_fields = getCredentialFields($credential->credential_id);
        if (!$admin) {
            if ($credential->role_id != null) {
                if ($roles != null) {
                    foreach ($roles as $role) {
                        if ($credential->role_id === $role) {
                            $credentials[] = $credential;
                        }
                    }
                }
            } else {
                $credentials[] = $credential;
            }
        } else {
            $credentials[] = $credential;
        }


    }
    return $credentials;


}

/**
 * @throws \App\Models\AuthException
 */
function getCredentials($credentialId, $roles = null): array|object
{
    $admin = session('ADMIN');
    $credentialModel = new CredentialModel();
    $credential = $credentialModel->find($credentialId);
    $credential->credential_fields = getCredentialFields($credential->credential_id);

    if ($admin || $credential->role_id == null) {
        return $credential;
    } else {
        if ($roles != null) {
            foreach ($roles as $role) {
                if ($credential->role_id === $role) {
                    return $credential;
                }
            }
        }
    }

    throw new \App\Models\AuthException('noPermissions');
}


function getCredentialFields(string $credentialId)
{
    $credentialFieldModel = new CredentialFieldModel();
    return $credentialFieldModel->where(['credential_id' => $credentialId])->findAll();


}


function createCredentials(\CodeIgniter\HTTP\IncomingRequest $request, string $credentialId): Credentials
{
    $credentialEntity = new Credentials();
    $credentialEntity->credential_id = $credentialId;
    $credentialEntity->credential_name = $request->getPost('name');
    $credentialEntity->documentation_url = $request->getPost('documentation');
    $credentialEntity->role_id = strlen($request->getPost('role')) > 1 ? $request->getPost('role') : null;
    $credentialEntity->show_on_home = $request->getPost('show_on_home') ? filter_var($request->getPost('show_on_home'), FILTER_VALIDATE_BOOLEAN) : false;
    return $credentialEntity;
}


/**
 * @throws ReflectionException
 */
function insertCredentials(Credentials $credentials, array $credentialFields): void
{
    $credentialModel = new CredentialModel();
    $credentialModel->insert($credentials);
    insertCredentialFields($credentialFields);
}

/**
 * @throws ReflectionException
 */
function updateCredentials(string $credentialId, IncomingRequest $request, \App\Entities\Credentials $credentials): bool
{
    $credentialModel = new CredentialModel();
    $credentialFields = createCredentialFields($request, $credentialId);
    updateCredentialFields($credentialId, $credentialFields);
    return $credentialModel->update($credentialId, $credentials);
}

function deleteCredentials(string $credentialId): void
{
    $credentialModel = new CredentialModel();
    $credentialModel->delete($credentialId);
}


function createCredentialFields(IncomingRequest $request, string $credentialId): array
{
    $credentialFields = [];
    $field_names = $request->getPost('field_name');
    $field_values = $request->getPost('field_value');
    foreach ($field_names as $index => $field_name) {
        $field_value = $field_values[$index];
        $credentialFieldEntity = new CredentialField;
        $credentialFieldEntity->field_id = Uuid::uuid4();
        $credentialFieldEntity->field_name = $field_name;
        $credentialFieldEntity->field_value = $field_value;
        $credentialFieldEntity->credential_id = $credentialId;
        $credentialFields[] = $credentialFieldEntity;

    }
    return $credentialFields;
}


/**
 * @throws ReflectionException
 */
function insertCredentialFields(array $credentialFields): void
{
    $credentialFieldModel = new CredentialFieldModel();
    try {
        $credentialFieldModel->insertBatch($credentialFields);
    } catch (ReflectionException $exception) {

    }
}

/**
 * @throws ReflectionException
 */
function updateCredentialFields(string $credentialId, array $credentialFields): void
{
    $credentialFieldModel = new CredentialFieldModel();
    $credentialFieldModel->where('credential_id', $credentialId)->delete();
    $credentialFieldModel->insertBatch($credentialFields);
}










