<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Erro ao autenticar com ' . $provider);
        }

        // Verifica se usuário já existe
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            // Criar usuário se não existir
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'password' => null,
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ]);
        } else {
            // Atualiza provider e provider_id se necessário
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ]);
        }

        // Logar usuário
        Auth::login($user, true);

        return redirect('/registros');
    }
}
