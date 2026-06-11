<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show($id)
    {
        return 'User with ID:' . $id;
    }

    public function getUserNameEmail($username, $email)
    {
        return 'The username is: ' . $username . ' and Email: ' . $email;
    }


   
}
