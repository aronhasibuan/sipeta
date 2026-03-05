<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DataflowController extends Controller
{
    public function landing_page()
    {
        return redirect('/login');
    }
    
    public function login(){
        return view('login');
    }
    
    public function dashboard(){
        $petugas = User::where('is_admin', false)->get();
        return view('dashboard', compact('petugas'));
    }

    public function beranda_petugas()
    {
        $user = Auth::user();
        return view('beranda_petugas', compact('user'));
    }
}
