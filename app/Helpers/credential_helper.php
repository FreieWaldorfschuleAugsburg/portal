<?php

use App\Entities\CredentialField;
use CodeIgniter\HTTP\IncomingRequest as IncomingRequestAlias;
use Ramsey\Uuid\Uuid;

/**
 * @throws ReflectionException
 */
function insertCredentials(\App\Entities\Credentials $credentials)
{
    $credentialModel = new \App\Models\CredentialModel();
    return $credentialModel->insert($credentials);
}

/**
 * @throws ReflectionException
 */
function updateCredentials(string $credentialId, \App\Entities\Credentials $credentials): bool
{
    $credentialModel = new \App\Models\CredentialModel();
    return $credentialModel->update($credentialId, $credentials);
}

function deleteCredentials(string $credentialId): void
{
    $credentialModel = new \App\Models\CredentialModel();
    $credentialModel->delete($credentialId);
}


function getDynamicFields(IncomingRequestAlias $request, string $credentialId): array
{
    $dynamicFieldArray = [];
    $field_names = $request->getPost('field_name');
    $field_values = $request->getPost('field_value');
    foreach ($field_names as $index => $field_name) {
        $field_value = $field_values[$index];
        $credentialFieldEntity = new CredentialField;
        $credentialFieldEntity->field_id = Uuid::uuid4();
        $credentialFieldEntity->field_name = $field_name;
        $credentialFieldEntity->field_value = $field_value;
        $credentialFieldEntity->credential_id = $credentialId;
        $dynamicFieldArray[] = $credentialFieldEntity;

    }
    return $dynamicFieldArray;
}


/**
 * @throws ReflectionException
 */
function insertDynamicFields(array $dynamicFieldArray): void
{
    $credentialFieldModel = new \App\Models\CredentialFieldModel();
    try {
        $credentialFieldModel->insertBatch($dynamicFieldArray);
    } catch (ReflectionException $exception) {

    }
}

/**
 * @throws ReflectionException
 */
function updateDynamicFields(string $credentialId, array $dynamicFieldArray): void
{
    $credentialFieldModel = new \App\Models\CredentialFieldModel();
    $credentialFieldModel->updateBatch($dynamicFieldArray);
}










