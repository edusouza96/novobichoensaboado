<?php

namespace BichoEnsaboado\Http\Controllers\Auth;

use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;

class DefinitionController extends Controller
{
   
    public function selectCurrenteStore()
    {
        return view('auth.select-store');
    }

    public function setCurrenteStore(Request $request)
    {
        session()->put('userLoggedCurrenteStore', $request->store_id);
        return redirect()->route('dashboard.index');
    }
}
