<?php

namespace Sbehnfeldt\Webapp\PropelDbEngine;

use Sbehnfeldt\Webapp\PropelDbEngine\Base\User as BaseUser;

/**
 * Skeleton subclass for representing a row from the 'users' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class User extends BaseUser
{
    /**
     * @param string $slug
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * Determine whether the current user has the specified permission
     */
    public function hasPermission(string $slug): bool
    {
        $perm = PermissionQuery::create()
            ->findBySlug($slug);

        $p = UserPermissionQuery::create()
            ->filterByPermission($perm)
            ->filterByUser($this)
            ->find();

        return (!$p->isEmpty());
    }
}
