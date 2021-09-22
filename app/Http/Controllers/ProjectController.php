<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Financial;
use App\Models\LocalVision;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Solution;
use App\Models\TechnicalDetails;
use App\Models\User;
use App\Models\VisitDate;
use Carbon\Carbon;
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
        $all_reports = LocalVision::where('project_id', '=', $project->id)->get();
        $array = [];
        foreach($all_reports as $report){
            $array[] = $report->id;
        }
        $reports = $request->input('reports');
        foreach($reports as $report){
            if(isset($report['id'])){
                if(!(in_array($report['id'],$array))){
                    $vision = new LocalVision();
                    $vision->project_id = $project->id;
                    $vision->author_id = Auth::user()->id;
                    $vision->description = $report['description'];
                    $vision->before = $report['before'];
                    $vision->after = $report['after'];
                    $vision->comment = $report['comment'];
                    $vision->accepted = 0;
                    $vision->save();
                } else{
                    $vision = LocalVision::find($report['id']);
                    $vision->description = $report['description'];
                    $vision->before = $report['before'];
                    $vision->after = $report['after'];
                    $vision->comment = $report['comment'];
                    $vision->save();
                }
            } else {
                $vision = new LocalVision();
                $vision->project_id = $project->id;
                $vision->author_id = Auth::user()->id;
                $vision->description = $report['description'];
                $vision->before = $report['before'];
                $vision->after = $report['after'];
                $vision->comment = $report['comment'];
                $vision->accepted = 0;
                $vision->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $all_reports,
            'reports' => $reports
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getLocalVision(Request $request): JsonResponse
    {
        $reports = LocalVision::where('project_id', '=', $request->input('id'))
            ->orderBy('accepted', 'ASC')->with('author')->get();
        $visit_dates = VisitDate::where('project_id', '=', $request->input('id'))->get();
        $check = true;
        if(isset($reports)){
            foreach($reports as $report){
                if($report->accepted == 0){
                    $check = false;
                }
            }
        }
        if(isset($visit_dates)){
            foreach($visit_dates as $visit_date){
                if($visit_date->accepted == 0){
                    $check = false;
                }
            }
        }


        return response()->json([
            'success' => true,
            'message' => 'pobrano poprawnie',
            'payload' => $reports,
            'check' => $check
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
        $challenge = Challenge::find($request->challenge_id);
        $new_financial = new Financial();
        $new_financial->challenge_id = $challenge->id;
        $new_financial->days = $request->days;
        $new_financial->shifts = $request->shifts;
        $new_financial->shift_time = $request->shift_time;
        $new_financial->weekend_shift = $request->weekend_shift;
        $new_financial->breakfast = $request->breakfast;
        $new_financial->stop_time = $request->stop_time;
        $new_financial->operator_performance = $request->operator_performance;
        $new_financial->defective = $request->defective;
        $new_financial->number_of_operators = $request->number_of_operators;
        $new_financial->operator_cost = $request->operator_cost;
        $new_financial->absence = $request->absence;
        $new_financial->cycle_time = $request->cycle_time;
        $new_financial->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $new_financial
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveTechnicalDetails(Request $request): JsonResponse
    {
        $challenge = Challenge::find($request->challenge_id);
        $new_technical = new TechnicalDetails();
        $new_technical->challenge_id = $challenge->id;

        if (isset($request->detail_weight)) {
            $new_technical->detail_weight = (string)$request->detail_weight;
        }
        if (isset($request->pick_quality)) {
            $new_technical->pick_quality = (string)$request->pick_quality;
        }
        if (isset($request->detail_material)) {
            $new_technical->detail_material = (string)$request->detail_material;
        }
        if (isset($request->detail_size)) {
            $new_technical->detail_size = (string)$request->detail_size;
        }
        if (isset($request->detail_pick)) {
            $new_technical->detail_pick = (string)$request->detail_pick;
        }
        if (isset($request->detail_position)) {
            $new_technical->detail_position = (string)$request->detail_position;
        }
        if (isset($request->detail_range)) {
            $new_technical->detail_range = (string)$request->detail_range;
        }
        if (isset($request->detail_destination)) {
            $new_technical->detail_destination = (string)$request->detail_destination;
        }
        if (isset($request->number_of_lines)) {
            $new_technical->number_of_lines = (string)$request->number_of_lines ?? 1;
        }
        if (isset($request->work_shifts)) {
            $new_technical->work_shifts = (string)$request->work_shifts;
        }
        $new_technical->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'new_technical' => $new_technical
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function acceptOffer(Request $request): JsonResponse
    {
        $project = Project::where('challenge_id', '=' , $request->input('id'))->first();
        $offer = Offer::where('id', '=', $request->input('new_offer_id'))->first();
        $offer->is_offer_project = 1;
        $project->accept_offer = 1;
        $offer->save();
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
    public function rejectOffer(Request $request): JsonResponse
    {
        $project = Project::where('challenge_id', '=' , $request->input('id'))->first();
        $offer = Offer::where('id', '=', $request->input('new_offer_id'))->first();
        $feedback = $request->input(('feedback'));
        $offer->is_offer_project = 2;
        $offer->comment = $feedback;
        $project->selected_offer_id = 0;
        $project->accept_offer = 2;
        $offer->save();
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $offer
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function acceptTechnicalDetails(Request $request): JsonResponse
    {
        $project = Project::where('challenge_id', '=', $request->input('id'))->first();
        $project->accept_technical_details = 1;
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
    public function rejectTechnicalDetails(Request $request): JsonResponse
    {
        $project = Project::where('challenge_id', '=', $request->input('id'))->first();
        $project->accept_technical_details = 2;
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
        $project->accept_financial_details = 1;
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
    public function rejectFinancialDetails(Request $request): JsonResponse
    {
        $project = Project::where('challenge_id', '=' , $request->input('id'))->first();
        $project->accept_financial_details = 2;
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
        $project = Project::where('id', '=' , $request->input('id'))->first();
        $project->accept_local_vision = 1;
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
    public function endVisitDate(Request $request): JsonResponse
    {
        $project = Project::where('id', '=' , $request->input('id'))->first();
        $project->accept_visit_date = 1;
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
    public function rejectLocalVision(Request $request): JsonResponse
    {
        $project = Project::where('challenge_id', '=' , $request->input('id'))->first();
        $project->accept_local_vision = 2;

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
    public function acceptReport(Request $request): JsonResponse
    {
        $local_vision = LocalVision::find($request->input('id'));
        $local_vision -> accepted = 1;
        $local_vision->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $local_vision
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function rejectReport(Request $request): JsonResponse
    {
        $local_vision = LocalVision::find($request->input('report_id'));
        $comment = $request->input('comment');
        $local_vision-> comment = $comment;
        $local_vision-> accepted = 2;
        $local_vision->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $local_vision
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getNewTechnicalDetails(Request $request): JsonResponse
    {
        $all_technicals = TechnicalDetails::where('challenge_id', '=', $request->input('id'))->get();
        if(sizeof($all_technicals) > 1){
            $technicals = TechnicalDetails::where('challenge_id', '=', $request->input('id'))
                ->orderBy('created_at', 'DESC')->get();

            return response()->json([
                'success' => true,
                'message' => '',
                'new_technical' => $technicals[0],
                'old_technical' => $technicals[1]
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => '',
                'new_technical' => $all_technicals[0],
            ]);
        }
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getNewFinancialDetails(Request $request): JsonResponse
    {
        $all_financials = Financial::where('challenge_id', '=', $request->input('id'))->get();
        if(sizeof($all_financials) > 1){
            $financials = Financial::where('challenge_id', '=', $request->input('id'))
                ->orderBy('created_at', 'DESC')->get();

            return response()->json([
                'success' => true,
                'message' => '',
                'new_financial' => $financials[0],
                'old_financial' => $financials[1]
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => '',
                'new_financial' => $all_financials[0],
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProjectSolution(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('id'));

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $solution,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getInvestorAndIntegrator(Request $request): JsonResponse
    {
        $challenge = Challenge::find($request->input('id'));
        $investor = User::with('companies')->find($challenge->author_id);
        $solution = Solution::find($challenge->solution_project_id);
        $integrator = User::with('companies')->find($solution->author_id);

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'investor' => $investor,
            'integrator' => $integrator,
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveVisitDate(Request $request): JsonResponse
    {
        $project = Project::where('challenge_id', '=', $request->input('id'))->first();
        $array = [];
        $members = null;
        $visit_dates = $request->input('deadlines');
        $all_visit_dates = VisitDate::where('project_id', '=', $project->id)->get();
        if(isset($all_visit_dates)){
            foreach($all_visit_dates as $each){
                $array[] = $each->id;
            }
        }

        //            if(!(in_array($visit_date['id'],$array))){
        //////                $visit = new VisitDate();
//            }

        foreach($visit_dates as $visit_date){
            if(!(isset($visit_date['id']))){
                $visit = new VisitDate();
                if(Auth::user()->type == 'investor'){
                    $visit->accepted_investor = 1;
                    $visit->accepted_integrator = 0;
                } else{
                    $visit->accepted_integrator = 1;
                    $visit->accepted_investor = 0;
                }
                $visit->project_id = $project->id;
                $visit->author_id = Auth::user()->id;
                $visit->status = 0;
                $visit->accepted = 0;
            }else {
                $visit = VisitDate::find($visit_date['id']);
                $visit -> members = $visit_date['members'];
            }
            try {
                $visit->date = Carbon::createFromFormat('d.m.Y', $visit_date['date']);
            } catch(Exception $e){

            }

            $visit->time = $visit_date['time'];
            $visit->save();
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
    public function getVisitDate(Request $request): JsonResponse
    {
        $visit_dates = VisitDate::where('project_id', '=', $request->input('id'))->orderBy('accepted', 'ASC')
            ->orderBy('created_at', 'DESC')->with('author')->get();
        $is_selected = null;
        $good = [];
        $tmp_id = null;

        if(isset($visit_dates)){
            foreach($visit_dates as $visit_date){
                $good[] = $visit_date;
                if($visit_date->status == 1){
                    $is_selected = true;
                    $tmp_id = $visit_date->id;
                }
            }
        }

        if($tmp_id != null){
            for($i = 0; $i < count($good); $i++){
               if($good[$i]->id == $tmp_id){
                   $change = $good[0];
                   $second = $good[$i];
                   $good[0] = $second;
                   $good[$i] = $change;
               }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $good,
            'is_selected' => $is_selected
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function acceptVisitDate(Request $request): JsonResponse
    {
        $visit_date = VisitDate::find($request->input('id'));
        $visit_date->accepted = 1;
        $visit_date->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $visit_date
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function rejectVisitDate(Request $request): JsonResponse
    {
        $visit_date = VisitDate::find($request->input('id'));

        $visit_date->accepted = 2;
        $visit_date->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $visit_date
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function cancelVisitDate(Request $request): JsonResponse
    {
        $visit_date = VisitDate::find($request->input('id'));
        $visit_date->status = 1;
        $visit_date->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $visit_date
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteVisitDate(Request $request): JsonResponse
    {
        $visit_date = VisitDate::find($request->input('id'));

        if(isset($visit_date)){
            $visit_date->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Usunieto poprawnie',
            'payload' => ''
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getOffersProject(Request $request): JsonResponse
    {
        $challenge = Challenge::find($request->input('id'));
        $project = Project::where('challenge_id', '=', $request->input('id'))->first();
        $tmp_id = $project->selected_offer_id;
        $old_offer = Offer::where('id', '=' , $challenge->selected_offer_id)->with('solution')->first();
        $new_offer = Offer::where('id', '=', $tmp_id)->with('solution')->first();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie',
            'old_offer' => $old_offer,
            'new_offer' => $new_offer
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getOffersProjectIntegrator(Request $request): JsonResponse
    {
        $challenge = Challenge::find($request->input('id'));
        $project = Project::where('challenge_id', '=', $request->input('id'))->first();
        $offers = Offer::where('project_id', '=', $project->id)->orderBy('is_offer_project', 'ASC')->orderBy('created_at', 'DESC')->with('solution')->get();
        $old_offer = Offer::where('id', '=', $challenge->selected_offer_id)->with('solution')->first();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie',
            'payload' => $offers,
            'old_offer' => $old_offer
        ]);
    }

}
