<?php

namespace BichoEnsaboado\Http\Controllers;

use BichoEnsaboado\Models\Role;

class RoleController extends Controller
{

    public function allOptions()
    {
        try {
            $roles = Role::all();
            return response()->json($roles);
        } catch (\InvalidArgumentException $e) {
        }
    }
}
