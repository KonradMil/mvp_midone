<?php

namespace App\Http\Controllers;

use App\Events\SolutionAccepted;
use App\Events\SolutionAdded;
use App\Events\SolutionDisliked;
use App\Events\SolutionLiked;
use App\Events\SolutionPublished;
use App\Events\SolutionRejected;
use App\Http\Requests\Handlers\SolutionFilesHandler;
use App\Models\Challenge;
use App\Models\Estimate;
use App\Models\FinancialAnalysis;
use App\Models\Offer;
use App\Models\OperationalAnalysis;
use App\Models\Solution;
use App\Models\File;
use App\Models\Financial;
use App\Models\Team;
use App\Models\UnityModel;
use App\Models\User;
use App\Repository\Eloquent\FileRepository;
use App\Repository\Eloquent\SolutionRepository;
use App\Services\SolutionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\ResponseBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class SolutionController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function storeFile(Request $request): JsonResponse
    {
        $ext = $request->file->extension();
        $fileName = time() . '.' . $ext;
        Storage::disk('s3')->putFileAs('screenshots', $request->file, $fileName);
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

    /**
     * @param Request $request
     * @param int $id
     * @param SolutionRepository $solutionRepository
     * @param SolutionFilesHandler $solutionFilesHandler
     * @param SolutionService $solutionService
     * @return JsonResponse
     */
    public function saveFiles(Request $request, int $id, SolutionRepository $solutionRepository, SolutionFilesHandler $solutionFilesHandler, SolutionService $solutionService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $solutionFilesHandler = new SolutionFilesHandler($request);

        $solution = $solutionRepository->find($id);

        if (!$solution) {
            $responseBuilder->setErrorMessage(__('messages.solution.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $parameters = $solutionFilesHandler->getParameters();

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        try {
                $newSolutionFiles = $solutionService->addSolutionFiles($parameters,$solution);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $responseBuilder->setData('solution', $newSolutionFiles->with('files'));


            } catch (QueryException $e) {

                $responseBuilder->setErrorMessage(__('messages.error'));
                return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

            }

        return $responseBuilder->getResponse();
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function filterChallengeSolutions(Request $request): JsonResponse
    {
        $option = $request->input('option');
        $id = $request->input('id');
        $technology_option = $request->input('technologyType');
        $challenge = Challenge::find($id);
        $solutions = NULL;
        $solutionsOkresZwrotu = NULL;
        $solutionsNpv = NULL;
        try {
            if ($option === 'Cena rosnąco') {
                $solutions = $challenge->solutions()->where('solutions.status', '=', 1)->join('estimates', 'solutions.id', '=', 'estimates.solution_id')->select('solutions.*')->orderBy('estimates.sum', 'DESC')->get();
            } else if ($option === 'Cena malejąco') {
                $solutions = $challenge->solutions()->where('solutions.status', '=', 1)->join('estimates', 'solutions.id', '=', 'estimates.solution_id')->select('solutions.*')->orderBy('estimates.sum', 'ASC')->get();
            } else if ($option === 'OEE po robotyzacji') {
                $solutions = $challenge->solutions()->where('solutions.status', '=', 1)->join('operational_analyses', 'solutions.id', '=', 'operational_analyses.solution_id')->orderBy('operational_analyses.oee_after', 'ASC')->select('solutions.*')->get();
            } else if ($option === 'NPV') {
                $solutions = $challenge->solutions()->where('solutions.status', '=', 1)->join('financial_analyses', 'solutions.id', '=', 'financial_analyses.solution_id')->orderBy('financial_analyses.npv', 'ASC')->select('solutions.*')->get();
            } else if ($option === 'Okres zwrotu inwestycji') {
                $solutions = $challenge->solutions()->where('solutions.status', '=', 1)->join('financial_analyses', 'solutions.id', '=', 'financial_analyses.solution_id')->orderBy('financial_analyses.simple_payback', 'ASC')->select('solutions.*')->get();
            } else if ($option === null && $technology_option === null) {
                $solutions = $challenge->solutions()->where('rejected', '=', null)->where('solutions.status', '=', 1)->get();
            } else if ($technology_option === 'FANUC') {
                $solutions = $challenge->solutions()->where('rejected', '=', null)->where('status', '=', 1)->where('number_of_fanuc', '>' , 0)->orderBy('number_of_fanuc', 'DESC')->get();
            } else if ($technology_option === 'KUKA') {
                $solutions = $challenge->solutions()->where('rejected', '=', null)->where('status', '=', 1)->where('number_of_kuka', '>' , 0)->orderBy('number_of_kuka', 'DESC')->get();
            } else if ($technology_option === 'Yaskawa') {
                $solutions = $challenge->solutions()->where('rejected', '=', null)->where('status', '=', 1)->where('number_of_yaskawa', '>' , 0)->orderBy('number_of_yaskawa', 'DESC')->get();
            } else if ($technology_option === 'ABB') {
                $solutions = $challenge->solutions()->where('rejected', '=', null)->where('status', '=', 1)->where('number_of_abb', '>' , 0)->orderBy('number_of_abb', 'DESC')->get();
            } else if ($technology_option === 'Universal Robots') {
                $solutions = $challenge->solutions()->where('rejected', '=', null)->where('status', '=', 1)->where('number_of_universal', '>' , 0)->orderBy('number_of_universal', 'DESC')->get();
            } else if ($technology_option === 'Mitshubishi') {
                $solutions = $challenge->solutions()->where('rejected', '=', null)->where('status', '=', 1)->where('number_of_mitshubishi', '>' , 0)->orderBy('number_of_mitshubishi', 'DESC')->get();
            } else if ($technology_option === 'Universal Robots') {
                $solutions = $challenge->solutions()->where('rejected', '=', null)->where('status', '=', 1)->where('number_of_universal', '>' , 0)->orderBy('number_of_universal', 'DESC')->get();
            } else if ($technology_option === 'TFM ROBOTICS') {
                $solutions = $challenge->solutions()->where('rejected', '=', null)->where('status', '=', 1)->where('number_of_tfm', '>' , 0)->orderBy('number_of_tfm', 'DESC')->get();
            }
        } catch(\Exception $e){
            if($option !== NULL){
                return response()->json([
                    'success' => true,
                    'message' => 'Filter ok',
                    'payload' => ''
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Filter ok',
            'payload' => $solutions
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getUserSolutionsArchive(): JsonResponse
    {
        $solutions = Solution::where('archive', '=', 1)->with('files')->get();
        $filterSolutions = [];

        foreach ($solutions as $solution) {
            foreach ($solution->teams as $team) {
                foreach (Auth::user()->teams as $t) {
                    if ($team->id == $t->id) {
                        $filterSolutions[] = $solution;
                    }
                }
            }
            if ($solution->author_id == Auth::user()->id) {
                $filterSolutions[] = $solution;
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Pobrano archiwalne rozwiązania poprawnie.',
            'payload' => $filterSolutions
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function deleteSolutionsNull(): JsonResponse
    {
        $solutions = Solution::all();
        foreach ($solutions as $solution) {
            $challenge = Challenge::find($solution->challenge_id);
            if ($challenge == NULL) {
                $solution->delete();
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Pobrano rozwiązania poprawnie.',
            'payload' => $solutions
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserSolutionsProject(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $solutions = Solution::where('author_id', '=', Auth::user()->id)->where('challenge_id', '=', $id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Pobrano rozwiązania poprawnie.',
            'payload' => $solutions
        ]);
    }

    /**
     * @param Challenge $challenge
     * @return JsonResponse
     */
    public function getUserSolutionsChallenge(Challenge $challenge): JsonResponse
    {
        $solutions = $challenge->solutions->where('author_id', '=', Auth::user()->id);

        return response()->json([
            'success' => true,
            'message' => 'Pobrano rozwiązania poprawnie.',
            'payload' => $solutions
        ]);
    }

    /**
     * @param Request $request
     * @param Solution $solution
     * @return JsonResponse
     */
    public function saveSolutionTeams(Request $request, Solution $solution): JsonResponse
    {
        foreach ($request->teams as $team_id) {
            $team = Team::find($team_id);
            $solution->teams()->sync($team);
        }
        return response()->json([
            'success' => true,
            'message' => 'Zapisano edycje zespołów!.',
            'payload' => $solution
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function rejectSolution(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $solution = Solution::find($id);
        $solution->rejected = true;
        $solution->selected = false;
        $solution->offers()->delete();
        $solution->selected_offer_id = 0;
        $solution->rejected = 1;
        $challenge = Challenge::find($solution->challenge_id);
        $solution->save();

        event(new SolutionRejected($solution, $challenge->author, 'Rozwiązanie zostało odrzucone: ' . $solution->name, []));

        return response()->json([
            'success' => true,
            'message' => 'Odrzucono rozwiązanie.',
            'payload' => $solution
        ]);
    }

//    public function saveRobot(Request $request)
//    {
//        $solution = Solution::find($request->input('solution_id'));
//        $save = json_decode($solution->save_json);
//        $id = $request->input('robot_id');
////        foreach ($save->parts as $part) {
////            $model = UnityModel::find($id);
////            if($model->category != NULL) {
////                $model->guarantee_period = $request->input('guarantee_period');
////                $model->save();
////            }
////        }
//        return response()->json([
//            'success' => true,
//            'message' => 'Zapisano poprawnie.',
//            'payload' => $model
//        ]);
//    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getRobots(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('id'));
        $estimate = Estimate::where('solution_id', '=', $solution->id)->first();

        if (!empty($request->input('offer_id'))) {
            $offer = Offer::find($request->input('offer_id'));
            $robots = json_decode($offer->robots);
        } else {
            if ($estimate != NULL) {
                $save = json_decode($estimate->parts_ar);
                $robots = [];
                if ($save != NULL) {
                    foreach ($save as $key => $val) {
                        if ($val->count > 0) {
                            $model = UnityModel::where('name', '=', $key)->first();
                            $model->guarantee_period = 0;
                            if ($model->category == 1 && $model->subcategory != 1) {
                                $robots[] = $model;
                            }
                        }
                    }
                }
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $robots
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function acceptSolution(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $solution = Solution::find($id);
        $challenge = Challenge::find($solution->challenge_id);
//        $challenge->stage = 2;
//        $challenge->save();
        $solution->selected = 1;
        $solution->rejected = 0;
        $solution->save();

        event(new SolutionAccepted($solution, $challenge->author, 'Rozwiązanie zostało zaakceptowane: ' . $solution->name, []));

        return response()->json([
            'success' => true,
            'message' => 'Zatwierdzono rozwiązanie.',
            'payload' => $solution
        ]);
    }

    /**
     * @param Request $request
     * @param Financial $financial
     * @return JsonResponse
     */
    public function saveSolutionFinancials(Request $request, Financial $financial): JsonResponse
    {
        $financial->fill($request->input('data'));
        $financial->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano edycje.',
            'payload' => $financial
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserSolutionUnity(Request $request): JsonResponse
    {
        if (isset($request->id)) {
            $solution = Solution::with('challenge', 'author', 'financial_after', 'challenge.financial_before', 'challenge.technicalDetails')->find($request->id);

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

    /**
     * @return JsonResponse
     */
    public function getUserSolutions(): JsonResponse
    {

        if (Auth::user()->type == 'integrator') {
            $solutions = Solution::whereIn('stage', [1, 2])->where('status', '=', 1)->get();
        } else {
            $solutions = Auth::user()->solutions()->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $solutions
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserSolutionsFiltered(Request $request): JsonResponse
    {
        $input = $request->input();
        $query = Solution::query();
        $query->where('author_id', '=', Auth::user()->id);

//        if (isset($input->rating)) {
//            $query->whereIn('rating', [($input->rating - 0.5), $input->rating, ($input->rating + 0.5)]);
//        }

        $solutions = $query->with('comments', 'comments.commentator')->get();

        foreach ($solutions as $solution) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($solution)) {
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveDescription(Request $request): JsonResponse
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function operationalAnalysesSave(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('solution_id'));
        if ($solution->operational_analyses != Null) {
            $operational_analyses = $solution->operational_analyses;
        } else {
            $operational_analyses = new OperationalAnalysis();
            $operational_analyses->solution_id = $request->input('solution_id');
        }
        $input = $request->input();
        $operational_analyses->time_available_before = (float)$input['operationalAnalyses']['time_available_before'];
        $operational_analyses->time_available_after = (float)$input['operationalAnalyses']['time_available_after'];
        $operational_analyses->time_available_change = (float)$input['operationalAnalyses']['time_available_change'];
        $operational_analyses->time_production_before = (float)$input['operationalAnalyses']['time_production_before'];
        $operational_analyses->time_production_after = (float)$input['operationalAnalyses']['time_production_after'];
        $operational_analyses->time_production_change = (float)$input['operationalAnalyses']['time_production_change'];
        $operational_analyses->production_before = (float)$input['operationalAnalyses']['production_before'];
        $operational_analyses->production_after = (float)$input['operationalAnalyses']['production_after'];
        $operational_analyses->production_change = (float)$input['operationalAnalyses']['production_change'];
        $operational_analyses->good_arts_production_before = (float)$input['operationalAnalyses']['good_arts_production_before'];
        $operational_analyses->good_arts_production_after = (float)$input['operationalAnalyses']['good_arts_production_after'];
        $operational_analyses->good_arts_production_change = (float)$input['operationalAnalyses']['good_arts_production_change'];
        $operational_analyses->availability_factor_before = (float)$input['operationalAnalyses']['availability_factor_before'];
        $operational_analyses->availability_factor_after = (float)$input['operationalAnalyses']['availability_factor_after'];
        $operational_analyses->availability_factor_change = (float)$input['operationalAnalyses']['availability_factor_change'];
        $operational_analyses->productivity_coefficient_before = (float)$input['operationalAnalyses']['productivity_coefficient_before'];
        $operational_analyses->productivity_coefficient_after = (float)$input['operationalAnalyses']['productivity_coefficient_after'];
        $operational_analyses->productivity_coefficient_change = (float)$input['operationalAnalyses']['productivity_coefficient_change'];
        $operational_analyses->quality_factor_before = (float)$input['operationalAnalyses']['quality_factor_before'];
        $operational_analyses->quality_factor_after = (float)$input['operationalAnalyses']['quality_factor_after'];
        $operational_analyses->quality_factor_change = (float)$input['operationalAnalyses']['quality_factor_change'];
        $operational_analyses->oee_before = (float)$input['operationalAnalyses']['oee_before'];
        $operational_analyses->oee_after = (float)$input['operationalAnalyses']['oee_after'];
        $operational_analyses->oee_change = (float)$input['operationalAnalyses']['oee_change'];
        $operational_analyses->production_volume_before = (float)$input['operationalAnalyses']['production_volume_before'];
        $operational_analyses->production_volume_after = (float)$input['operationalAnalyses']['production_volume_after'];
        $operational_analyses->production_volume_change = (float)$input['operationalAnalyses']['production_volume_change'];
        $operational_analyses->pph_per_person_before = (float)$input['operationalAnalyses']['pph_per_person_before'];
        $operational_analyses->pph_per_person_after = (float)$input['operationalAnalyses']['pph_per_person_after'];
        $operational_analyses->pph_per_person_change = (float)$input['operationalAnalyses']['pph_per_person_change'];
        $operational_analyses->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisane poprawnie',
            'payload' => $operational_analyses
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function financialAnalysesSave(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('solution_id'));
        if ($solution->financial_analyses != Null) {
            $financial_analyses = $solution->financial_analyses;
        } else {
            $financial_analyses = new FinancialAnalysis();
            $financial_analyses->solution_id = $request->input('solution_id');
        }
        $input = $request->input();
        $financial_analyses->cost_capital = (float)$input['capitalCost'];
        $financial_analyses->capex = (float)$input['capex'];
        $financial_analyses->timeframe = (float)$input['timeframe'];
        $financial_analyses->cost_per_hour_before = (float)$input['financialAnalyses']['cost_per_hour_before'];
        $financial_analyses->cost_per_hour_after = (float)$input['financialAnalyses']['cost_per_hour_after'];
        $financial_analyses->cost_per_year_before = (float)$input['financialAnalyses']['cost_per_year_before'];
        $financial_analyses->cost_per_year_after = (float)$input['financialAnalyses']['cost_per_year_after'];
        $financial_analyses->cost_per_piece_before = (float)$input['financialAnalyses']['cost_per_piece_before'];
        $financial_analyses->cost_per_piece_after = (float)$input['financialAnalyses']['cost_per_piece_after'];
        $financial_analyses->monthly_reduction_before = (float)$input['financialAnalyses']['monthly_reduction_before'];
        $financial_analyses->tkw_reduction_before = (float)$input['financialAnalyses']['tkw_reduction_before'];
        $financial_analyses->additional_savings_before = (float)$input['financialAnalyses']['additional_savings_before'];
        $financial_analyses->monthly_savings_before = (float)$input['financialAnalyses']['monthly_savings_before'];
        $financial_analyses->simple_payback = (float)$input['financialAnalyses']['simple_payback'];
        $financial_analyses->npv = (float)$input['financialAnalyses']['npv'];
        $financial_analyses->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisane poprawnie',
            'payload' => $financial_analyses
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function operationalAnalysesGet(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('id'));
        $operational_analysis = OperationalAnalysis::where('solution_id', '=', $solution->id)->first();
        $object = (object)$operational_analysis;


        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie',
            'payload' => $object
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function financialAnalysesGet(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('id'));
        $financial_analysis = FinancialAnalysis::where('solution_id', '=', $solution->id)->first();
        $object = (object)$financial_analysis;


        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie',
            'payload' => $object
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function estimateSave(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('solution_id'));
        if ($solution->estimate != Null) {
            $estimate = $solution->estimate;
        } else {
            $estimate = new Estimate();
            $estimate->solution_id = $request->input('solution_id');
        }
        $estimate->sum = 0;
        $input = $request->input();
        $estimate->integration_cost = (float)$input['integrationCost'];
        $estimate->sum += (float)$input['integrationCost'];
        $estimate->parts_cost = (float)$input['partsCost'];
        $estimate->sum += (float)$input['partsCost'];
        $estimate->mechanical_integration = (float)$input['basicCosts']['mechanical_integration'];
        $estimate->sum += (float)$input['basicCosts']['mechanical_integration'];
        $estimate->electrical_integration = (float)$input['basicCosts']['electrical_integration'];
        $estimate->sum += (float)$input['basicCosts']['electrical_integration'];
        $estimate->workstation_integration = (float)$input['basicCosts']['workstation_integration'];
        $estimate->sum += (float)$input['basicCosts']['workstation_integration'];
        $estimate->programming_robot = (float)$input['basicCosts']['programming_robot'];
        $estimate->sum += (float)$input['basicCosts']['programming_robot'];
        $estimate->programming_plc = (float)$input['basicCosts']['programming_plc'];
        $estimate->sum += (float)$input['basicCosts']['programming_plc'];
        $estimate->documentation_ce = (float)$input['basicCosts']['documentation_ce'];
        $estimate->sum += (float)$input['basicCosts']['documentation_ce'];
        $estimate->training = (float)$input['basicCosts']['training'];
        $estimate->sum += (float)$input['basicCosts']['training'];
        $estimate->project = (float)$input['basicCosts']['project'];
        $estimate->sum += (float)$input['basicCosts']['project'];
        $estimate->margin = (float)$input['basicCosts']['margin'];
        $estimate->sum += (float)$input['basicCosts']['margin'];
        $estimate->parts_prices = json_encode($input['partPrices']);
        $estimate->additional_costs = json_encode($input['additionalCosts']);
        $estimate->parts_ar = json_encode($input['partsAr']);

//        foreach($estimate as $key => $value){
//            if($key != solution_id)
//            $estimate->sum += (float)($key);
//        }

        $estimate->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisane poprawnie',
            'payload' => $estimate
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function filterMember(Request $request): JsonResponse
    {
        $id = $request->input('challenge_id');
        $challenge = Challenge::find($id);

        $query = [];

        if (Auth::user()->id === $challenge->author_id) {
            return response()->json([
                'success' => true,
                'message' => '',
                'payload' => $challenge->solutions,
            ]);
        } else {
            foreach ($challenge->solutions as $solution) {
                if (Auth::user()->id === $solution->author_id) {
                    $query[] = $solution;
                }
                foreach ($solution->teams as $team) {
                    foreach (Auth::user()->teams as $t) {
                        if (($t->id == $team->id) && (Auth::user()->id != $solution->author_id)) {
                            $query[] = $solution;
                        }
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => '',
            'payload' => $query,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function estimateGet(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('solution_id'));
        if ($solution->estimate != null) {
            return response()->json([
                'success' => true,
                'message' => '',
                'payload' => $solution->estimate
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => '',
                'payload' => ''
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkTeam(Request $request): JsonResponse
    {
        $check = false;
        $solution = Solution::find($request->solution_id);


        if ($solution != NULL) {
            foreach ($solution->teams as $team) {
                foreach (Auth::user()->teams as $t) {
                    if ($t->id == $team->id) {
                        $check = true;
                    }
                }
            }
        }


        return response()->json([
            'success' => true,
            'message' => '',
            'payload' => $check
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function likeSolution(Request $request): JsonResponse
    {

        $id = $request->input('id');
        $solution = Solution::find($id);
        $challenge = Challenge::find($solution->challenge_id);
        $user = User::find(Auth::user()->id);
        try {
            Auth::user()->viaLoveReacter()->reactTo($solution, 'Like');
            event(new SolutionLiked($solution, $user, 'Rozwiązanie zostało polubione: ' . $solution->name, []));
        } catch (Exception $e) {
            return response()->json([
                'success' => true,
                'message' => 'Error.',
                'payload' => $e
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Polajkowano.',
            'payload' => ''
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function dislikeSolution(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $solution = Solution::find($id);
        $user = User::find(Auth::user()->id);

        try {
            Auth::user()->viaLoveReacter()->unreactTo($solution, 'Like');
            event(new SolutionDisliked($solution, $user, 'Rozwiązanie zostało odlajkowane: ' . $solution->name, []));
        } catch (Exception $e) {
            return response()->json([
                'success' => true,
                'message' => 'Error.',
                'payload' => $e
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Odlajkowane.',
            'payload' => ''
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveSolution(Request $request): JsonResponse
    {
        $c = Solution::find($request->data['id']);
        $j = json_decode($request->data['save']['save_json'], true);
        if (!empty($j['screenshot'])) {

            $path = $this->processSS($j['screenshot']);
            $c->screenshot_path = $path['relative'];
            unset($j['screenshot']);
            $c->save_json = json_encode($j);

            $sum_fanuc = 0;
            $sum_yaskawa = 0;
            $sum_abb = 0;
            $sum_mitshubishi = 0;
            $sum_kuka = 0;
            $sum_tfm = 0;
            $sum_universal = 0;
            $save = json_decode($c->save_json);

            foreach ($save->parts as $part) {
                $model = UnityModel::find($part->model->model_id);
                if ($model != NULL) {
                    if ($model->brand === 'FANUC') {
                        $sum_fanuc++;
                    } else if ($model->brand === 'Yaskawa') {
                        $sum_yaskawa++;
                    } else if ($model->brand === 'ABB') {
                        $sum_abb++;
                    } else if ($model->brand === 'Mitshubishi') {
                        $sum_mitshubishi++;
                    } else if ($model->brand === 'KUKA') {
                        $sum_kuka++;
                    } else if ($model->brand === 'TFM ROBOTICS') {
                        $sum_tfm++;
                    } else if ($model->brand === 'Universal Robots') {
                        $sum_universal++;
                    }
                }
            }

            $c->number_of_fanuc = $sum_fanuc;
            $c->number_of_yaskawa = $sum_yaskawa;
            $c->number_of_abb = $sum_abb;
            $c->number_of_mitshubishi = $sum_mitshubishi;
            $c->number_of_kuka = $sum_kuka;
            $c->number_of_tfm = $sum_tfm;
            $c->number_of_universal = $sum_universal;
        }

        $c->save();
        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie.',
            'payload' => $c
        ]);
    }

    /**
     * @param $ss
     * @return array
     */
    public function processSS($ss): array
    {
        $content = base64_decode($ss);
        $name = uniqid('ss_') . '.jpg';
        $path = public_path('screenshots/' . $name);
        $image_normal = Image::make($content)->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image_normal->save(public_path('images/'. $name));

        Storage::disk('s3')->putFileAs('screenshots/', new \Illuminate\Http\File(public_path('images/'. $name)), $name);

        return ['absolute_path' => $path, 'relative' => ('s3/screenshots/' . $name)];
//        $content = base64_decode($ss);
//        $name = uniqid('ss_') . '.jpg';
//        $path = public_path('screenshots/' . $name);
//        \Illuminate\Support\Facades\File::put($path, $content);
//        Image::make($path)->resize(1000, null, function ($constraint) {
//            $constraint->aspectRatio();
//            $constraint->upsize();
//        })->save($path);
//        return ['absolute_path' => $path, 'relative' => ('screenshots/' . $name)];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function storeImage(Request $request): JsonResponse
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
        $file->save();

        return response()->json([
            'success' => true,
            'message' => 'Plik został wgrany poprawnie',
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $financial = new Financial();
        $financial->save();
        $challenge = Challenge::find($request->input('id'));
        $solution = new Solution();
        $solution->author_id = Auth::user()->id;
        $solution->challenge_id = $request->input('id');
        $solution->installer_id = Auth::user()->id;
        $solution->financial_after_id = $financial->id;
        $solution->save_json = json_encode($challenge->save_json);
        $solution->published = 0;
        $solution->status = 0;
        $solution->screenshot_path = 's3/screenshots/dbr_placeholder.jpeg';
        $solution->save();

//        $estimate = new Estimate();
//        $estimate->solution_id = $solution->id;
//        $estimate->save();
//        $financial_analyses = new FinancialAnalysis();
//        $financial_analyses->solution_id = $solution->id;
//        $financial_analyses->save();
//        $operational_analyses = new OperationalAnalysis();
//        $operational_analyses->solution_id = $solution->id;
//        $operational_analyses->save();

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

        event(new SolutionAdded($solution, $challenge->author, 'Rozwiązanie zostało dodane: ' . $solution->name, []));

        return response()->json([
            'success' => true,
            'message' => 'Rozwiązanie zostao dodane poprawnie',
            'payload' => $solution
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function publish(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('id'));
        $solution->status = 1;
        $solution->save();

        try {
            event(new SolutionPublished($solution, $solution->author, 'Nowe rozwiązanie zostało opublikowane: ' . $solution->name, []));
        } catch (\Exception $e) {

        }

        return response()->json([
            'success' => true,
            'message' => 'Opublikowano poprawnie',
            'payload' => $solution
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function unpublish(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('id'));
        $solution->status = 0;
        $solution->save();

        return response()->json([
            'success' => true,
            'message' => 'Rozwiązanie jest teraz prywatne',
            'payload' => $solution
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('id'));

        if($solution){
            $solution->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Usunięto poprawnie',
            'payload' => $solution
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSolutionFiles(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('id'));
        $solutionFiles = $solution->files()->get();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano pobrawnie',
            'payload' => $solutionFiles
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getChallengeSolutions(Request $request): JsonResponse
    {
//        $query = Solution::query();
//        $query->where('author_id', '=', Auth::user()->id);

//        if (isset($input->rating)) {
//            $query->whereIn('rating', [($input->rating - 0.5), $input->rating, ($input->rating + 0.5)]);
//        }

//        $solutions = $query->with('comments', 'comments.commentator')->get();

        $solutions = Solution::where('challenge_id', '=' , $request->get('challenge_id'))->with('comments.commentator')->get();

        foreach ($solutions as $solution) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($solution)) {
                $solution->liked = true;
            } else {
                $solution->liked = false;
            }
            $solution->comments_count = $solution->comments()->count();
            $solution->likes = $solution->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano pobrawnie',
            'payload' => $solutions
        ]);
    }

    /**
     * @param Request $request
     * @param SolutionRepository $solutionRepository
     * @param FileRepository $fileRepository
     * @param SolutionService $solutionService
     * @return JsonResponse
     */
    public function deleteFile(Request $request, SolutionRepository $solutionRepository, FileRepository $fileRepository, SolutionService $solutionService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $solution = $solutionRepository->find($request->input('solution_id'));

        if (!$solution) {
            $responseBuilder->setErrorMessage(__('messages.solution.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $file = $fileRepository->find($request->input('file_id'));

        if (!$file) {
            $responseBuilder->setErrorMessage(__('messages.file.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {
            $solutionService->detachFile($solution, $file);
            $responseBuilder->setSuccessMessage(__('messages.delete_correct'));
        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }
}
