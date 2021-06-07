<?php

namespace App\Http\Controllers;

use App\Models\OldTeam;
use App\Models\OldUser;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class OldImportController extends Controller
{
    public function import(Request $request)
    {
        $oldUser = OldUser::get();
//        foreach ($oldUser as $old) {
//            $user = new User();
//            $l = explode(' ', $user->name);
//            $user->name = $l[0];
//            $user->lastname = (isset($l[1]))?$old:'';
//            $user->email = $old->email;
//            if($old->role == '912a5b9c-0e16-42fd-9175-55215812f310') {
//                $user->type = 'investor';
//            } else if ($old->role == '912a5bbf-3789-4a3a-a0fe-304efd7bfe6d') {
//                $user->type = 'integrator';
//            } else {
//                $user->type = 'admin';
//            }
//            $user->privacy_policy = 1;
//            $user->pricing = 1;
//            $user->terms = 1;
//            $user->password =  $old->password;
//            $user->save();
//        }

        $oldTeam = OldTeam::get();
        foreach ($oldTeam as $oteam) {
            $tm = new Team();
            $tm->name = $oteam->name;
            $uu = OldUser::where('id', '=', $oteam->author_id)->first();
            dump($uu);
            $u = User::where('email', '=', $uu->email)->first();
            dump($u);
            $tm->owner_id = $u->id;
            $tm->save();
        }
    }
}
