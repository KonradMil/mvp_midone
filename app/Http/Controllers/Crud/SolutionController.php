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
use phpDocumentor\Reflection\Types\Boolean;

class SolutionController extends Controller
{
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
        if(Auth::user()->type == 'integrator') {
            $query->whereIn('stage', [1,2])->where('status', '=', 1);
        } else {
            $query->where('author_id', '=', Auth::user()->id);
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

    public function createSolution(Request $request)
    {
        $solution = new Solution();
        $technical = new TechnicalDetails();
        $financial = new Financial();
        $financial->save();

        $request = json_decode(json_encode($request->data));

        $solution->name = $request->name;
        $solution->en_name = $request->en_name;
        $solution->description = $request->description;
        $solution->en_description = $request->en_description;
        $solution->price = $request->price;
        $solution->challenge_id = $request->challenge_id;
        $solution->installer_id = $request->installer_id;
        $solution->solution_deadline = Carbon::createFromFormat('d.m.Y', $request->solution_deadline);
        $solution->offer_deadline = Carbon::createFromFormat('d.m.Y', $request->offer_deadline);
        $solution->financial_after_id = $financial->id;
        $solution->author_id = Auth::user()->id;
        $solution->screenshot_path = 'screenshots/dbr_placeholder.jpeg';
        $solution->status = 0;
        $solution->save();
        $financial->solution_id = $solution->id;
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
        $technical->solution_id = $solution->id;
        $technical->save();

        return response()->json([
            'success' => true,
            'message' => 'Wyzwanie zostao dodane poprawnie',
            'payload' => $solution
        ]);

    }
}
