<?php

namespace App\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface CustomAuthenticatable extends Authenticatable
{
    /**
     * Get the user's role.
     *
     * @return string
     */
    public function getRole();
}