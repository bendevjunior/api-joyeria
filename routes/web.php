<?php
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

Route::get('/', function () {
    $user = App\User::find(2);
    $mail = Mail::to($user->email)->queue(new WelcomeMail($user, 'password'));
    dd($mail);
});