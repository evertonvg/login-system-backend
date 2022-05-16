<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
     public function create()
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }
    public function store(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            if(Auth::user()->email_verified_at==NULL){
                return response()->json([
                    'message'=>'Seu email não foi validado.'
                ], 401);
            }else{
                $request->session()->regenerate();
                return response()->json([
                    'message'=>'Bem vindo '.Auth::user()->name
                ], 200);
            }
            
        }else{
            return response()->json([
                'message'=>'Usuário ou senha invalidos'
            ], 401);
        }
        
    }


    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
