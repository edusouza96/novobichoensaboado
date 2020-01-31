<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\UserRepository;

class UserController extends Controller
{

    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $users = $this->userRepository->findByFilter($request->all(), true);
        return view('user.index', compact('users'));
    }

    public function destroy($id)
    {
        try {
            $this->userRepository->destroy($id);
            return redirect()->route('user.index')->with('alertType', 'success')->with('message', 'Usuário Deletado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        } 
    }
   
}
