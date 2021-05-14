<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Challenges\Challenge;
use App\Models\File;
use App\Models\Financial;
use App\Models\TechnicalDetails;
use App\Modules\Dbr\Module\Http\UnityController;
use Carbon\Carbon;
use Cog\Laravel\Love\Reaction\Models\Reaction;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Types\Boolean;

class ChallengeController extends Controller
{
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
    public function saveChallenge(Request $request)
    {
//        dd($request->data);
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

    public function processSS($ss) {
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

        if(Auth::user()->type == 'integrator') {
            $challenges = Challenge::whereIn('stage', [1,2])->where('status', '=', 1)->get();
        } else  if(Auth::user()->type == 'inwestor') {
            $challenges = Auth::user()->challenges()->get();
        } else {
            $challenges = Auth::user()->challenges()->with('technicalDetails')->get();
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
        } else  if(Auth::user()->type == 'investor') {
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

        $challenges = $query->with(['comments.commentator', 'technicalDetails'])->get();

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

    public function dislikeChallenge(Request $request) {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
//        Auth::user()->viaLoveReacter()->reactTo($challenge, 'Dislike');
        dd([$request->input('id'), Auth::user()->id]);
       $r = Reaction::where('reactant_id', '=', $request->input('id'))->where('reacter_id', '=', Auth::user()->id)->first();
       $r->delete();

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

        if(isset($request->detail_weight)){
            $technical->detail_weight = (string)$request->detail_weight;
        }
        if(isset($request->pick_quality)){
            $technical->pick_quality = (string)$request->pick_quality;
        }
        if(isset($request->detail_material)){
            $technical->detail_material = (string)$request->detail_material;
        }
        if(isset($request->detail_size)){
            $technical->detail_size = (string)$request->detail_size;
        }
        if(isset($request->detail_pick)){
            $technical->detail_pick = (string)$request->detail_pick;
        }
        if(isset($request->detail_position)){
            $technical->detail_position = (string)$request->detail_position;
        }
        if(isset($request->detail_range)){
            $technical->detail_range = (string)$request->detail_range;
        }
        if(isset($request->detail_destination)){
            $technical->detail_destination = (string)$request->detail_destination;
        }
        if(isset($request->number_of_lines)){
            $technical->number_of_lines = (string)$request->number_of_lines ?? 1;
        }
        if(isset($request->work_shifts)){
            $technical->work_shifts = (string)$request->work_shifts;
        }
        $technical->cycle_time = 0;

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
            $challenge = Challenge::with('solutions', 'author','technicalDetails')->find($request->id);

        } else {
            $challenge = NULL;
        }

        return response()->json([
            'success' => true,
            'message' => 'Wyzwanie zostao dodane poprawnie',
            'payload' => $challenge
        ]);
    }

    public function publish(Request $request)
    {
        $challenge = Challenge::with('solutions')->find($request->input('id'));
        $challenge->status = 1;
        $challenge->stage = 1;
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
