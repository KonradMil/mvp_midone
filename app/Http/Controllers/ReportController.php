<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\File;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 *
 */
class ReportController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getReport(Request $request): JsonResponse
    {
        $report = Report::with('files')->find($request->id);

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $report
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteReport(Request $request): JsonResponse
    {
        Report::destroy($request->id);

        return response()->json([
            'success' => true,
            'message' => 'Usunięto poprawnie',
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getUserReports(): JsonResponse
    {
        $reports = Auth::user()->reports()->with('files')->get();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $reports
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserChallengesFiltered(Request $request): JsonResponse
    {
        $input = $request->input();
        $query = Challenge::query();
        if (Auth::user()->type == 'integrator') {
            $query->whereIn('stage', [1, 2])->where('status', '=', 1);
        } else if (Auth::user()->type == 'inwestor') {
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

        $challenges = $query->with('comments', 'comments.commentator')->get();

        foreach ($challenges as $challenge) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge)) {
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function storeFile(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,csv|max:4096',
        ]);

        $ext = $request->file->extension();
        $fileName = time() . '.' . $ext;
        Storage::disk('s3')->putFileAs('screenshots', $request->file, $fileName);
        $file = new File();
        $file->name = $fileName;
        $file->ext = $ext;
        $file->path = 's3/screenshots/' . $fileName;
        $file->original_name = $request->file->getClientOriginalName();
        $file->author_id = Auth::user()->id;
        $file->save();

        return response()->json([
            'success' => true,
            'message' => 'Plik został wgrany poprawnie',
            'payload' => $file
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createReport(Request $request): JsonResponse
    {
        $report = new Report();
        $request = json_decode(json_encode($request->data));
        $report->title = $request->title;
        $report->type = $request->type;
        $report->description = $request->description;
        $report->author_id = Auth::user()->id;
        $report->save();
        $arrayFiles = $request->files;

        try {
            foreach($arrayFiles as $arrayFile){
                $file = File::find($arrayFile->id);
                $report->files()->attach($file);
                $report->files = $report->files()->get();
            }
        } catch (\Exception $e) {

        }


        return response()->json([
            'success' => true,
            'message' => 'Zgłoszenie zostało dodane poprawnie',
            'payload' => $report
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCardData(Request $request): JsonResponse
    {
        if (isset($request->id)) {
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
