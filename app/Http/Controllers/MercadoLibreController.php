<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class MercadoLibreController extends Controller
{

    public function refreshToken()
    {
        $response = Http::asForm()->post('https://api.mercadolibre.com/oauth/token', [
            'grant_type' => 'refresh_token',
            'client_id' => config('services.mercadolibre.client_id'),
            'client_secret' => config('services.mercadolibre.client_secret'),
            'refresh_token' => Session::get('mercadolibre_refresh_token'),
        ]);

        $data = $response->json();

        Session::put('mercadolibre_access_token', $data['access_token']);
        Session::put('mercadolibre_refresh_token', $data['refresh_token']);

        return $data;
    }


    public function redirectToAuth()
    {
        $appId = config('services.mercadolibre.client_id');
        $redirectUri = urlencode(config('services.mercadolibre.redirect'));
        $url = "https://auth.mercadolibre.com.mx/authorization?response_type=code&client_id={$appId}&redirect_uri={$redirectUri}";

        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        $code = $request->get('code');
        $response = Http::asForm()->post('https://api.mercadolibre.com/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.mercadolibre.client_id'),
            'client_secret' => config('services.mercadolibre.client_secret'),
            'code' => $code,
            'redirect_uri' => config('services.mercadolibre.redirect'),
        ]);
        $data = $response->json();

        // save tokens in sessions o db
        if (isset($data['access_token'])) {
            Session::put('meli_access_token', $data['access_token']);
            Session::put('meli_refresh_token', $data['refresh_token']);
            Session::put('meli_user_id', $data['user_id']);
        } else {
            dd(
                'Whoops!'
            );
        }


        redirect()->route('mercadolibre.account');
    }

    public function account()
    {
        $accessToken = Session::get('meli_access_token');

        $response = Http::withToken($accessToken)->get('https://api.mercadolibre.com/users/me');
        $user = $response->json();

        return response()->json($user);
    }
}
