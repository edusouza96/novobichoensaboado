<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\UserRepository;
use BichoEnsaboado\Http\Requests\UserCreateRequest;
use BichoEnsaboado\Services\AuthenticateAcessAdmin;

class UserController extends Controller
{

    /** @var UserRepository */
    private $userRepository;

    /** @var AuthenticateAcessAdmin */
    private $authenticateAcessAdmin;

    public function __construct(UserRepository $userRepository, AuthenticateAcessAdmin $authenticateAcessAdmin)
    {
        $this->userRepository = $userRepository;
        $this->authenticateAcessAdmin = $authenticateAcessAdmin;
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

    public function create()
    {
        $user = $this->userRepository->newInstance();
        return view('user.create', compact('user'));
    }

    public function store(UserCreateRequest $request)
    {
        try {
            $this->userRepository->create($request->only('name', 'nickname', 'password', 'role_id', 'store'));
            return redirect()->route('user.index')->with('alertType', 'success')->with('message', 'Usuário Cadastrado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        return view('user.edit', compact('user'));
    }

    public function update(UserCreateRequest $request, $id)
    {
        try {
            $this->userRepository->update($id, $request->only('name',  'nickname', 'password', 'role_id', 'store'));
            return redirect()->route('user.index')->with('alertType', 'success')->with('message', 'Usuário Atualizado.');
        } catch (Exception $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function acessAdmin(Request $request)
    {
        $response = $this->authenticateAcessAdmin->validate($request->only('username', 'password'));

        if($response)
            return response()->json($response);

        throw new \Exception("Não Autorizado", 403);
        
    }

    public function allEmployeeUsers()
    {
        try {
            $users = $this->userRepository->getEmployees();
            return response()->json($users);
        } catch (\InvalidArgumentException $e) {
        }
    }
   
}
