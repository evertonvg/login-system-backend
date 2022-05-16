<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        // return Inertia::render('Auth/ForgotPassword', [
        //     'status' => session('status'),
        // ]);
        return;
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status == Password::RESET_LINK_SENT) {
                return response()->json([
                'message'=>'Um email de recuperação foi mandado para o email informado, caso ele exista.'
            ], 200);
        }

    }
}
