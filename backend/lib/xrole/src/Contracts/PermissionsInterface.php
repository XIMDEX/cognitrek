<?php

namespace Ximdex\Xrole\Contracts;

interface PermissionsInterface {
    public function hasPermission($permission);
}