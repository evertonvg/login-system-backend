<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{

    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request)
    {
        
        $userMail = User::where('email', '=', request('email'))->first(); 
        if ($userMail != null) {
                return response()->json([
                'message'=>'Email já em uso'
            ], 402);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        if($user){
            return response()->json([
                // 'message'=>'Um email de verificação foi mandado para o email indicado.'
                'message' => 'Um email de verificação foi enviado, aguarde alguns minutos.'
            ], 201);
        }else{
            return response()->json([
                'message'=>'Usuário não pode ser criado por algum erro no sistema. Tente novamente mais tarde.'
            ], 418);
        }
    }
}
