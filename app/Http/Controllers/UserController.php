<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index() {
        $users = User::where('admin', false)->get();
        return view('admin.users', ['users' => $users]);
    }

    public function admin() {
        if (Auth::user()->admin) {
            return redirect('/admin');
        } else {
            return redirect('/');
        }
    }
    
    public function register(Request $r) {

        $r->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirm' => 'required|same:password'
        ]);

        $u = new User;
        $u->name = $r->name;
        $u->email = $r->email;
        $u->password = Hash::make(htmlspecialchars($r->password));

        $u->save();

        if (Auth::attempt(['email' => $r->email, 'password' => htmlspecialchars($r->password)])) {
            $r->session()->regenerate();
            return redirect('/');
        } else {
            return back()->withErrors(['msg' => 'Registration Failed']);
        }

    }

    public function login(Request $r) {

        $r->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $r->email, 'password' => htmlspecialchars($r->password)])) {
            $r->session()->regenerate();
            if (Auth::user()->admin) {
                return redirect('/admin');
            } else {
                return redirect('/');
            }
        } else {
            return back()->with(['msg' => 'No Record Found']);
        }

    }

    public function logout(Request $r) {

        Auth::logout();

        $r->session()->invalidate();

        $r->session()->regenerateToken();

        return redirect('/');

    }

    public function ban(Request $r) {

        $id = $r->id;
        
        $u = User::find($id);
        
        $u->banned = !$u->banned;

        $u->save();

        return $u;
        
    }

}
