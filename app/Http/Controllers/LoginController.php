<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('previous_url', URL::previous());
        return view('FrontEnd.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('FrontEnd.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check_email = array('email'=>$request->email_login, 'password'=>$request->password_login);
        $check_nickname= array('username'=>$request->email_login, 'password'=>$request->password_login);

        if(Auth::attempt($check_nickname) || Auth::attempt($check_email)){
            if (Auth::user()->level == 1) {


                return Redirect::to(Session::get('previous_url'))->with('message', ' Hi, '.Auth::user()->name.' ');

                // return redirect()->route('home')->with('message', ' Hi, '.Auth::user()->name.' ');


            }else{

                return redirect()->route('dashboard.index')->with('message', ' Hi, '.Auth::user()->name.' ');
            }
        }else{

            return redirect()->back()->withInput()->with('message_err', 'Tên đăng nhập hoặc mật khẩu không đúng!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
