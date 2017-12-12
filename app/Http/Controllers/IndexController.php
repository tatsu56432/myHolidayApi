<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\User;// access Model


class IndexController extends Controller
{
    public function index() {
        return '<p style="text-align: center;font-size: 30px;font-weight: bold">MyHolidayApi!</p>';
    }
}