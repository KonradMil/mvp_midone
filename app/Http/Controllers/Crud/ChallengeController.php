<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Challenges\Challenge;
use App\Models\File;
use App\Models\Financial;
use App\Models\TechnicalDetails;
use Carbon\Carbon;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;

class ChallengeController extends Controller
{

    public function saveChallenge(Request $request)
    {
        dd($request->data);
        $c = Challenge::find($request->data->id);
        $c->save_json = json_decode($request->data->save->save_json);
        $c->save();
        return response()->json([
            'success' => true,
            'message' => 'Zapisanp poprawnie.',
            'payload' => $c
        ]);
     }
    public function getUserChallenges()
    {

        if(Auth::user()->type == 'integrator') {
            $challenges = Challenge::whereIn('stage', [1,2])->where('status', '=', 1)->get();
        } else  if(Auth::user()->type == 'inwestor') {
            $challenges = Auth::user()->challenges()->get();
        } else {
            $challenges = Challenge::get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $challenges
        ]);
    }

    public function getUserChallengesFiltered(Request $request) {
        $input = $request->input();
        $query = Challenge::query();
        if(Auth::user()->type == 'integrator') {
            $query->whereIn('stage', [1,2])->where('status', '=', 1);
        } else  if(Auth::user()->type == 'inwestor') {
            $query->where('author_id', '=', Auth::user()->id);
        } else {

        }


        if(isset($input->status)){
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

        $challenges = $query->with('comments', 'comments.commentator')->get();

        foreach ($challenges as $challenge) {
            if(Auth::user()->viaLoveReacter()->hasReactedTo($challenge)){
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

    public function likeChallenge(Request $request) {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        Auth::user()->viaLoveReacter()->reactTo($challenge, 'Like');

        return response()->json([
            'success' => true,
            'message' => 'Polajkowano.',
            'payload' => ''
        ]);
    }



    public function storeImage(Request $request)
    {
//        $request->validate([
//            'file' => 'required|mimes:jpg,png,JPG,jpeg|max:4096',
//        ]);
        $ext = $request->file->extension();
        $fileName = time().'.'.$ext;

        $request->file->move(public_path('uploads'), $fileName);
        $file = new File();
        $file->name = $fileName;
        $file->ext = $ext;
        $file->path = 'uploads/' . $fileName;
        $file->original_name = $request->file->getClientOriginalName();
        $file->save();
//        $challenge = Challenge::find($request->challenge_id);
//        $challenge->files()->attach($file);
        return response()->json([
            'success' => true,
            'message' => 'Awatar został wgrany poprawnie',
            'payload' => $file
        ]);
    }

    public function createChallenge(Request $request)
    {
        $challenge = new Challenge();
        $technical = new TechnicalDetails();
        $financial = new Financial();
        $financial->save();
        $request = json_decode(json_encode($request->data));
//    dd($request);
        $challenge->name = $request->name;

        $challenge->description = $request->description;
        $challenge->type = $request->type;
        $challenge->solution_deadline = Carbon::createFromFormat('d.m.Y', $request->solution_deadline);
        $challenge->offer_deadline = Carbon::createFromFormat('d.m.Y', $request->offer_deadline);
        $challenge->allowed_publishing = $request->allowed_publishing;
        $challenge->financial_before_id = $financial->id;
        $challenge->author_id = Auth::user()->id;
        $challenge->screenshot_path = 'screenshots/dbr_placeholder.jpeg';
        $challenge->status = 0;
        $challenge->stage = 0;
        $challenge->save();
        $financial->challenge_id = $challenge->id;
        $financial->save();

        $technical->detail_weight = (string)$request->detail_weight;
        $technical->pick_quality = (string)$request->pick_quality;
        $technical->detail_material = (string)$request->detail_material;
        $technical->detail_size = (string)$request->detail_size;
        $technical->detail_pick = (string)$request->detail_pick;
        $technical->detail_position = (string)$request->detail_position;
        $technical->detail_range = (string)$request->detail_range;
        $technical->detail_destination = (string)$request->detail_destination;
        $technical->number_of_lines = (string)$request->number_of_lines;
        $technical->cycle_time = 0;
        $technical->work_shifts = (string)$request->work_shifts;
        $technical->challenge_id = $challenge->id;
        $technical->save();

        return response()->json([
            'success' => true,
            'message' => 'Wyzwanie zostao dodane poprawnie',
            'payload' => $challenge
        ]);

    }

    public function getCardData(Request $request)
    {
        if(isset($request->id)) {
            $challenge = Challenge::with('solutions', 'author')->find($request->id);

        } else {
            $challenge = NULL;
        }

        return response()->json([
            'success' => true,
            'message' => 'Wyzwanie zostao dodane poprawnie',
            'payload' => $challenge
        ]);
    }
}
