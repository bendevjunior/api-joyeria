<?php
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

Route::get('/', function () {
    $user = App\User::find(2);
    $to = 'contato@joyeria.com.br';
    $mail = Mail::to($to)->queue(new WelcomeMail($user, 'password'));
    dd($user);
});