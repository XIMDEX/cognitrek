<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcePolicy
{
    use HandlesAuthorization;

    public function view($user, $resource)
    {
        return in_array('view_resource', $user->permissions);
    }

    public function create($user)
    {
        return in_array('create_resource', $user->permissions);
    }

    public function update($user, $resource)
    {
        return in_array('update_resource', $user->permissions);
    }

    public function delete($user, $resource)
    {
        return in_array('delete_resource', $user->permissions);
    }
}