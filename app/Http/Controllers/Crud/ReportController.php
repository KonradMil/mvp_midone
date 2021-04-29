<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Challenges\Challenge;
use App\Models\File;
use App\Models\Financial;
use App\Models\Reports\Report;
use App\Models\TechnicalDetails;
use Carbon\Carbon;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;

class ReportController extends Controller
{
    public function getReport(Request  $request)
    {
        $report = Report::find($request->id);

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $report
        ]);
    }
    public function deleteReport(Request $request)
    {
        Report::destroy($request->id);
        return response()->json([
           'success' => true,
           'message' => 'Usunięto poprawnie'
        ]);
    }
    public function getUserReports()
    {
        $reports = Report::get();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $reports
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

    public function storeFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,csv|max:4096',
        ]);

        $ext = $request->file->extension();

        $fileName = time().'.'.$ext;

        $request->file->move(public_path('uploads'), $fileName);
        $file = new File();
        $file->name = $fileName;
        $file->ext = $ext;
        $file->path = 'uploads/' . $fileName;
        $file->original_name = $request->file->getClientOriginalName();
        $file->save();
//        $challenge = Report::find($request->challenge_id);
//        $challenge->files()->attach($file);
        return response()->json([
            'success' => true,
            'message' => 'Plik został wgrany poprawnie',
            'payload' => $file
        ]);
    }

    public function createReport(Request $request)
    {
        $report = new Report();
        $request = json_decode(json_encode($request->data));
     //    dd($request);
        $report->title = $request->title;
        $report->type = $request->type;
        $report->description = $request->description;

        $report->save();
        return response()->json([
            'success' => true,
            'message' => 'Zgłoszenie zostało dodane poprawnie',
            'payload' => $report
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
