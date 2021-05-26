<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Challenges\Challenge;
use App\Models\Solutions\Solution;
use App\Models\File;
use App\Models\Financial;
use App\Models\TechnicalDetails;
use Carbon\Carbon;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Types\Boolean;

class SolutionController extends Controller
{
    public function saveSolutionFinancials(Request $request, Financial $financial)
    {
        $financial->fill($request->input('data'));
        $financial->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano edycje.',
            'payload' => $financial
        ]);
    }
    public function getUserSolutionUnity(Request $request)
    {
        if (isset($request->id)) {
            $solution = Solution::with('challenge', 'author','financial_after', 'challenge.financial_before', 'challenge.technicalDetails')->find($request->id);

        } else {
            $solution = NULL;
        }

//        $challenge->comments_count = $challenge->comments()->count();
//        $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();



        return response()->json([
            'success' => true,
            'message' => 'Rozwiazanie zostało załadowane poprawnie',
            'payload' => $solution
        ]);
    }
    public function getUserSolutions()
    {

        if(Auth::user()->type == 'integrator') {
            $solutions = Solution::whereIn('stage', [1,2])->where('status', '=', 1)->get();
        } else {
            $solutions = Auth::user()->solutions()->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $solutions
        ]);
    }

    public function getUserSolutionsFiltered(Request $request) {
        $input = $request->input();
        $query = Solution::query();
//        if(Auth::user()->type == 'integrator') {
            $query->where('author_id', '=', Auth::user()->id);
//        }

//        if (isset($input->rating)) {
//            $query->whereIn('rating', [($input->rating - 0.5), $input->rating, ($input->rating + 0.5)]);
//        }

        $solutions = $query->with('comments', 'comments.commentator')->get();

        foreach ($solutions as $solution) {
            if(Auth::user()->viaLoveReacter()->hasReactedTo($solution)){
                $solution->liked = true;
            } else {
                $solution->liked = false;
            }
            $solution->comments_count = $solution->comments()->count();
            $solution->likes = $solution->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $solutions
        ]);
    }

    public function saveDescription(Request $request)
    {
//        dd($request->data);
        $solution = Solution::find($request->data['id']);
        $solution->name = $request->data['name'];
        $solution->description = $request->data['description'];
        $solution->save();

        return response()->json([
            'success' => true,
            'message' => 'Wyzwanie zostało zapisane poprawnie',
            'payload' => $solution
        ]);
    }

    public function checkTeam(Request $request)
    {
        $check = false;
        $solution = Solution::find($request->solution_id);
        foreach ($solution->teams as $team) {
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

    public function likeSolution(Request $request) {
        $id = $request->input('id');
        $solution = Solution::find($id);
        Auth::user()->viaLoveReacter()->reactTo($solution, 'Like');

        return response()->json([
            'success' => true,
            'message' => 'Polajkowano.',
            'payload' => ''
        ]);
    }

    public function saveSolution(Request $request)
    {
        $c = Solution::find($request->data['id']);
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

//    public function createSolution(Request $request)
//    {
//        $solution = new Solution();
//        $technical = new TechnicalDetails();
//        $financial = new Financial();
//        $financial->save();
//
//        $request = json_decode(json_encode($request->data));
//
//        $solution->name = $request->name;
//        $solution->en_name = $request->en_name;
//        $solution->description = $request->description;
//        $solution->en_description = $request->en_description;
//        $solution->price = $request->price;
//        $solution->challenge_id = $request->challenge_id;
//        $solution->installer_id = $request->installer_id;
//        $solution->solution_deadline = Carbon::createFromFormat('d.m.Y', $request->solution_deadline);
//        $solution->offer_deadline = Carbon::createFromFormat('d.m.Y', $request->offer_deadline);
//        $solution->financial_after_id = $financial->id;
//        $solution->author_id = Auth::user()->id;
//        $solution->screenshot_path = 'screenshots/dbr_placeholder.jpeg';
//        $solution->status = 0;
//        $solution->save();
//        $financial->solution_id = $solution->id;
//        $financial->save();
//
//        $technical->detail_weight = (string)$request->detail_weight;
//        $technical->pick_quality = (string)$request->pick_quality;
//        $technical->detail_material = (string)$request->detail_material;
//        $technical->detail_size = (string)$request->detail_size;
//        $technical->detail_pick = (string)$request->detail_pick;
//        $technical->detail_position = (string)$request->detail_position;
//        $technical->detail_range = (string)$request->detail_range;
//        $technical->detail_destination = (string)$request->detail_destination;
//        $technical->number_of_lines = (string)$request->number_of_lines;
//        $technical->cycle_time = 0;
//        $technical->work_shifts = (string)$request->work_shifts;
//        $technical->solution_id = $solution->id;
//        $technical->save();
//
//        return response()->json([
//            'success' => true,
//            'message' => 'Wyzwanie zostao dodane poprawnie',
//            'payload' => $solution
//        ]);
//
//    }

    public function create(Request $request)
    {
        $financial = new Financial();
        $financial->save();
        $challenge = Challenge::find($request->input('id'));
        $solution = new Solution();
        $solution->author_id = Auth::user()->id;
        $solution->challenge_id = $request->input('id');
        $solution->installer_id = Auth::user()->id;
        $solution->financial_after_id = $financial->id;
        $solution->save_json = $challenge->save_json;
        $solution->published = 0;
        $solution->status = 0;
        $solution->screenshot_path = 'screenshots/dbr_placeholder.jpeg';
        $solution->save();

//        $financial->days = $request -> days;
//        $financial->shifts = $request -> shifts;
//        $financial->shift_time = $request -> shift_time;
//        $financial->weekend_shift = $request -> weekend_shift;
//        $financial->breakfast = $request -> breakfast;
//        $financial->stop_time = $request -> stop_time;
//        $financial->operator_performance = $request -> operator_performance;
//        $financial->defective = $request -> defective;
//        $financial->number_of_operators = $request -> number_of_operators;
//        $financial->operator_cost = $request -> operator_cost;
//        $financial->absence = $request -> absence;
//        $financial->cycle_time = $request -> cycle_time;
        $financial->challenge_id = $challenge->id;
        $financial->save();

        return response()->json([
            'success' => true,
            'message' => 'Rozwiązanie zostao dodane poprawnie',
            'payload' => $solution
        ]);
    }
}
