<?php
namespace Ximdex\Xrole\Contracts;

interface JwtInterface
{
    public function decode($jwtToken): ?array;
}