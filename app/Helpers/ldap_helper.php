<?php

namespace App\Helpers;

use App\Models\LDAPException;
use LdapRecord\Auth\BindException;
use LdapRecord\Configuration\ConfigurationException;
use LdapRecord\Connection;
use LdapRecord\Container;
use LdapRecord\LdapRecordException;

/**
 * Create LDAP connection
 *
 * @return Connection
 * @throws LDAPException
 */
function createLDAPConnection(): Connection
{
    try {
        return new Connection([
            'hosts' => [getenv('ldap.host')],
            'base_dn' => getenv('ldap.baseDN'),
            'username' => getenv('ldap.admin.username'),
            'password' => getenv('ldap.admin.password'),
            'port' => 636,
            'protocol' => 'ldaps://',
            'use_tls' => true,
            'options' => [
                LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_ALLOW
            ],
        ]);
    } catch (ConfigurationException $e) {
        log_message('error', 'Error while creating LDAP connection {exception}', ['exception' => $e]);
        throw new LDAPException('Error while creating LDAP connection');
    }
}

/**
 * Open LDAP connection
 *
 * @throws LDAPException
 */
function openLDAPConnection(): Connection
{
    // If container already holds connection
    if (Container::hasConnection(Container::getDefaultConnectionName())) {
        return Container::getDefaultConnection();
    }

    // Create new connection
    $connection = createLDAPConnection();
    try {
        $connection->connect();
    } catch (BindException|LdapRecordException $e) {
        log_message('error', 'Error binding to LDAP server {exception}', ['exception' => $e]);
        throw new LDAPException('Error binding to LDAP server');
    }
    Container::addConnection($connection, Container::getDefaultConnectionName());

    return $connection;
}