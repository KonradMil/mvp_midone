<?php

namespace App\Http\Controllers\Crud;

use App\Events\SolutionAccepted;
use App\Events\SolutionPublished;
use App\Events\SolutionRejected;
use App\Http\Controllers\Controller;
use App\Models\Challenges\Challenge;
use App\Models\Estimate;
use App\Models\FinancialAnalysis;
use App\Models\Offer;
use App\Models\OperationalAnalysis;
use App\Models\Solutions\Solution;
use App\Models\File;
use App\Models\Financial;
use App\Models\Team;
use App\Models\TechnicalDetails;
use App\Models\UnityModel;
use Carbon\Carbon;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Types\Boolean;
use Psr\Log\NullLogger;

class SolutionController extends Controller
{
    public function filterChallengeSolutions(Request $request)
    {
        $option = $request->input('option');
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        $solutions = NULL;
        if($option === 'Cena-max'){
            $solutions = $challenge->solutions()->orderBy('estimate.sum', 'DESC')->get();
        }else if($option === 'Cena-min'){
            $solutions = $challenge->solutions()->join('estimates', 'solution.id', '=', 'estimates.solution_id')->orderBy('solution.sum', 'ASC')->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Filter ok',
            'payload' => $solutions
        ]);
    }
    public function getUserSolutionsArchive()
    {
        $solutions = Solution::where('archive', '=' , 1)->get();
        $filterSolutions = [];

        foreach($solutions as $solution){
            foreach($solution->teams as $team){
                foreach(Auth::user()->teams as $t){
                    if($team->id == $t->id){
                        $filterSolutions[] = $solution;
                    }
                }
            }
            if($solution->author_id == Auth::user()->id){
                $filterSolutions[] = $solution;
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Pobrano archiwalne rozwiązania poprawnie.',
            'payload' => $filterSolutions
        ]);
    }
    public function deleteSolutionsNull()
    {
        $solutions = Solution::all();
        foreach($solutions as $solution){
            $challenge = Challenge::find($solution->challenge_id);
            if($challenge==NULL){
                $solution->delete();
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Pobrano rozwiązania poprawnie.',
            'payload' => $solutions
        ]);
    }

    public function getUserSolutionsProject(Request $request)
    {
        $id = $request->input('id');
        $solutions = Solution::where('author_id', '=', Auth::user()->id)->where('challenge_id', '=', $id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Pobrano rozwiązania poprawnie.',
            'payload' => $solutions
        ]);
    }

    public function getUserSolutionsChallenge(Challenge $challenge)
    {
        $solutions = $challenge->solutions->where('author_id', '=', Auth::user()->id);

        return response()->json([
            'success' => true,
            'message' => 'Pobrano rozwiązania poprawnie.',
            'payload' => $solutions
        ]);
    }
    public function saveSolutionTeams(Request $request, Solution $solution)
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

    public function rejectSolution(Request $request)
    {
        $id = $request->input('id');
        $solution = Solution::find($id);
        $solution->rejected = true;
        $solution->selected = false;
        $solution->offers()->delete();
        $solution->selected_offer_id = 0;
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

    public function getRobots(Request $request)
    {
        $solution = Solution::find($request->input('id'));
        if(!empty($request->input('offer_id')))
        {
            $offer = Offer::find($request->input('offer_id'));
            $robots = json_decode($offer->robots);

        }   else {
            $save = json_decode($solution->save_json);
            $robots = [];
            foreach ($save->parts as $part) {
                $model = UnityModel::find($part->model->model_id);
                $model->guarantee_period = 0;
                if($model->category == 1) {

                    $robots[] = $model;
                }
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $robots
        ]);
    }

    public function acceptSolution (Request $request) {
        $id = $request->input('id');
        $solution = Solution::find($id);
        $challenge = Challenge::find($solution->challenge_id);
//        $challenge->stage = 2;
//        $challenge->save();
        $solution->selected = true;
        $solution->rejected = false;
        $solution->save();

        event(new SolutionAccepted($solution, $challenge->author, 'Rozwiązanie zostało zaakceptowane: ' . $solution->name, []));

        return response()->json([
            'success' => true,
            'message' => 'Zatwierdzono rozwiązanie.',
            'payload' => $solution
        ]);
    }

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
        $query->where('author_id', '=', Auth::user()->id);

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
    public function operationalAnalysesSave(Request $request)
    {
        $solution = Solution::find($request->input('solution_id'));
        if($solution->operational_analyses != Null) {
            $operational_analyses = $solution->operational_analyses;
        } else {
            $operational_analyses = new OperationalAnalysis();
            $operational_analyses->solution_id = $request->input('solution_id');
        }
        $input = $request->input();
        $operational_analyses->time_available_before= (float)$input['operationalAnalyses']['time_available_before'];
        $operational_analyses->time_available_after= (float)$input['operationalAnalyses']['time_available_after'];
        $operational_analyses->time_available_change= (float)$input['operationalAnalyses']['time_available_change'];
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
    public function financialAnalysesSave(Request $request)
    {
        $solution = Solution::find($request->input('solution_id'));
        if($solution->financial_analyses != Null) {
            $financial_analyses = $solution->financial_analyses;
        } else {
            $financial_analyses = new FinancialAnalysis();
            $financial_analyses->solution_id = $request->input('solution_id');
        }
        $input = $request->input();
        $financial_analyses->cost_capital = (float)$input['capitalCost'];
        $financial_analyses->capex =  (float)$input['capex'];
        $financial_analyses->timeframe =  (float)$input['timeframe'];
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
    public function estimateSave(Request $request)
    {
        $solution = Solution::find($request->input('solution_id'));
        if($solution->estimate != Null) {
            $estimate = $solution->estimate;
        } else {
            $estimate = new Estimate();
            $estimate->solution_id = $request->input('solution_id');
        }
        $input = $request->input();
        $estimate->integration_cost = (float)$input['integrationCost'];
        $estimate->sum += (float)$input['integrationCost'];
        $estimate->parts_cost =  (float)$input['partsCost'];
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

    public function filterMember(Request $request)
    {
        $id = $request-> input('challenge_id');
        $challenge = Challenge::find($id);

        $query = [];

        if(Auth::user()->id === $challenge->author_id) {
            return response()->json([
                'success' => true,
                'message' => '',
                'payload' => $challenge->solutions,
            ]);
        }
        else {
            foreach ($challenge->solutions as $solution) {
                if (Auth::user()->id === $solution->author_id) {
                    $query[] = $solution;
                }
                foreach ($solution->teams as $team) {
                      foreach (Auth::user()->teams as $t) {
                              if (($t->id == $team->id) && (Auth::user()->id != $solution->author_id) ) {
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

    public function estimateGet(Request $request)
    {
        $solution = Solution::find($request->input('solution_id'));
        if($solution->estimate != null) {
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

    public function dislikeSolution(Request $request)
    {
        $id = $request->input('id');
        $solution= Solution::find($id);
        Auth::user()->viaLoveReacter()->unreactTo($solution, 'Like');

        return response()->json([
            'success' => true,
            'message' => 'Odlajkowane.',
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

    public function publish(Request $request)
    {
        $solution = Solution::find($request->input('id'));
        $solution->status = 1;
        $solution->save();

        event(new SolutionPublished($solution, $solution->author, 'Nowe rozwiązanie zostało opublikowane: ' . $solution->name, []));

        return response()->json([
            'success' => true,
            'message' => 'Opublikowano poprawnie',
            'payload' => $solution
        ]);
    }

    public function unpublish(Request $request)
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

    public function delete(Request $request)
    {
        $solution = Solution::find($request->input('id'));
        if($solution != NULL){
            $solution->delete();
        }


        return response()->json([
            'success' => true,
            'message' => 'Usunięto poprawnie',
            'payload' => ''
        ]);
    }
}
