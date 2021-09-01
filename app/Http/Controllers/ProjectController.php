<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Financial;
use App\Models\LocalVision;
use App\Models\Project;
use App\Models\TechnicalDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class ProjectController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCardData(Request $request): JsonResponse
    {
        if (isset($request->id)) {
            $challenge = Challenge::with(
                'solutions', 'author', 'technicalDetails',
                'financial_before', 'teams', 'files', 'teams.users',
                'teams.users.companies', 'solutions.comments', 'solutions.files', 'solutions.comments.commentator', 'solutions.teams',
                'solutions.teams.users', 'solutions.teams.users.companies', 'solutions.offers', 'project'
            )->find($request->id);
        } else {
            $challenge = NULL;
        }

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
        } catch (Exception $e) {
            $challenge->liked = false;
            $challenge->followed = false;
        }

        $challenge->comments_count = $challenge->comments()->count();
        $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();

        $project = Project::where('challenge_id', '=', $challenge->id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Wyzwanie zostao dodane poprawnie',
            'payload' => $challenge,
            'project' => $project,

        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveLocalVision(Request $request): JsonResponse
    {
        $project = Project::where('challenge_id', '=', $request->input('id'))->first();
        $reports = $request->input('reports');

        foreach($reports as $report){
            $vision = new LocalVision();
            $vision->project_id = $project->id;
            $vision->description = $report['description'];
            $vision->before = $report['before'];
            $vision->after = $report['after'];
            $vision->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => ''
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getLocalVision(Request $request): JsonResponse
    {
        $reports = LocalVision::where('project_id', '=', $request->input('id'))->get();

        return response()->json([
            'success' => true,
            'message' => 'pobrano poprawnie',
            'payload' => $reports
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteLocalVision(Request $request): JsonResponse
    {
        $report = LocalVision::where('id', '=', $request->input('id'))->first();
        if($report != null){
            $report->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Usunięto poprawnie',
            'payload' => ''
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveFinancialDetails(Request $request): JsonResponse
    {
        $financial = Financial::find($request->id);
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
        $financial->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $financial
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveTechnicalDetails(Request $request): JsonResponse
    {
        $technical = TechnicalDetails::find($request->id);

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
        $technical->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $technical
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function acceptOffer(Request $request): JsonResponse
    {
        $project = Project::where('challenge_id', '=' , $request->input('id'))->first();
        $project->project_accept_offer = 1;
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $project
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function acceptTechnicalDetails(Request $request): JsonResponse
    {
        $project = Project::where('challenge_id', '=', $request->input('id'))->first();
        $project->project_accept_details = 1;
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $project
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function acceptFinancialDetails(Request $request): JsonResponse
    {
        $project = Project::where('challenge_id', '=' , $request->input('id'))->first();
        $project->project_accept_details = 1;
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $project
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function acceptLocalVision(Request $request): JsonResponse
    {
        $project = Project::where('challenge_id', '=' , $request->input('id'))->first();
        $project->project_accept_vision = 1;
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $project
        ]);
    }

}
