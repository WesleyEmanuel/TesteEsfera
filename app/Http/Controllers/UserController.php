<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $usersService;

    public function __construct(UsersService $usersService) {
        $this->usersService = $usersService;
    }

    public function index()
    {
        $users = $this->usersService->getAllUsers();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (Gate::allows('is-admin')) {
            return view('auth.register');
        }

        Gate::authorize('is-admin');
    }

    public function store(Request $request)
    {
        if (Gate::allows('is-admin')) {
            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:200'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:200', 'unique:'.User::class],
                'password' => ['required', 'min:8'],
                'status' => ['required', 'boolean'],
            ]);
    
            $user = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => $request->status, 
            ];
    
            $this->usersService->createUser($user);
    
            return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso');
        }

        Gate::authorize('is-admin');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::allows('is-admin')) {
            $resp = $this->usersService->deleteUser($id);

            if(isset($resp['error'])){
                return redirect()->route('users.index')->with('error', $resp['message']);
            }

            return redirect()->route('users.index')->with('success', 'Usuário excluido com sucesso');
        }

        Gate::authorize('is-admin');
    }
}
