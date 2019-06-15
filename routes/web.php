<?php
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

Route::get('/', function () {
    $user = App\User::find(1);
    $to = 'gulyfurlan@gmail.com';
    $mail = Mail::to($to)->queue(new WelcomeMail($user, 'password'));
    dd($mail);
});