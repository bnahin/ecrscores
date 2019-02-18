<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Helpers\AuthHelper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Show admin select page.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $teachers = User::orderBy('last_name', 'DESC')->get();

        return view('admin-select', compact('teachers'));
    }

    /**
     * Authenticate as teacher.
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);
        $email = $request->email;

        $user = User::where('email', $email);
        Auth::login($user->first());

        return redirect()->route('home');
    }
}
