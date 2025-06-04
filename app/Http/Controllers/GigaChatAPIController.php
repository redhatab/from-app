<?php

namespace App\Http\Controllers;

class GigaChatAPIController extends Controller
{
    public $token = null;

    public function index()
    {
        return view('gigachat');
    }

    public function getToken()
    {
        $url = 'https://ngw.devices.sberbank.ru:9443/api/v2/oauth';

        $headers = [
            'Authorization: Bearer ' . env('GIGACHAT_API_KEY'),
            'RqUID: ' . env('CLIENT_SECRET_KEY'),
            'Content-Type: application/x-www-form-urlencoded',
        ];

        $data = [
            'scope' => 'GIGACHAT_API_PERS'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true)["access_token"];
    }

    public function ask($promt)
    {
        $this->token = $this->getToken();

        $url = 'https://gigachat.devices.sberbank.ru/api/v1/chat/completions';

        $headers = [
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json',
        ];

        $messages[] = [
            'role' => 'user',
            'content' => $promt,
        ];

        $data = [
            'model' => 'GigaChat:latest',
            'messages' => $messages,
            'temperature' => 0.7,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true)['choices'][0]['message']['content'];
    }
}
