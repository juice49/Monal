<?php
namespace Monal\Repositories;
/**
 * Eloquent User Groups Repository.
 *
 * @author Arran Jacques
 */

class EloquentUserGroupsRepository extends \Eloquent
{
    /**
     * The database table used by the repository.
     *
     * @var     String
     */
    protected $table = 'user_groups';

    /**
     * Relationships to eager load.
     *
     * @var     String
     */
    protected $with = array('groupPermissions');

    /**
     * Table relationship.
     *
     * @return  Mixed
     */
    public function groupPermissions()
    {
        return $this->hasOne('Monal\Repositories\EloquentUserGroupPermissionsRepository', 'group');
    }
}