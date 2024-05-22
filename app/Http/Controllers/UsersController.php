<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;

class UsersController extends Controller
{

    public function index()
    {
        return Inertia::render('Dashboard', [
            'users' => User::query()
                ->when(FacadesRequest::input('search'), function ($query, $search) {
                    $query->where(function ($subquery) use ($search) {
                        $subquery->where('email', 'like', "%{$search}%");
                    });
                })->latest()
                ->paginate(5),
            'filters' => FacadesRequest::only(['search'])
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'phone' => 'required',
        ]);

        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'last_name' => $request->input('last_name'),
                'password' => Hash::make($request->input('password')),
                'phone' => $request->input('phone'),
            ]);
            return redirect()->route('users.index')->with('success', 'User created successfuly');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
        ]);

        try {
            // Obtener el usuario por su ID
            $user = User::find($id);

            // Crear un arreglo con los campos que se actualizarán
            $updateData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'last_name' => $request->input('last_name'),
                'phone' => $request->input('phone'),
            ];

            // Verificar si se proporcionó una nueva contraseña
            if ($request->filled('password')) {
                // Encriptar la nueva contraseña y añadirla al arreglo
                $updateData['password'] = Hash::make($request->input('password'));
            }

            // Actualizar el usuario con los datos del arreglo
            $user->update($updateData);


            return redirect()->route('users.index')->with('success', 'User updated successfuly');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect()->route('users.index')->with('success', 'User deleted successfuly');
    }
}
