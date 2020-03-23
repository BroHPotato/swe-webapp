<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
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
     * @return Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('settings.edit', compact('user'));
    }

    public function update(){
        $data = request()->validate([

        ]);
        $user = Auth::user();
        $user->fill($data);
        $request = new Client([
            'base_uri' => 'localhost:9999',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.session()->get('token')
            ]
        ]);

        $request->put('/user/'.$user->getAuthIdentifier().'/update', [
            'body' => $user
        ]);
    }

}
