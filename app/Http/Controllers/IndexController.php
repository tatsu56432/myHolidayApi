<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\User;// access Model


class IndexController extends Controller
{

    public function index() {

        $users = User::all()->toArray();
        return response($users);
    }

    public function getSearch($keyword) {
        $todos = Todo::where('title', 'LIKE', '%'.$keyword.'%')->get();
        return Response::json($todos);
    }

}