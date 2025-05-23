<?php

namespace App\Http\Controllers\BackEnd;


use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(User::where('id','!=',Auth::user()->id)->orderBy('id','desc')->get())
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="edit_account" data-account_id="'.$data->id.'" class="btn btn-outline btn-primary"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="delete_account" data-account_id="'.$data->id.'" class="btn  btn-outline btn-danger delete"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->addColumn('status', function($data){
                    if ($data->isOnline()) {
                        $status = '<span class="tag-style expiry" style="font-weight: bold;">Online</span>';
                    }else{
                        $status = '<span class="tag-style expired" style="font-weight: bold;">Offline</span>';
                    }
                    return $status;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }

        // dd(mt_rand());
        return view('BackEnd.Account.account');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'user_name'=>'required|regex:/(^([a-zA-z]+)(\d+)?$)/u|unique:users,username',
            'level'=>'required',
            'password'=>'required',
            'email'=>'required|email|unique:users,email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $account = new User();
            if ($account) {
                $account->name = $request->name;
                $account->username = $request->user_name;
                $account->email = $request->email;
                $account->level = $request->level;
                $account->password = Hash::make($request->password);
                $account->save();

                return response()->json([
                    'status'=>200,
                    'message'=>'Add Account Successfully',
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if (request()->ajax()) {
            $account = User::find($id);

            $output = '';
            if ($account) {
                $output .= '
                  <p><label><img alt="image" class="img-thumbnail" src="'.url('backend/icon.png').'" height="48px" width="48px" /></label></p>
                  <p><label>Name: '.$account->name.'</label></p>
                  <p><label>User Name: '.$account->username.'</label></p>
                  <p><label>Phone : </label> '.$account->phone.'</p>
                ';

                // echo $output;
                return response()->json([
                    'data' => $output
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Account Not Found'
                ]);
            }
        }
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $account = User::findOrFail($id);
        if ($account) {
            return response()->json([
                'status'=>200,
                'profile_login'=>$account,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Account Not Found',
            ]);
        }
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
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'user_name'=>'required|unique:users,username',
            'level'=>'required',
            'email'=>'required|email|unique:users,email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $account = User::findOrFail($id);
            if ($account) {
                $account->name = $request->name;
                $account->username = $request->user_name;
                $account->email = $request->email;
                $account->level = $request->level;
                if ($request->password){
                    $account->password = Hash::make($request->password);
                }
                $account->save();

                return response()->json([
                    'status'=>200,
                    'message'=>'Update Account Successfully',
                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Account Not Found',
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::findOrFail($id);
        if ($users) {
            $users->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Delete Successfully',
            ]);

        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Account Not Found',
            ]);
        }

    }
}
