<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Mail;
use App\Mail\HogeShipped;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function send()
    {
        $options = [
            'from' => 't_nakajima@bbmedia.co.jp',
            'from_jp' => 'ほげほげ',
            'to' => 'tatsu56432@gmail.com',
            'subject' => 'テストメール',
            'template' => 'email.hoge.mail', // resources/views/emails/hoge/mail.blade.php
        ];

        $data = [
            'hoge' => 'hogehoge',
        ];

        Mail::to($options['to'])->send(new HogeShipped($options, $data));

        return "mailの送信を完了しました。";
    }


}
