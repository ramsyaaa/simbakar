<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth as AuthFacade;

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
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        // $this->middleware('guest')->except('logout');
    }

    public function index(){

        return view('admin.login');
    }

    public function authenticate(Request $request){
        // Validasi data yang dikirimkan oleh pengguna
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus berformat email yang valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            Alert::error('Error', 'Email atau password salah');
            return redirect()->route('login');
        }
        if($user->status ==  false){
            Alert::error('Error', 'Email tidak dapat digunakan untuk login');
            return redirect()->route('login');
        }

        if( Hash::check($request->password,$user->password) ){

            auth()->login($user);
            Alert::success('Success', 'Login Berhasil');
            return redirect()->route('admin.dashboard');

        }else{
            Alert::error('Error', 'Email atau password salah');
            return redirect()->route('login');

        }
    }

    public function logout(Request $request){

        Alert::success('Success', 'Logout Berhasil');
        AuthFacade::logout();
        // Jika Anda menggunakan session, Anda juga dapat menghapusnya di sini
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect(route('login')); // Atau halaman manapun yang Anda inginkan setelah logout
    }
}
