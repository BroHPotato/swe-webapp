<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index()
    {
        $logs = ["stringa1", "stringa2"];
        view('logs.index', compact('logs'));
    }
}
