<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\commonFunction;

class homeController extends commonFunction
{
    public function index()
    {
        try {

            return view('home.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }
}
