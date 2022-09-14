<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only(['phone','password']), $request->filled('remember'))) {
            return $this->authenticated($request);
        }

        $this->failed($request, $request->only(['phone','password']));
    }

    protected function authenticated(Request $request)
    {
        $request->session()->regenerate();

        return redirect('/');
    }

    protected function failed(Request $request, $credentials)
    {
        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());


//        Redis::set() URL::signedRoute('phone.confirm', ['user' => $user]);

        auth()->loginUsingId($user->id);
        return $this->authenticated($request);
    }


}
