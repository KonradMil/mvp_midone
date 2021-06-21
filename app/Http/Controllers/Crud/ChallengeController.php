<?php

namespace App\Http\Controllers\Crud;

use App\Events\ChallengeAdded;
use App\Events\ChallengePublished;
use App\Http\Controllers\Controller;
use App\Models\Challenges\Challenge;
use App\Models\File;
use App\Models\Financial;
use App\Models\Offer;
use App\Models\Solutions\Solution;
use App\Models\Team;
use App\Models\TechnicalDetails;
use Carbon\Carbon;
use Cog\Laravel\Love\Reaction\Models\Reaction;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Contracts\Service;

class ChallengeController extends Controller
{

    public function saveChallengeFinancials(Request $request,Financial $financial)
    {
        $financial->fill($request->input('data'));
        $financial->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano edycje.',
            'payload' => $financial
        ]);
    }

    public function saveChallengeDetails(Request $request, TechnicalDetails $technical)
    {
        $technical->fill($request->input('data'));
        $technical->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano edycje.',
            'payload' => $technical
        ]);
    }

    public function saveChallengeTeams(Request $request, Challenge $challenge)
    {
        foreach ((array)$request->teams as $team_id) {
            $team = Team::find($team_id);
            $challenge->teams()->sync($team);
        }

        return response()->json([
            'success' => true,
            'message' => 'Zapisano edycje.',
            'payload' => $challenge
        ]);
    }

    public function saveChallenge(Request $request)
    {
        $c = Challenge::find($request->data['id']);

        $j = json_decode($request->data['save']['save_json'], true);
        if (!empty($j['screenshot'])) {

            $path = $this->processSS($j['screenshot']);
            $c->screenshot_path = $path['relative'];
            unset($j['screenshot']);
            $c->save_json = json_encode($j);
        }

        $c->save();
        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie.',
            'payload' => $c
        ]);
    }

    public function processSS($ss)
    {
        $content = base64_decode($ss);
        $name = uniqid('ss_') . '.jpg';
        $path = public_path('screenshots/' . $name);
        \Illuminate\Support\Facades\File::put($path, $content);
        Image::make($path)->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($path);

        return ['absolute_path' => $path, 'relative' => ('screenshots/' . $name)];
    }

    public function getUserChallenges()
    {
        if (Auth::user()->type == 'integrator') {
            $challenges = Challenge::whereIn('stage', [1, 2])->where('status', '=', 1)->orderBy('created_at', 'DESC')->get();
        } else if (Auth::user()->type == 'inwestor') {
            $challenges = Auth::user()->challenges()->orderBy('created_at', 'ASC')->get();
        } else {
            $challenges = Auth::user()->challenges()->with('technicalDetails')->orderBy('created_at', 'DESC')->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $challenges
        ]);
    }

    public function getUserChallengesProjects(Request $request)
    {
        $input = $request->input();
        $query = Challenge::query();
        $query->where('stage', '=', 3)->where('status', '=', 1);
        $challengesProject = Challenge::where('stage', '=', 3)->where('status', '=', 1)->get();
        if($challengesProject != NULL){
            $check = false;
            if (Auth::user()->type == 'integrator') {
                foreach ($challengesProject as $challenge) {
                    $offer = Offer::find($challenge->selected_offer_id);
                    $solution = Solution::find($offer->solution_id);

                    foreach ($solution->teams as $team) {
                        foreach (Auth::user()->teams as $t) {
                            if ($t->id == $team->id) {
                                $query->where('stage', '=', 3)->where('status', '=', 1);
                                $check = true;
                            }
                        }
                    }
                }

            } else if (Auth::user()->type == 'investor') {

                foreach ($challengesProject as $challenge) {
                    foreach ($challenge->teams as $team) {
                        foreach (Auth::user()->teams as $t) {
                            if ($t->id == $team->id) {
                                $query->where('author_id', '=', Auth::user()->id)->where('stage', '=', 3);
                                $check = true;
                            }
                        }
                    }
                }

            }


            if (isset($input->status)) {
                $query->where('status', '=', $input->status);
            }
            if (isset($input->type)) {
                $query->where('type', '=', $input->type);
            }
            if (isset($input->rating)) {
                $query->whereIn('rating', [($input->rating - 0.5), $input->rating, ($input->rating + 0.5)]);
            }
            if (isset($input->favourite)) {
                $query->where('favourite', '=', 1);
            }

            $challenges = $query->with(['comments.commentator', 'technicalDetails', 'financial_before'])->get();

            $ars = [];

            $ts = Auth::user()->teams;

            foreach ($ts as $tt) {
                array_push($ars, $tt->id);
            }

            $c = Challenge::whereHas('teams', function ($query) use ($ars) {
                $query->whereIn('teams.id', $ars);
            })->orderBy('created_at', 'DESC')->where('stage', '=', 3)->where('status', '=', 1)->get();


            $merged = $challenges->merge($c);

            foreach ($challenges as $challenge) {

                if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Like')) {
                    $challenge->liked = true;
                } else {
                    $challenge->liked = false;
                }
                $challenge->comments_count = $challenge->comments()->count();
                $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();

                if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Follow', 1)) {
                    $challenge->followed = true;
                } else {
                    $challenge->followed = false;
                }
            }
         if($check === true) {
             return response()->json([
                 'success' => true,
                 'message' => 'Pobrano poprawnie.',
                 'payload' => $merged->all()
             ]);
         }
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Brak projektów.',
                'payload' => ''
            ]);
        }


    }

    public function getUserChallengesFiltered(Request $request)
    {
        $input = $request->input();

        $query = Challenge::query();
        if (Auth::user()->type == 'integrator') {
            $query->whereIn('stage', [1, 2])->where('status', '=', 1);
        } else if (Auth::user()->type == 'investor') {
            $query->where('author_id', '=', Auth::user()->id);
        } else {

        }

        if (isset($input->status)) {
            $query->where('status', '=', $input->status);
        }
        if (isset($input->type)) {
            $query->where('type', '=', $input->type);
        }
        if (isset($input->rating)) {
            $query->whereIn('rating', [($input->rating - 0.5), $input->rating, ($input->rating + 0.5)]);
        }
        if (isset($input->favourite)) {
            $query->where('favourite', '=', 1);
        }

        $challenges = $query->with(['comments.commentator', 'technicalDetails', 'financial_before'])->orderBy('created_at', 'DESC')->get();

        $ars = [];

        $ts = Auth::user()->teams;

        foreach ($ts as $tt) {
            array_push($ars, $tt->id);
        }

        $c = Challenge::whereHas('teams', function ($query) use ($ars) {
            $query->whereIn('teams.id', $ars);
        })->orderBy('created_at', 'DESC')->get();


        $merged = $challenges->merge($c);

        foreach ($challenges as $challenge) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Like')) {
                $challenge->liked = true;
            } else {
                $challenge->liked = false;
            }
            $challenge->comments_count = $challenge->comments()->count();
            $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();

            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Follow', 1)) {
                $challenge->followed = true;
            } else {
                $challenge->followed = false;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $merged->all()
        ]);
    }
    public function getUserChallengesFollowed(Request $request)
    {
        $input = $request->input();
        $query = Challenge::query();
        if (Auth::user()->type == 'integrator') {
            $query->whereIn('stage', [1, 2])->where('status', '=', 1);
        } else if (Auth::user()->type == 'investor') {
            $query->where('author_id', '=', Auth::user()->id);
        } else {

        }

        if (isset($input->status)) {
            $query->where('status', '=', $input->status);
        }
        if (isset($input->type)) {
            $query->where('type', '=', $input->type);
        }
        if (isset($input->rating)) {
            $query->whereIn('rating', [($input->rating - 0.5), $input->rating, ($input->rating + 0.5)]);
        }
        if (isset($input->favourite)) {
            $query->where('favourite', '=', 1);
        }

        $challenges = $query->with(['comments.commentator', 'technicalDetails'])->orderBy('created_at', 'DESC')->get();

        foreach ($challenges as $key => $challenge) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Follow', 1)) {
                $challenge->followed = true;
            } else {
                $challenges->forget($key);
            }
            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Like')) {
                $challenge->liked = true;
            } else {
                $challenge->liked = false;
            }
            $challenge->comments_count = $challenge->comments()->count();
            $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $challenges
        ]);
    }

    public function unfollowChallenge(Request $request)
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        Auth::user()->viaLoveReacter()->unreactTo($challenge, 'Follow');

        return response()->json([
            'success' => true,
            'message' => 'Polajkowano.',
            'payload' => ''
        ]);
    }

    public function followChallenge(Request $request)
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        Auth::user()->viaLoveReacter()->reactTo($challenge, 'Follow');

        return response()->json([
            'success' => true,
            'message' => 'Polajkowano.',
            'payload' => ''
        ]);
    }

    public function likeChallenge(Request $request)
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        Auth::user()->viaLoveReacter()->reactTo($challenge, 'Like');

        return response()->json([
            'success' => true,
            'message' => 'Polajkowano.',
            'payload' => ''
        ]);
    }

    public function dislikeChallenge(Request $request)
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        Auth::user()->viaLoveReacter()->unreactTo($challenge, 'Like');
//        dd([$request->input('id'), Auth::user()->id]);
//        $r = Reaction::where('reactant_id', '=', $request->input('id'))->where('reacter_id', '=', Auth::user()->id)->first();
//        $r->delete();

        return response()->json([
            'success' => true,
            'message' => 'Odlajkowane.',
            'payload' => ''
        ]);
    }


    public function storeImage(Request $request)
    {
//        $request->validate([
//            'file' => 'required|mimes:jpg,png,JPG,jpeg|max:4096',
//        ]);

        $ext = $request->file->extension();
        $fileName = time() . '.' . $ext;
        Storage::disk('s3')->putFileAs('screenshots' , $request->file,  $fileName);
//        $request->file->move(public_path('uploads'), $fileName);
        $file = new File();
        $file->name = $fileName;
        $file->ext = $ext;
        $file->path = 's3/screenshots/' . $fileName;
        $file->original_name = $request->file->getClientOriginalName();
        $file->save();
//        $challenge = Challenge::find($request->challenge_id);
//        $challenge->files()->attach($file);
        return response()->json([
            'success' => true,
            'message' => 'Zdjecie zostało wgrane poprawnie',
            'payload' => $file
        ]);
    }

    public function createChallenge(Request $request)
    {
        $request = json_decode(json_encode($request->data));
        if(isset($request->id)) {
            $challenge = Challenge::find($request->id);
            $financial = $challenge->financial_before;
            $technical = $challenge->technicalDetails;
//            dd([$technical, $financial, $challenge]);
        } else {
            $challenge = new Challenge();
            $technical = new TechnicalDetails();
            $financial = new Financial();
            $financial->save();
        }

        $challenge->name = $request->name;

        $challenge->description = $request->description;
        $challenge->type = $request->type;
        try {
            $challenge->solution_deadline = Carbon::createFromFormat('d.m.Y', $request->solution_deadline);
        } catch (Exception $e) {
            $challenge->solution_deadline = Carbon::createFromFormat('Y-m-d H:i:s', $request->solution_deadline);
        }
        try {
            $challenge->offer_deadline = Carbon::createFromFormat('d.m.Y', $request->offer_deadline);
        } catch (Exception $e) {
            $challenge->offer_deadline = Carbon::createFromFormat('Y-m-d H:i:s', $request->offer_deadline);
        }

        $challenge->allowed_publishing = $request->allowed_publishing;
        $challenge->financial_before_id = $financial->id;
        $challenge->author_id = Auth::user()->id;

        if(!isset($request->id)) {
            $challenge->screenshot_path = 'screenshots/dbr_placeholder.jpeg';
        }
        if(!isset($request->id)) {
            $challenge->status = 0;
            $challenge->stage = 0;
        }
        $challenge->save();

        $financial->days = $request->days;
        $financial->shifts = $request->shifts;
        $financial->shift_time = $request->shift_time;
        $financial->weekend_shift = $request->weekend_shift;
        $financial->breakfast = $request->breakfast;
        $financial->stop_time = $request->stop_time;
        $financial->operator_performance = $request->operator_performance;
        $financial->defective = $request->defective;
        $financial->number_of_operators = $request->number_of_operators;
        $financial->operator_cost = $request->operator_cost;
        $financial->absence = $request->absence;
        $financial->cycle_time = $request->cycle_time;
        $financial->challenge_id = $challenge->id;
        $financial->save();

        if (isset($request->detail_weight)) {
            $technical->detail_weight = (string)$request->detail_weight;
        }
        if (isset($request->pick_quality)) {
            $technical->pick_quality = (string)$request->pick_quality;
        }
        if (isset($request->detail_material)) {
            $technical->detail_material = (string)$request->detail_material;
        }
        if (isset($request->detail_size)) {
            $technical->detail_size = (string)$request->detail_size;
        }
        if (isset($request->detail_pick)) {
            $technical->detail_pick = (string)$request->detail_pick;
        }
        if (isset($request->detail_position)) {
            $technical->detail_position = (string)$request->detail_position;
        }
        if (isset($request->detail_range)) {
            $technical->detail_range = (string)$request->detail_range;
        }
        if (isset($request->detail_destination)) {
            $technical->detail_destination = (string)$request->detail_destination;
        }
        if (isset($request->number_of_lines)) {
            $technical->number_of_lines = (string)$request->number_of_lines ?? 1;
        }
        if (isset($request->work_shifts)) {
            $technical->work_shifts = (string)$request->work_shifts;
        }

        if(!isset($request->id)) {
            $technical->cycle_time = 0;
            $technical->challenge_id = $challenge->id;
        }

        $technical->save();
        if(!isset($request->id)) {
            foreach ($challenge->files as $file) {
                $challenge->files()->detach($file);
            }
        }
        foreach ($request->images as $image) {
            $challenge->files()->attach($image->id);
        }
        if(!isset($request->id)) {
            foreach ($challenge->teams as $team) {
                $challenge->teams()->detach($team);
            }
        }
//        foreach ($request->teams as $team_id) {
//            $team = Team::find($team_id);
//            $challenge->teams()->attach($team);
//        }

        if(!isset($request->id)) {
            if($challenge->status == 1) {

            }
//            event(new ChallengeAdded($challenge, Auth::user(), 'Wyzwanie ' . $challenge->name . ' zostało dodane.', ['financial' => $financial, 'technical' => $technical]));
            $financial->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Wyzwanie zostało dodane poprawnie',
            'payload' => $challenge
        ]);
    }

    public function saveDescription(Request $request)
    {
//        dd($request->data);
        $challenge = Challenge::find($request->data['id']);
        $challenge->name = $request->data['name'];
        $challenge->description = $request->data['description'];
        $challenge->save();

        return response()->json([
            'success' => true,
            'message' => 'Wyzwanie zostało zapisane poprawnie',
            'payload' => $challenge
        ]);
    }

    public function checkTeam(Request $request)
    {
        $check = false;
        $challenge = Challenge::find($request->challenge_id);
        foreach ($challenge->teams as $team) {
            foreach (Auth::user()->teams as $t) {
                if($t->id == $team->id) {
                    $check = true;
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => '',
            'payload' => $check
        ]);
    }

    public function delete(Request $request)
    {
          $id = $request -> input('id');
          Challenge::destroy($id);
//        $challenge = Challenge::where('id', '=', $request->input('id'))->first();
//        dd($challenge);
//        $challenge->author_id = 0;
//        $challenge->save();

        return response()->json([
            'success' => true,
            'message' => '',
            'payload' => ''
        ]);
    }

    public function getCardData(Request $request)
    {
        if (isset($request->id)) {
            $challenge = Challenge::with(
                'solutions', 'author', 'technicalDetails',
                'financial_before', 'teams', 'files', 'teams.users',
                'teams.users.companies', 'solutions.comments', 'solutions.comments.commentator', 'solutions.teams' ,
                'solutions.teams.users' , 'solutions.teams.users.companies'
            )->find($request->id);

        } else {
            $challenge = NULL;
        }

//        if(empty($challenge->technicalDetails)) {
//            $technical = new TechnicalDetails();
//            $technical->challenge_id = $challenge->id;
//            $technical->save();
//            $challenge->technical_details = $technical;
//        }

        $challenge->selected = $challenge->solutions()->where('selected', '=', 1)->get();

        try {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Like', 1)) {
                $challenge->liked = true;
            } else {
                $challenge->liked = false;
            }

            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Follow', 1)) {
                $challenge->followed = true;
            } else {
                $challenge->followed = false;
            }

            foreach ($challenge->solutions as $sol) {
                if (Auth::user()->viaLoveReacter()->hasReactedTo($sol, 'Like', 1)) {
                    $sol->liked = true;
                } else {
                    $sol->liked = false;
                }

                if (Auth::user()->viaLoveReacter()->hasReactedTo($sol, 'Follow', 1)) {
                    $sol->followed = true;
                } else {
                    $sol->followed = false;
                }
                $sol->comments_count = $sol->comments()->count();
                $sol->likes = $sol->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();
            }
        }catch (Exception $e) {
            $challenge->liked = false;
            $challenge->followed = false;
        }



        $challenge->comments_count = $challenge->comments()->count();
        $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();



        return response()->json([
            'success' => true,
            'message' => 'Wyzwanie zostao dodane poprawnie',
            'payload' => $challenge
        ]);
    }

    public function publish(Request $request)
    {
        $challenge = Challenge::with('solutions', 'author')->find($request->input('id'));
        $challenge->status = 1;
        $challenge->stage = 1;
        $challenge->save();


//            event(new ChallengePublished($challenge, $challenge->author, 'Nowe wyzwanie zostało opublikowane: ' . $challenge->name, []));


        return response()->json([
            'success' => true,
            'message' => 'Opublikowano poprawnie.',
            'payload' => $challenge
        ]);
    }

    public function changeDates(Request $request)
    {
        $challenge = Challenge::find($request->input('id'));
        try {
            $challenge->solution_deadline = Carbon::createFromFormat('d.m.Y', $request->solution_deadline);
        } catch (Exception $e) {
            $challenge->solution_deadline = Carbon::createFromFormat('Y-m-d H:i:s', $request->solution_deadline);
        }
        try {
            $challenge->offer_deadline = Carbon::createFromFormat('d.m.Y', $request->offer_deadline);
        } catch (Exception $e) {
            $challenge->offer_deadline = Carbon::createFromFormat('Y-m-d H:i:s', $request->offer_deadline);
        }
        $challenge->save();
        return response()->json([
            'success' => true,
            'message' => 'Opublikowano poprawnie.',
            'payload' => $challenge
        ]);
    }

    public function unpublish(Request $request)
    {
        $challenge = Challenge::with('solutions')->find($request->input('id'));
        $challenge->status = 0;
        $challenge->stage = 0;
        $challenge->save();

        return response()->json([
            'success' => true,
            'message' => 'Odpublikowano poprawnie',
            'payload' => $challenge
        ]);
    }
}
