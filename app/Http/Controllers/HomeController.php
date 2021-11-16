<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class HomeController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $correo = Auth::user()->email;
        //return $correo;
        if (!isset(Auth::user()->email_verified_at)) {
            return view('auth.changepassword');
        }else{
            return view('home');
        }
        
    }

    public function iniciarPrimero(Request $request){
        //$correo = $request->email;
        //$contra = $request->password;
        //$contra1 = $request->password_confirm;
        $user = Auth::getUser();
        $this->validator($request->all())->validate();
        //return $correo;
        if ($request->get('password') == $request->get('password_confirmation')) {
            $user->password = $request->get('new_password');
            DB::table('users')->where('email', $request->get('email'))->update([
                'password' => Hash::make($request->get('password')),
                'email_verified_at' => Carbon::now()
            ]);
            Auth::guard()->logout();
            $request->session()->invalidate();
            return redirect('/login')->withInput()->with('message', 'Tu Contraseña se ha actualizado, por favor inicia sesion nuevamente');
        } else {
            return redirect()->back()->withErrors('Current password is incorrect');
        }
        
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|min:8|max:15|confirmed',
            'password_confirmation' => 'required',
        ],[
            'password.required'              => 'La contraseña es requerida',
			'password_confirmation.required' => 'La contraseña es requerida',
			'password.confirmed'             => 'Las contraseñas no coinciden',
        ]);
    }


    //vistas del landing-page TAX Solution Finance

  

}
