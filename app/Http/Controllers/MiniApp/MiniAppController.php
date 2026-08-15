<?php

namespace App\Http\Controllers\MiniApp;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MiniAppController extends Controller
{

    public function index(): View
    {

        return view('miniapp.dashboard');

    }

}
