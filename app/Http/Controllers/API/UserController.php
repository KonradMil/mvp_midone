<?php

namespace App\Http\Controllers\API;

use App\Mail\ChangePassword;
use App\Mail\ForgotPassword;
use App\Mail\TeamInvitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $users
        ]);
    }
    public function resetPassword(Request $request)
    {
        Mail::to([$request->email])->send(new ForgotPassword($request->email));
    }
    public function changePassword(Request $request)
    {
        $u = Auth::user();
        $credentials = [
            'email' => $u->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $u->password = Hash::make($request->passwordNew);
            $r =  $u->save();
            Mail::to([$u->email])->send(new ChangePassword($u->name));
            return response()->json([
                'success' => $r,
                'message' => 'Zapisano poprawnie',
                'payload' => $u
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Błedne hasło!',
            'payload' => Auth::user(),
        ]);
    }
    public function accept(Request  $request)
    {
        $invite = TeamInvite::find($request->id);
        Teamwork::acceptInvite( $invite );
        $team = $invite->team;
        $invite->delete();
        Auth::user()->attachTeam($team);

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => []
        ]);
    }
    public function updateProfile(Request $request)
    {
        $u = Auth::user();
        $u->name = $request->name;
        $u->lastname = $request->lastname;
        $u->email = $request->input("email", $u->email);

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
            'payload' => $fileName,
            'user' => Auth::user()
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
