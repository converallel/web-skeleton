<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Skeleton extends AbstractMigration
{

    public $autoId = false;

    public function up()
    {

        $this->table('contacts')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('type', 'enum', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'values' => ['Email', 'Mobile']
            ])
            ->addColumn('contact', 'string', [
                'default' => null,
                'limit' => 254,
                'null' => false,
            ])
            ->addColumn('verified_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'contact',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('devices')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('uuid', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('deleted_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->addIndex(
                [
                    'uuid',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('files')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('mime_type', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('size', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('notes', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('published', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
                'update' => 'CURRENT_TIMESTAMP',
            ])
            ->addColumn('deleted_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('http_status_codes')
            ->addColumn('code', 'integer', [
                'default' => null,
                'limit' => MysqlAdapter::INT_SMALL,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['code'])
            ->addColumn('definition', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->create();

        $this->table('locations')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('latitude', 'float', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 7,
            ])
            ->addColumn('longitude', 'float', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 7,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('iso_country_code', 'string', [
                'default' => null,
                'limit' => 30,
                'null' => true,
            ])
            ->addColumn('country', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('postal_code', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('administrative_area', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('sub_administrative_area', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('locality', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('sub_locality', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('thoroughfare', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('sub_thoroughfare', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('time_zone', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addIndex(
                [
                    'latitude',
                    'longitude',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('logins')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('ip_address', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->addColumn('device_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('browser', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('latitude', 'float', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 7,
            ])
            ->addColumn('longitude', 'float', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 7,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_id',
                    'device_id',
                    'created_at'
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'device_id',
                ]
            )
            ->create();

        $this->table('logs')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('ip_address', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->addColumn('request_method', 'enum', [
                'default' => null,
                'limit' => 10,
                'null' => false,
                'values' => ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH']
            ])
            ->addColumn('request_url', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('request_headers', 'json', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('request_body', 'json', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status_code', 'integer', [
                'default' => null,
                'limit' => MysqlAdapter::INT_SMALL,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->addIndex(
                [
                    'status_code',
                ]
            )
            ->create();

        $this->table('oauth_access_tokens')
            ->addColumn('id', 'char', [
                'default' => null,
                'limit' => 80,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('oauth_client_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('revoked', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
                'signed' => false
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('expires_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'oauth_client_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('oauth_access_tokens_oauth_scopes')
            ->addColumn('oauth_access_token_id', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('oauth_scope_id', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->addPrimaryKey(['oauth_access_token_id', 'oauth_scope_id'])
            ->addIndex(
                [
                    'oauth_scope_id',
                ]
            )
            ->create();

        $this->table('oauth_authorization_codes')
            ->addColumn('id', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('oauth_client_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('redirect_uri', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('id_token', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('revoked', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
                'signed' => false
            ])
            ->addColumn('expires_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'oauth_client_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('oauth_authorization_codes_oauth_scopes')
            ->addColumn('oauth_authorization_code_id', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('oauth_scope_id', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->addPrimaryKey(['oauth_authorization_code_id', 'oauth_scope_id'])
            ->addIndex(
                [
                    'oauth_scope_id',
                ]
            )
            ->create();

        $this->table('oauth_clients')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('secret', 'string', [
                'default' => null,
                'limit' => 80,
                'null' => false,
            ])
            ->addColumn('redirect_uri', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('grant_type', 'set', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'values' => ['authorization_code', 'client_credentials', 'implicit', 'password', 'refresh_token']
            ])
            ->addColumn('revoked', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
                'signed' => false
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('oauth_clients_oauth_scopes')
            ->addColumn('oauth_client_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('oauth_scope_id', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->addPrimaryKey(['oauth_client_id', 'oauth_scope_id'])
            ->addIndex(
                [
                    'oauth_scope_id',
                ]
            )
            ->create();

        $this->table('oauth_refresh_tokens')
            ->addColumn('id', 'char', [
                'default' => null,
                'limit' => 80,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('oauth_access_token_id', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('revoked', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
                'signed' => false
            ])
            ->addColumn('expires_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'oauth_access_token_id',
                ]
            )
            ->create();

        $this->table('oauth_scopes')
            ->addColumn('id', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->create();

        $this->table('search_histories')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('query', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('searched_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
                'update' => 'CURRENT_TIMESTAMP',
            ])
            ->addIndex(
                [
                    'user_id',
                    'type',
                    'query',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'searched_at',
                ]
            )
            ->create();

        $this->table('time_zones')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('latitude', 'float', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 7,
            ])
            ->addColumn('longitude', 'float', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 7,
            ])
            ->addColumn('identifier', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addIndex(
                [
                    'latitude',
                    'longitude',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('users')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 30,
                'null' => true,
            ])
            ->addColumn('password', 'char', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('failed_login_attempts', 'integer', [
                'default' => 0,
                'limit' => MysqlAdapter::INT_TINY,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('given_name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('family_name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('birthdate', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('gender', 'enum', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'values' => ['Male', 'Female', 'Other'],
            ])
            ->addColumn('location_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('profile_image_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('deleted_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'username',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'location_id',
                ]
            )
            ->addIndex(
                [
                    'profile_image_id',
                ]
            )
            ->create();

        $this->table('contacts')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('devices')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('files')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('logins')
            ->addForeignKey(
                'device_id',
                'devices',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('logs')
            ->addForeignKey(
                'status_code',
                'http_status_codes',
                'code',
                [
                    'update' => 'CASCADE',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('oauth_access_tokens')
            ->addForeignKey(
                'oauth_client_id',
                'oauth_clients',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('oauth_access_tokens_oauth_scopes')
            ->addForeignKey(
                'oauth_access_token_id',
                'oauth_access_tokens',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'oauth_scope_id',
                'oauth_scopes',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('oauth_authorization_codes')
            ->addForeignKey(
                'oauth_client_id',
                'oauth_clients',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('oauth_authorization_codes_oauth_scopes')
            ->addForeignKey(
                'oauth_authorization_code_id',
                'oauth_authorization_codes',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'oauth_scope_id',
                'oauth_scopes',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('oauth_clients')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('oauth_clients_oauth_scopes')
            ->addForeignKey(
                'oauth_client_id',
                'oauth_clients',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'oauth_scope_id',
                'oauth_scopes',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('oauth_refresh_tokens')
            ->addForeignKey(
                'oauth_access_token_id',
                'oauth_access_tokens',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('search_histories')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('users')
            ->addForeignKey(
                'location_id',
                'locations',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'profile_image_id',
                'files',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'SET_NULL'
                ]
            )
            ->update();
    }

    public function down()
    {
        $this->table('contacts')
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('devices')
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('files')
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('logins')
            ->dropForeignKey(
                'device_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('logs')
            ->dropForeignKey(
                'status_code'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('oauth_access_tokens')
            ->dropForeignKey(
                'oauth_client_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('oauth_access_tokens_oauth_scopes')
            ->dropForeignKey(
                'oauth_access_token_id'
            )
            ->dropForeignKey(
                'oauth_scope_id'
            )->save();

        $this->table('oauth_authorization_codes')
            ->dropForeignKey(
                'oauth_client_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('oauth_authorization_codes_oauth_scopes')
            ->dropForeignKey(
                'oauth_authorization_code_id'
            )
            ->dropForeignKey(
                'oauth_scope_id'
            )->save();

        $this->table('oauth_clients')
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('oauth_clients_oauth_scopes')
            ->dropForeignKey(
                'oauth_client_id'
            )
            ->dropForeignKey(
                'oauth_scope_id'
            )->save();

        $this->table('oauth_refresh_tokens')
            ->dropForeignKey(
                'oauth_access_token_id'
            )
            ->save();

        $this->table('search_histories')
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('users')
            ->dropForeignKey(
                'location_id'
            )
            ->dropForeignKey(
                'profile_image_id'
            )->save();

        $this->table('contacts')->drop()->save();
        $this->table('devices')->drop()->save();
        $this->table('files')->drop()->save();
        $this->table('http_status_codes')->drop()->save();
        $this->table('locations')->drop()->save();
        $this->table('logins')->drop()->save();
        $this->table('logs')->drop()->save();
        $this->table('oauth_access_tokens')->drop()->save();
        $this->table('oauth_access_tokens_oauth_scopes')->drop()->save();
        $this->table('oauth_authorization_codes')->drop()->save();
        $this->table('oauth_authorization_codes_oauth_scopes')->drop()->save();
        $this->table('oauth_clients')->drop()->save();
        $this->table('oauth_clients_oauth_scopes')->drop()->save();
        $this->table('oauth_refresh_tokens')->drop()->save();
        $this->table('oauth_scopes')->drop()->save();
        $this->table('search_histories')->drop()->save();
        $this->table('time_zones')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
