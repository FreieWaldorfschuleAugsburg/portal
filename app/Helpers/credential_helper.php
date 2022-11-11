<?php

use App\Entities\CredentialField;
use App\Entities\Credentials;
use App\Models\CredentialModel;
use CodeIgniter\HTTP\IncomingRequest as IncomingRequestAlias;
use Ramsey\Uuid\Uuid;

/**
 * @throws ReflectionException
 *
 */


function getAllCredentials(): array
{
    $credentialBuilder = db_connect()->table('portal_credentials_joined');
    $credentialFieldBuilder = db_connect()->table('portal_credentials_custom_fields');
    $credentialsArray = $credentialBuilder->get()->getResult();
    $resultsArray = [];
    foreach ($credentialsArray as $credential) {
        $credentialFieldArray = getCredentialFields($credential->credential_id);
        $credential->credential_fields = $credentialsArray;
        if (!in_array($credential, $resultsArray)) {
            $resultsArray[] = $credential;
        }
    }
    return $resultsArray;


}

function getCredentials($credentialId): array|object
{
    $credentialModel = new CredentialModel();
    $credentials = $credentialModel->find($credentialId);
    $credentialFields = getCredentialFields($credentialId);
    $credentials->credential_fields = $credentialFields;
    return $credentials;
}


function getCredentialFields(string $credentialId)
{
    $builder = db_connect()->table('portal_credentials_custom_fields');
    return $builder->getWhere(['credential_id' => $credentialId])->getResult();
}


function createCredentials(\CodeIgniter\HTTP\IncomingRequest $request): Credentials
{
    $credentialEntity = new Credentials();
    $credentialEntity->credential_id = Uuid::uuid4();
    $credentialEntity->credential_name = $request->getPost('name');
    $credentialEntity->role_id = strlen($request->getPost('role')) > 1 ? $request->getPost('role') : null;

    return $credentialEntity;
}


/**
 * @throws ReflectionException
 */
function insertCredentials(Credentials $credentials, array $credentialFields): void
{
    $credentialModel = new CredentialModelAlias();
    $credentialModel->insert($credentials);
    insertCredentialFields($credentialFields);
}

/**
 * @throws ReflectionException
 */
function updateCredentials(string $credentialId, \App\Entities\Credentials $credentials): bool
{
    $credentialModel = new CredentialModelAlias();
    return $credentialModel->update($credentialId, $credentials);
}

function deleteCredentials(string $credentialId): void
{
    $credentialModel = new CredentialModelAlias();
    $credentialModel->delete($credentialId);
}


function createCredentialFields(IncomingRequestAlias $request, string $credentialId): array
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
    $credentialFieldModel = new CredentialModelAlias();
    try {
        $credentialFieldModel->insertBatch($credentialFields);
    } catch (ReflectionException $exception) {

    }
}

/**
 * @throws ReflectionException
 */
function updateDynamicFields(string $credentialId, array $dynamicFieldArray): void
{
    $credentialFieldModel = new CredentialModelAlias();
    $credentialFieldModel->updateBatch($dynamicFieldArray);
}










