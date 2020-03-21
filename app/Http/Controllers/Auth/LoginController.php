<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo(){
        return RouteServiceProvider::DASHBOARD;
    }



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        if ($request->exists('code'))
            $credentials = $request->only('code');
        else
            $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect(RouteServiceProvider::DASHBOARD);;
        }
    }
    public function showTfaForm()
    {
        return view('auth.tfaLogin');
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     * @return Response
     *
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->exists('code')){
            throw ValidationException::withMessages([
                'code' => ['Codice non valido'],
            ]);
        }
        else{
            throw ValidationException::withMessages([
                $this->username() => ['Opssssss qualcosa è andato storto! 👀'/*trans('auth.failed')*/],
            ]);
        }
    }

    protected function validateLogin(Request $request)
    {
        if ($request->exists('code')){
            $request->validate([
               'code' => 'required|string'
            ]);
        }
        else{
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);
        }
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        if ($request->exists('code')){
            return $request->only('code');
        }
        else{
            return $request->only($this->username(), 'password');
        }
    }
}
