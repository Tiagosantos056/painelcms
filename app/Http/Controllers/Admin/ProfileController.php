<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $loggedId = intval( Auth::id() );

        $user = User::find($loggedId);

        if($user){
            return view('admin.profile.index', [
                'user'=>$user
                ]);
        }
        
        return redirect()->route('admin');
        
    }

    public function save(Request $request)
    {
        $loggedId = intval( Auth::id() );
        $user = User::find($loggedId);

        
        if($user){
            $data = $request->only([
                'name',
                'email',
                'password', 
                'password_confirmation'
            ]);

            $validator = Validator::make([
                'name'  =>  $data['name'],
                'email' =>  $data['email']
            ], [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'max:100'],
            ]);

            // 1. Alrteração do nome
            $user->name = $data['name'];
            
            // 2. Alteração do E-mail
            if($user->email != $data['email']){
                
                // 2.1 Primeiro, verificar se o e-mail foi alterado
                $hasEmail = User::where('email', $data['email'])->get();
                
                // 2.3 Se não existrir, alteramos
                if(count($hasEmail) === 0){
                    $user->email = $data['email'];
                } else {
                    // 2.2 Verificamos se o novo e-mail já exist
                    $validator->errors()->add('email', __('validation.unique', [
                        'attribute' => 'email'
                    ]));                  
                }
            }
            
            // 3. Alteração da senha
            // 3.1 Verifica se o usuário digitou alguma senha
            if(!empty($data['password'])){

                // 3.2 Verifica se a marcação está OK
                if(strlen($data['password']) >= 4){
                    if($data['password'] === $data['password_confirmation']){
                        // 3.3 Altera a senha
                        $user->password = Hash::make($data['password']);
                    } else {
                        $validator->errors()->add('password', __('validation.confirmed', [
                            'attribute' => 'password'
                        ]));
                    }
                    
                } else {
                    $validator->errors()->add('password', __('validation.min.string', [
                        'attribute' => 'password',
                        'min' => 4
                    ]));
                }
            }
            
            if(count($validator->errors()) > 0){
                return redirect()->route('profile',[
                    'user' => $loggedId
                ])->withErrors($validator);
            }

            $user->save();

            return redirect()->route('profile')
            ->with('warning', 'Informações alteradas com sucesso!!');

        } else {
            return redirect()->route('profile');
        }
    }
}
