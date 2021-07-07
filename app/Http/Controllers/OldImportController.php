<?php

namespace App\Http\Controllers;

use App\Models\Challenges\Challenge;
use App\Models\File;
use App\Models\Financial;
use App\Models\OldChallenge;
use App\Models\OldFile;
use App\Models\OldQuestion;
use App\Models\OldTeam;
use App\Models\OldUser;
use App\Models\Question;
use App\Models\Solutions\Solution;
use App\Models\Team;
use App\Models\TechnicalDetails;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OldImportController extends Controller
{
    public function import(Request $request)
    {

        $challenges = OldChallenge::get();
        try {
            foreach ($challenges as $challenge) {
                $nc = Challenge::where('name', '=', $challenge->name)->first();
                $tech = $nc->technicalDetails;
                $financial = $nc->financial_before;
                $select_detail_weight = [1, 3, 5, 15, 200];
                $select_pick_quality = [1, 2, 3, 4];
                $select_detail_material = [1, 2, 3, 4, 10];
                $select_detail_size = [1, 2, 3, 4, 5];
                $select_detail_pick = [1, 2, 3, 4];
                $select_detail_position = [1, 2];
                $select_detail_range = [1, 2, 3, 4, 5];
                $select_detail_destination = [1, 2, 3];
                $select_number_of_lines = [1, 2, 3, 4, 5];
                $select_cycle_time = [5, 7, 12, 20, 60];
                $select_work_shifts = [1, 2, 3];

                $tech->detail_weight = array_search($challenge->select_detail_weight, $select_detail_weight);
                $tech->detail_material = array_search($challenge->select_detail_material, $select_detail_material);
                $tech->pick_quality = array_search($challenge->select_pick_quality, $select_pick_quality);
                $tech->detail_size = array_search($challenge->select_detail_size, $select_detail_size);
                $tech->detail_pick = array_search($challenge->select_detail_pick, $select_detail_pick);
                $tech->detail_position = array_search($challenge->select_detail_position, $select_detail_position);
                $tech->detail_range = array_search($challenge->select_detail_range, $select_detail_range);
                $tech->detail_destination = array_search($challenge->select_detail_destination, $select_detail_destination);
                $tech->number_of_lines = array_search($challenge->select_number_of_lines, $select_number_of_lines);
                $tech->cycle_time = array_search($challenge->select_cycle_time, $select_cycle_time);
                $tech->work_shifts = array_search($challenge->select_work_shifts, $select_work_shifts);
                $tech->save();

                $financial->days = $challenge->financial_before->days;
                $financial->shifts = $challenge->financial_before->shifts;
                $financial->shift_time = $challenge->financial_before->shift_time;
                $financial->weekend_shift = $challenge->financial_before->weekend_shift;
                $financial->breakfast = $challenge->financial_before->breakfast;
                $financial->stop_time = $challenge->financial_before->stop_time;
                $financial->operator_performance = $challenge->financial_before->operator_performance;
                $financial->defective = $challenge->financial_before->defective;
                $financial->number_of_operators = $challenge->financial_before->number_of_operators;
                $financial->operator_cost = $challenge->financial_before->operator_cost;
                $financial->absence = $challenge->financial_before->absence;
                $financial->cycle_time = $challenge->financial_before->cycle_time;
                $financial->save();

                foreach ($challenge->solutions as $so) {
                    $ns = Solution::where('name', '=', $so->name)->first();
                    $financialNew = $ns->financial_after;
                    $financialNew->days = $so->financial_after->days;
                    $financialNew->shifts = $so->financial_after->shifts;
                    $financialNew->shift_time = $so->financial_aftere->shift_time;
                    $financialNew->weekend_shift = $so->financial_after->weekend_shift;
                    $financialNew->breakfast = $so->financial_after->breakfast;
                    $financialNew->stop_time = $so->financial_after->stop_time;
                    $financialNew->operator_performance = $so->financial_after->operator_performance;
                    $financialNew->defective = $so->financial_after->defective;
                    $financialNew->number_of_operators = $so->financial_after->number_of_operators;
                    $financialNew->operator_cost = $so->financial_after->operator_cost;
                    $financialNew->absence = $so->financial_after->absence;
                    $financialNew->cycle_time = $so->financial_after->cycle_time;
                    $financialNew->save();
                }

                //            if($nc != NULL) {
//                foreach ($challenge->files as $o) {
//                    $ofile = OldFile::where('id', '=', $o->file_id)->first();
//                    try {
//                        $file = new File();
//                        $name = $ofile->name . '.' . $ofile->ext;
//                        $file->name = $name;
//                        $file->ext = $ofile->ext;
//                        $file->path = 's3/screenshots/' . $name;
//                        $file->original_name = $ofile->name;
//                        $file->save();
//                        $nc->files()->attach($file);
//                    } catch (Exception $e) {
//                        dd($ofile);
//                    }
//                }
//            }
            }
        }catch (Exception $e) {
            dd($challenge);
        }



//        $oldUser = OldUser::get();
//        foreach ($oldUser as $old) {
//            $user = new User();
//            $l = explode(' ', $old->name);
//            $user->name = $l[0];
//            $user->lastname = (isset($l[1]))?$l[1]:'';
//            $user->email = $old->email;
//            if($old->role_id == '912a5b9c-0e16-42fd-9175-55215812f310') {
//                $user->type = 'investor';
//            } else if ($old->role_id == '912a5bbf-3789-4a3a-a0fe-304efd7bfe6d') {
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
//
//        $oldTeam = OldTeam::get();
//        foreach ($oldTeam as $oteam) {
//            $tm = new Team();
//            $tm->name = $oteam->name;
//            $uu = OldUser::where('id', '=', $oteam->author_id)->first();
//            if($uu != null) {
//                $u = User::where('email', '=', $uu->email)->first();
//
//                $tm->owner_id = $u->id;
//                $tm->save();
//            }
//        }

//        $oldTeam = OldTeam::get();
//
//        foreach ($oldTeam as $team) {
//           print_r($team->users);
//        }
//
//        $oldUser = OldUser::get();
//        foreach ($oldUser as $user) {
//            foreach ($user->teams as $team) {
//                dd($user->teams[0]);
//                $nu = User::where('email', '=', $user->email)->first();
//                $nt = Team::where('name', '=', $team->name)->first();
//                $nu->teams()->attach($nt);
//            }
//        }
//
//        $a = DB::connection('old')->table('dbr_team_users')->select('*')->get();

//        foreach ($a as $rel) {
//            try {
//                $ot = OldTeam::where('id', '=', $rel->team_id)->first();
//                $ou = OldUser::where('id', '=', $rel->user_id)->first();
//                $nt = Team::where('name', '=', $ot->name)->first();
//
//                $nu = User::where('email', '=', $ou->email)->first();
//                $nu->teams()->attach($nt);
//            }catch (\Exception $e) {
//                print_r($e);
//
//                dd([$ou, $ot, $rel]);
//            }
//
//        }

//        $oldTeam = OldTeam::get();
//
//        foreach ($oldTeam as $team) {
//            try {
//                $ou = OldUser::where('id', '=', $team->author_id)->first();
//                $nt = Team::where('name', '=', $team->name)->first();
//                $nu = User::where('email', '=', $ou->email)->first();
//                $nu->teams()->attach($nt);
//                $nt->owner_id = $nu->id;
//                $nt->save();
//            }catch (\Exception $e) {
//                dd([$ou, $team, $team->author_id]);
//            }
//        }

//        dd($a);
//

//        $challenges = Challenge::get();
//        foreach ($challenges as $challenge) {
//            $tech = new TechnicalDetails();
//            $tech->challenge_id = $challenge->id;
//            $tech->save();
//        }


//            Storage::disk('s3')->putFileAs('screenshots', $request->file, $fileName);
//        $request->file->move(public_path('uploads'), $fileName);


//        $challenges = OldChallenge::get();
//        foreach ($challenges as $challenge) {
//            try {
//                $nc = Challenge::where('name', '=', $challenge->name)->first();
//                if($challenge->published_at != NULL) {
//                    $nc->status = 1;
//                    $nc->save();
//                }
////                print_r($challenge->teams);
////                foreach ($challenge->teams as $t) {
////                    $nt = Team::where('name', '=', $t->name)->first();
////                    $nc->teams()->attach($nt);
////                }
//            }catch (\Exception $e) {
//                print_r($e);
//            }
//        }
//        $oldTeam = OldTeam::get();
//
//        foreach ($oldTeam as $team) {
//
//                foreach ($team->users as $user) {
//                    if($team->author_id == $user->id) {
//
//                    } else {
//                        $nt = Team::where('name', '=', $team->name)->first();
//
//                        $nu = User::where('email', '=', $user->email)->first();
//                        $nu->teams()->attach($nt);
//                    }
//                }
//        }

//        $oldChallenges = OldChallenge::with('teams')->get();
////        dd($oldChallenges);
//        foreach ($oldChallenges as $oc) {
//
//            $ou = OldUser::where('id', '=', $oc->author_id)->first();
//            $nu = User::where('email', '=', $ou->email)->first();
//            $fi = new Financial();
//            $fi->save();
//            $newChallenge = new Challenge();
//            $newChallenge->name = $oc->name;
//            $newChallenge->save_json = str_replace('platfrom.dbr77.com', 'platform.dbr77.com', $oc->save_json);
//            $newChallenge->screenshot_path = 's3/' . $oc->screenshot_path;
//            $newChallenge->status = $oc->status;
//            $newChallenge->stage = $oc->stage;
//            $newChallenge->description = $oc->description;
//            $newChallenge->author_id = $nu->id;
//            $newChallenge->solution_deadline = $oc->solution_deadline;
//            $newChallenge->offer_deadline = $oc->offer_deadline;
//            $newChallenge->type = 0;
//            $newChallenge->financial_before_id = $fi->id;
//            $technical = new TechnicalDetails();
//            $newChallenge->save();
//            $technical->challenge_id = $newChallenge->id;
//            $technical->save();
//            $fi->challenge_id = $newChallenge->id;
//            $fi->save();
////            dd([$oc, $oc->teams]);
//            $a = $oc->teams()->get();
//            foreach ($a as $ot) {
//
//                $nt = Team::where('name', '=', $ot->name)->first();
//                $newChallenge->teams()->attach($nt);
//            }
//
//            foreach ($oc->solutions as $so) {
//                $ns = new Solution();
//                $ns->published = 0;
//                $ns->challenge_id = $newChallenge->id;
//                $ns->selected = $so->selected;
//                $ns->rejected = $so->rejected;
//                $ns->save_json = str_replace('platfrom.dbr77.com', 'platform.dbr77.com', $so->save_json);
//                $ns->name = $so->name;
//                $ns->description = '';
//                $ns->screenshot_path = 's3/' . $so->screenshot_path;
//                $ns->status = $so->status;
//                try {
//                    $oldInst = OldUser::where('id', '=', $so->installer_id)->first();
//                    $newUser = User::where('email', '=', $oldInst->email)->first();
//                    $ns->installer_id = $newUser->id;
//                    $ns->author_id = $newUser->id;
//                } catch (\Exception $e){
//                    $ns->installer_id = 1;
//                    $ns->author_id = 1;
//                }
//
//
//
//                $fis = new Financial();
//                $fis->challenge_id = NULL;
//                $fis->save();
//                $fis->financial_after_id = $fis->id;
//                $ns->save();
//                foreach ($so->teams as $st) {
//                    $nt = Team::where('name', '=', $st->name)->first();
//                    $ns->teams()->attach($nt);
//                }
//            }
//        }


//        $oldQ = OldQuestion::get();
//
//        foreach ($oldQ as $q) {
//            try {
//                $ou = OldUser::where('id', '=', $q->author_id)->first();
//                $oc = OldChallenge::where('id', '=', $q->challenge_id)->first();
//
//                $nu = User::where('email', '=', $ou->email)->first();
//                $nc = Challenge::where('name', '=', $oc->name)->first();
//
//                $nq = new Question();
//                $nq->question = $q->question;
//                $nq->answer = NULL;
//                $nq->author_id = $nu->id;
//                $nq->challenge_id = $nc->id;
//                $nq->save();
//
//                if(!empty($q->answer)) {
//                    $na = new Question();
//                    $na->question = $q->answer;
//                    $na->answer = $nq->id;
//                    $na->author_id = $nu->id;
//                    $na->challenge_id = $nc->id;
//                    $na->save();
//                }
//            } catch (\Exception $e) {
//
//            }
//
//        }
    }
}
