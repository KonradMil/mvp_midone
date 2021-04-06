<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Mpociot\Teamwork\Facades\Teamwork;

class UserController extends Controller
{

    public function updateProfile(Request $request)
    {
        $u = Auth::user();
        $u->name = $request->name;
        $u->lastname = $request->lastname;
        $r =  $u->save();

        return response()->json([
            'success' => $r,
            'message' => 'Zapisano poprawnie',
            'payload' => $u
        ]);
    }
    public function storeAvatar(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:jpg,png,JPG,jpeg|max:4096',
        ]);

        $fileName = time().'.'.$request->file->extension();

        $request->file->move(public_path('uploads'), $fileName);
        $u = Auth::user();
        $u->avatar = $fileName;
        $u->save();

        return response()->json([
            'success' => true,
            'message' => 'Awatar został wgrany poprawnie',
            'payload' => $fileName
        ]);
    }
    public function checkEmail($email)
    {
       $user = User::where('email', '=', $email)->first();
        if($user == NULL) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    /**
     * Register
     */
    public function register(Request $request)
    {
        try {
            $user = new User();
//            $user->name = $request->name;
            $user->email = $request->email;
            $user->type = $request->type;
            $user->password = Hash::make($request->password);
            $user->save();

            $success = true;
            $message = 'User register successfully';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }
        Auth::login($user);

        if(!empty($request->token)){
            $invite = Teamwork::getInviteFromAcceptToken( $request->token );

            if( $invite ) // valid token found
            {
                Teamwork::acceptInvite( $invite );
            }
        }
        // response
        $response = [
            'success' => $success,
            'message' => $message,
            'payload' => $user
        ];
        return response()->json($response);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $success = true;
            $message = 'User login successfully';
        } else {
            $success = false;
            $message = 'Unauthorised';
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
            'payload' => Auth::user(),
        ];
        return response()->json($response);
    }

    /**
     * Logout
     */
    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = 'Successfully logged out';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }


}
