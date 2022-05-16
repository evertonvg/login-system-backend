<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
 
    public function authenticate(Request $request){


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
            
        }

        return response()->json([
            'message'=>'Usuário ou senha invalidos'
        ], 401);
        
    }

    public function logout(Request $request){
        // auth()->user()->tokens()->delete();
        // Auth::guard('web')->logout();
        // return response(['message'=>'Deslogado com sucesso']);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'message'=>'Volte novamente!'
        ], 200);
    }

    public function register(Request $request){
        $userMail = User::where('email', '=', request('email'))->first(); 
        if ($userMail != null) {
                return response()->json([
                'message'=>'Email já em uso'
            ], 402);
        }

        $password = Hash::make(request('password'));
        $user = User::create(
            array('name' => request('name'), 'email' => request('email'), 'password' => $password)
        );

        Auth::login($user);
        if(!event(new Registered($user))){
            return;
        }

        
        // $request->user()->sendEmailVerificationNotification();
        // return;

        // $verificationUrl = 'teste validation';

        // $nome = 'Everton';
        // $email = 'evertoniee@yahoo.com.br';

        // $mail = Mail::send('emails.email_verification',['mensagem' => $verificationUrl,'email' => request('email'),'nome' => request('nome')],function($message) use ($nome,$email){
        //     $message->from($email, $nome);
        //     $message->to(request('email'));
        //     $message->subject('Email Verification');
        // });


        if($user){
            return response()->json([
                'message'=>'Um email de verificação foi mandado para o email indicado.'
            ], 201);
        }else{
            return response()->json([
                'message'=>'Usuário não pode ser criado por algum erro no sistema. Tente novamente mais tarde.'
            ], 226);
        }

        
    }

    public function me(Request $request)
    {
      return response()->json([
        'data' => $request->user(),
      ]);
    }

    public function forget(){
        
    }

    public function emailtest(){
        $nome = 'Everton';
        $email = 'evertoniee@yahoo.com.br';


        $mail = Mail::send('emails.email-teste',['mensagem' => 'oi','email' => 'evertoniee@yahoo.com.br'],function($message) use ($nome,$email){
            $message->from($email, $nome);
            $message->to('evertoniee@yahoo.com.br');
            $message->subject('Email - teste');
        });

        return 'ok';
    }
    
}
