<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TestController extends Controller
{
    public function index()
    {
        phpinfo();
    }

    public function pickadate()
    {
        return Inertia::render('Testy/PickDate', [

        ]);
    }
}
