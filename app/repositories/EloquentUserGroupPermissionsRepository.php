<?php
namespace Monal\Repositories;
/**
 * Eloquent User Group Permissions Repository.
 *
 * @author Arran Jacques
 */

class EloquentUserGroupPermissionsRepository extends \Eloquent
{
    /**
     * The database table used by the repository.
     *
     * @var     String
     */
    protected $table = 'user_group_permissions';
}