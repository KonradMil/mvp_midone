<?php

namespace App\Http\Controllers;


use App\Events\ChallengeLiked;
use App\Events\ChallengePublished;
use App\Models\Challenge;
use App\Models\File;
use App\Models\Financial;
use App\Models\FreeSave;
use App\Models\LocalVision;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Solution;
use App\Models\Team;
use App\Models\TechnicalDetails;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use function Symfony\Component\String\s;

/**
 *
 */
class ChallengeController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserChallengesArchive(Request $request): JsonResponse
    {
        $input = $request->input();
        $query = Challenge::query();
        $query->where('stage', '=', 3)->where('status', '=', 1);
        $challengesProject = Challenge::where('stage', '=', 3)->where('status', '=', 1)->get();
        $ar = [];
        if ($challengesProject != NULL && Auth::user()->type === 'investor') {
            $check = false;
            foreach ($challengesProject as $challenge) {
                if (Auth::user()->id == $challenge->author_id) {
                    $query->where('author_id', '=', Auth::user()->id)->where('stage', '=', 3);
                    array_push($ar, $challenge->id);
                    $check = true;
                }
                foreach ($challenge->teams as $team) {
                    foreach (Auth::user()->teams as $t) {
                        if ($t->id == $team->id) {
                            $query->where('author_id', '=', Auth::user()->id)->where('stage', '=', 3);
                            $check = true;
                            array_push($ar, $challenge->id);
                        }
                    }
                }
            }


            if (isset($input->type)) {
                $query->where('type', '=', $input->type);
            }

            if (isset($input->favourite)) {
                $query->where('favourite', '=', 1);
            }

            $challenges = $query->with(['comments.commentator', 'technicalDetails', 'financial_before'])->whereIn('id', $ar)->get();

            $ars = [];

            $ts = Auth::user()->teams;

            foreach ($ts as $tt) {
                array_push($ars, $tt->id);
            }

            $c = Challenge::whereHas('teams', function ($query) use ($ars) {
                $query->whereIn('teams.id', $ars);
            })->orderBy('created_at', 'DESC')->where('stage', '=', 3)->where('status', '=', 1)->get();


            $merged = $challenges->merge($c);

            foreach ($challenges as $challenge) {

                if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Like')) {
                    $challenge->liked = true;
                } else {
                    $challenge->liked = false;
                }
                $challenge->comments_count = $challenge->comments()->count();
                $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();

                if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Follow', 1)) {
                    $challenge->followed = true;
                } else {
                    $challenge->followed = false;
                }
            }
            if ($check === true) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pobrano poprawnie.',
                    'payload' => $merged->all()
                ]);
            } else {

            }
            return response()->json([
                'success' => true,
                'message' => 'Brak projektów.',
                'payload' => ''
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Brak projektów.',
                'payload' => ''
            ]);
        }
    }


    /**
     * @param Request $request
     * @param Financial $financial
     * @return JsonResponse
     */
    public function saveChallengeFinancials(Request $request, Financial $financial): JsonResponse
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
     * @param TechnicalDetails $technical
     * @return JsonResponse
     */
    public function saveChallengeDetails(Request $request, TechnicalDetails $technical): JsonResponse
    {
        $technical->fill($request->input('data'));
        $technical->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano edycje.',
            'payload' => $technical
        ]);
    }

    /**
     * @param Request $request
     * @param Challenge $challenge
     * @return JsonResponse
     */
    public function saveChallengeTeams(Request $request, Challenge $challenge): JsonResponse
    {
        foreach ((array)$request->teams as $team_id) {
            $team = Team::find($team_id);
            $challenge->teams()->sync($team);
        }

        return response()->json([
            'success' => true,
            'message' => 'Zapisano edycje.',
            'payload' => $challenge
        ]);
    }




    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveFreeSave(Request $request): JsonResponse
    {
        if ($request->get('id')) {
            try {
                $freeSave = FreeSave::find($request->get('id'));
                $freeSave->name = $request->get('name');
                $freeSave->en_name = $request->get('en_name');
                $freeSave->description = $request->get('description');
                $freeSave->en_description = $request->get('en_description');

                $j = $request->get('save');

                    $a = json_decode($j['save_json'], true);
                if (!empty($a['screenshot'])) {
                    $path = $this->processSS($a['screenshot']);
                    $freeSave->screenshot_path = $path['relative'];
                    unset($a['screenshot']);

                }
                $freeSave->save_json = json_encode($a);
                $freeSave->save();

            } catch (Exception $e) {

            }
        } else {
//            $newFreeSave = new FreeSave();
//            $user = User::find(Auth::user()->id);
//            $user->freeusers()->attach($newFreeSave);
//            $newFreeSave->name = $request->get('name');
//            $newFreeSave->en_name = $request->get('en_name');
//            $newFreeSave->description = $request->get('description');
//            $newFreeSave->en_description = $request->get('en_description');
//
//            $j = json_decode($request->data['save']['save_json'], true);
//
//            if (!empty($j['screenshot'])) {
//
//                $path = $this->processSS($j['screenshot']);
//                $newFreeSave->screenshot_path = $path['relative'];
//                unset($j['screenshot']);
//                $newFreeSave->save_json = json_encode($j);
//            }
//
//            $newFreeSave->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie.',
            'payload' => $freeSave
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveChallenge(Request $request): JsonResponse
    {
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
        $image_normal->save(public_path('images/' . $name));

        Storage::disk('s3')->putFileAs('screenshots/', new \Illuminate\Http\File(public_path('images/' . $name)), $name);

        return ['absolute_path' => $path, 'relative' => ('s3/screenshots/' . $name)];
    }

    /**
     * @return JsonResponse
     */
    public function getUserChallenges(): JsonResponse
    {
        if (Auth::user()->type == 'integrator') {
            $challenges = Challenge::whereIn('stage', [1, 2])->where('status', '=', 1)->orderBy('created_at', 'DESC')->get();
        } else if (Auth::user()->type == 'inwestor') {
            $challenges = Auth::user()->challenges()->orderBy('created_at', 'ASC')->get();
        } else {
            $challenges = Auth::user()->challenges()->with('technicalDetails')->orderBy('created_at', 'DESC')->get();
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
    public function getUserChallengesProjects(Request $request): JsonResponse
    {
        $input = $request->input();
        $query = Challenge::query();
        $query->where('stage', '=', 3)->where('status', '=', 1);
        $challengesProject = Challenge::where('stage', '=', 3)->where('status', '=', 1)->get();
        $ar = [];
        if ($challengesProject != NULL) {
            $check = false;
            if (Auth::user()->type == 'integrator') {
                foreach ($challengesProject as $challenge) {
                    $offer = Offer::find($challenge->selected_offer_id);
                    if ($offer != NULL) {
                        $solution = Solution::find($offer->solution_id);
                        if ($solution->author_id == Auth::user()->id) {
                            $query->where('stage', '=', 3)->where('status', '=', 1);
                            $check = true;
                            array_push($ar, $challenge->id);
                        } else {
                            foreach ($solution->teams as $team) {
                                foreach (Auth::user()->teams as $t) {
                                    if ($t->id == $team->id) {
                                        $query->where('stage', '=', 3)->where('status', '=', 1);
                                        $check = true;
                                        array_push($ar, $challenge->id);
                                    }
                                }
                            }
                        }
                    }
                }
            } else if (Auth::user()->type == 'investor') {
                foreach ($challengesProject as $challenge) {
                    if (Auth::user()->id == $challenge->author_id) {
                        $query->where('author_id', '=', Auth::user()->id)->where('stage', '=', 3);
                        array_push($ar, $challenge->id);
                        $check = true;
                    }
                    foreach ($challenge->teams as $team) {
                        foreach (Auth::user()->teams as $t) {
                            if ($t->id == $team->id) {
                                $query->where('author_id', '=', Auth::user()->id)->where('stage', '=', 3);
                                $check = true;
                                array_push($ar, $challenge->id);
                            }
                        }
                    }
                }
            }

            if (isset($input->type)) {
                $query->where('type', '=', $input->type);
            }

            if (isset($input->favourite)) {
                $query->where('favourite', '=', 1);
            }

            $challenges = $query->with(['comments.commentator', 'technicalDetails', 'financial_before'])->whereIn('id', $ar)->get();

            $ars = [];

            $ts = Auth::user()->teams;

            foreach ($ts as $tt) {
                array_push($ars, $tt->id);
            }

            $c = Challenge::whereHas('teams', function ($query) use ($ars) {
                $query->whereIn('teams.id', $ars);
            })->orderBy('created_at', 'DESC')->where('stage', '=', 3)->where('status', '=', 1)->get();


            $merged = $challenges->merge($c);

            foreach ($challenges as $challenge) {

                if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Like')) {
                    $challenge->liked = true;
                } else {
                    $challenge->liked = false;
                }
                $challenge->comments_count = $challenge->comments()->count();
                $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();

                if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Follow', 1)) {
                    $challenge->followed = true;
                } else {
                    $challenge->followed = false;
                }
            }
            if ($check === true) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pobrano poprawnie.',
                    'payload' => $merged->all()
                ]);
            } else {

            }
            return response()->json([
                'success' => true,
                'message' => 'Brak projektów. Check minus',
                'payload' => ''
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Brak projektów.',
                'payload' => ''
            ]);
        }


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
        } else if (Auth::user()->type == 'investor') {
            $query->whereIn('stage', [0, 1, 2])->where('author_id', '=', Auth::user()->id);
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

        $challenges = $query->with(['comments.commentator', 'technicalDetails', 'financial_before'])->orderBy('created_at', 'DESC')->get();

        $ars = [];

        $ts = Auth::user()->teams;

        foreach ($ts as $tt) {
            array_push($ars, $tt->id);
        }

        $c = Challenge::whereHas('teams', function ($query) use ($ars) {
            $query->whereIn('teams.id', $ars);
        })->orderBy('created_at', 'DESC')->get();

        $merged = $challenges->merge($c);

        foreach ($challenges as $challenge) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Like')) {
                $challenge->liked = true;
            } else {
                $challenge->liked = false;
            }
            $challenge->comments_count = $challenge->comments()->count();
            $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();

            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Follow', 1)) {
                $challenge->followed = true;
            } else {
                $challenge->followed = false;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $merged->all()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserChallengesFollowed(Request $request): JsonResponse
    {
        $input = $request->input();
        $query = Challenge::query();
        if (Auth::user()->type == 'integrator') {
            $query->whereIn('stage', [1, 2])->where('status', '=', 1);
        } else if (Auth::user()->type == 'investor') {
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

        $challenges = $query->with(['comments.commentator', 'technicalDetails'])->orderBy('created_at', 'DESC')->get();

        foreach ($challenges as $key => $challenge) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Follow', 1)) {
                $challenge->followed = true;
            } else {
                $challenges->forget($key);
            }
            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Like')) {
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
    public function unfollowChallenge(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        Auth::user()->viaLoveReacter()->unreactTo($challenge, 'Follow');

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
    public function followChallenge(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        Auth::user()->viaLoveReacter()->reactTo($challenge, 'Follow');

//        event(new ChallengeFollowed($challenge, $challenge->author_id, 'Użytykownik obserwuje Twoje wyzwanie!: ' . $challenge->name, []));

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
    public function likeChallenge(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        $user = User::find(Auth::user()->id);

        try {
            Auth::user()->viaLoveReacter()->reactTo($challenge, 'Like');
            event(new ChallengeLiked($challenge, $user, 'Wyzwanie zostało polubione: ' . $challenge->name, []));

//            event(new ChallengeLiked($challenge, $challenge->author, 'Wyzwanie zostało polubione: ' . $challenge->name, []));
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
    public function dislikeChallenge(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        Auth::user()->viaLoveReacter()->unreactTo($challenge, 'Like');
//        dd([$request->input('id'), Auth::user()->id]);
//        $r = Reaction::where('reactant_id', '=', $request->input('id'))->where('reacter_id', '=', Auth::user()->id)->first();
//        $r->delete();

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
    public function storeImage(Request $request): JsonResponse
    {
//        $request->validate([
//            'file' => 'required|mimes:jpg,png,JPG,jpeg|max:4096',
//        ]);

        $ext = $request->file->extension();
        $fileName = time() . '.' . $ext;
        Storage::disk('s3')->putFileAs('screenshots', $request->file, $fileName);
//        $request->file->move(public_path('uploads'), $fileName);
        $file = new File();
        $file->name = $fileName;
        $file->ext = $ext;
        $file->path = 's3/screenshots/' . $fileName;
        $file->original_name = $request->file->getClientOriginalName();
        $file->author_id = Auth::user()->id;
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
     * @return JsonResponse
     */
    public function createChallenge(Request $request): JsonResponse
    {
        $request = json_decode(json_encode($request->data));
        if (isset($request->id)) {
            $challenge = Challenge::find($request->id);
            $financial = $challenge->financial_before;
            $technical = $challenge->technicalDetails;
        } else {
            $challenge = new Challenge();
            $challenge->save_json = '{"parts":[],"animation_layers":{"layers":[],"groups":[]},"layouts":{"layouts":[],"labels":[],"comments":[],"robotTrackers":[]},"presentationModel":{"cameraStations":[]},"hangarModel":{"name":"","id":0,"prefabUrl":"","customData":"","limits":{"maxLimits":{"x":0.0,"y":0.0,"z":0.0},"minLimits":{"x":0.0,"y":0.0,"z":0.0}}},"cameraPosition":{"position":{"x":0.0,"y":0.0,"z":0.0},"rotation":{"x":0.0,"y":0.0,"z":0.0}},"screenshot":"","saveVersion":""}';
            $technical = new TechnicalDetails();
            $financial = new Financial();
            $financial->save();
        }

        $challenge->name = $request->name;

        $challenge->description = $request->description;
        $challenge->type = $request->type;
        $challenge->category = $request->category;
        try {
            $challenge->solution_deadline = Carbon::createFromFormat('d.m.Y', $request->solution_deadline);
        } catch (Exception $e) {
            $challenge->solution_deadline = Carbon::createFromFormat('Y-m-d H:i:s', $request->solution_deadline);
        }
        try {
            $challenge->offer_deadline = Carbon::createFromFormat('d.m.Y', $request->offer_deadline);
        } catch (Exception $e) {
            $challenge->offer_deadline = Carbon::createFromFormat('Y-m-d H:i:s', $request->offer_deadline);
        }

        $challenge->allowed_publishing = $request->allowed_publishing;
        $challenge->financial_before_id = $financial->id;
        $challenge->author_id = Auth::user()->id;

        if (!isset($request->id)) {
            $challenge->screenshot_path = 's3/screenshots/dbr_placeholder.jpeg';
        }
        if (!isset($request->id)) {
            $challenge->status = 0;
            $challenge->stage = 0;
        }
        $challenge->save();

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
        $financial->challenge_id = $challenge->id;
        $financial->save();

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

        if (!isset($request->id)) {
            $technical->cycle_time = 0;
            $technical->challenge_id = $challenge->id;
        }

        $technical->save();
        if (!isset($request->id)) {
            foreach ($challenge->files as $file) {
                $challenge->files()->detach($file);
            }
        }
        foreach ($request->images as $image) {
            $challenge->files()->attach($image->id);
        }
        if (!isset($request->id)) {
            foreach ($challenge->teams as $team) {
                $challenge->teams()->detach($team);
            }
        }
//        foreach ($request->teams as $team_id) {
//            $team = Team::find($team_id);
//            $challenge->teams()->attach($team);
//        }

        if (!isset($request->id)) {
            if ($challenge->status == 1) {

            }
//            event(new ChallengeAdded($challenge, Auth::user(), 'Wyzwanie ' . $challenge->name . ' zostało dodane.', ['financial' => $financial, 'technical' => $technical]));
            $financial->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Wyzwanie zostało dodane poprawnie',
            'payload' => $challenge
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveDescription(Request $request): JsonResponse
    {
//        dd($request->data);
        $challenge = Challenge::find($request->data['id']);
        $challenge->name = $request->data['name'];
        $challenge->description = $request->data['description'];
        $challenge->save();

        return response()->json([
            'success' => true,
            'message' => 'Wyzwanie zostało zapisane poprawnie',
            'payload' => $challenge
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkTeam(Request $request): JsonResponse
    {
        $check = false;
        $challenge = Challenge::find($request->challenge_id);
        foreach ($challenge->teams as $team) {
            foreach (Auth::user()->teams as $t) {
                if ($t->id == $team->id) {
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $id = $request->input('id');
        Challenge::destroy($id);
//        $challenge = Challenge::where('id', '=', $request->input('id'))->first();
//        dd($challenge);
//        $challenge->author_id = 0;
//        $challenge->save();

        return response()->json([
            'success' => true,
            'message' => '',
            'payload' => ''
        ]);
    }

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
                'teams.users.companies', 'solutions.comments', 'solutions.comments.commentator',
                'solutions.teams', 'solutions.teams.users', 'solutions.teams.users.companies', 'solutions.offers', 'solutions.estimate'
            )->find($request->id);

            $user = Auth::user();

            if (!$challenge) {
                abort(404);
            }

        } else {
            $challenge = NULL;
        }

//        if(empty($challenge->technicalDetails)) {
//            $technical = new TechnicalDetails();
//            $technical->challenge_id = $challenge->id;
//            $technical->save();
//            $challenge->technical_details = $technical;
//        }

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
        $project = Project::where('challenge_id', '=', $challenge->id);

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
    public function publish(Request $request): JsonResponse
    {
        $challenge = Challenge::with('solutions', 'author')->find($request->input('id'));
        $challenge->status = 1;
        $challenge->stage = 1;
        $challenge->save();

        try {
            event(new ChallengePublished($challenge, $challenge->author, 'Nowe wyzwanie zostało opublikowane: ' . $challenge->name, []));
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'payload' => $e
            ]);
        }


        return response()->json([
            'success' => true,
            'message' => 'Opublikowano poprawnie.',
            'payload' => $challenge
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changeDates(Request $request): JsonResponse
    {
        $challenge = Challenge::find($request->input('id'));
        try {
            $challenge->solution_deadline = Carbon::createFromFormat('d.m.Y', $request->solution_deadline);
        } catch (Exception $e) {
            $challenge->solution_deadline = Carbon::createFromFormat('Y-m-d H:i:s', $request->solution_deadline);
        }
        try {
            $challenge->offer_deadline = Carbon::createFromFormat('d.m.Y', $request->offer_deadline);
        } catch (Exception $e) {
            $challenge->offer_deadline = Carbon::createFromFormat('Y-m-d H:i:s', $request->offer_deadline);
        }
        $challenge->save();
        return response()->json([
            'success' => true,
            'message' => 'Opublikowano poprawnie.',
            'payload' => $challenge
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function unpublish(Request $request): JsonResponse
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserChallengesGoodProjects(Request $request): JsonResponse
    {
        $input = $request->input();

        $query = Challenge::query();
        if (Auth::user()->type == 'integrator') {
            $query->whereIn('stage', [1, 2])->where('status', '=', 1);
        } else if (Auth::user()->type == 'investor') {
            $query->where('author_id', '=', Auth::user()->id)->where('stage', '=', 3);
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

        $challenges = $query->where('stage', '=', 3)->with(['comments.commentator', 'technicalDetails', 'financial_before'])->orderBy('created_at', 'DESC')->get();

        $ars = [];

        $ts = Auth::user()->teams;

        foreach ($ts as $tt) {
            array_push($ars, $tt->id);
        }

        $c = Challenge::whereHas('teams', function ($query) use ($ars) {
            $query->whereIn('teams.id', $ars);
        })->orderBy('created_at', 'DESC')->get();


        $merged = $challenges->where('stage', '=', 3)->merge($c);

        foreach ($challenges as $challenge) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Like')) {
                $challenge->liked = true;
            } else {
                $challenge->liked = false;
            }
            $challenge->comments_count = $challenge->comments()->count();
            $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();

            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Follow', 1)) {
                $challenge->followed = true;
            } else {
                $challenge->followed = false;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $merged->all()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function localVisionSave(Request $request): JsonResponse
    {
        $challenge = Challenge::find($request->input('id'));
        $reports = $request->input('reports');


        foreach ($reports as $report) {
            $vision = new LocalVision();
            $vision->project_id = $challenge->id;
            $vision->description = $report['description'];
            $vision->before = $report['before'];
            $vision->after = $report['after'];
            $vision->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $challenge->id
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function localVisionGet(Request $request): JsonResponse
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
    public function localVisionDelete(Request $request): JsonResponse
    {
        $report = LocalVision::where('id', '=', $request->input('id'))->first();
        if ($report != null) {
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
    public function financialDetailsSave(Request $request): JsonResponse
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
    public function technicalDetailsSave(Request $request): JsonResponse
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
    public function projectOfferAccept(Request $request): JsonResponse
    {
        $challenge = Challenge::find($request->input('id'));
        $challenge->project_accept_offer = 1;
        $challenge->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $challenge
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function projectOfferDetails(Request $request): JsonResponse
    {
        $challenge = Challenge::find($request->input('id'));
        $challenge->project_accept_details = 1;
        $challenge->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $challenge
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function localVisionAccept(Request $request): JsonResponse
    {
        $challenge = Challenge::find($request->input('id'));
        $challenge->project_accept_vision = 1;
        $challenge->save();

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $challenge
        ]);
    }

    public function adminGetProjects(): JsonResponse
    {
        $challenges = Challenge::with(['solutions' => function ($query) {
            $query->where('selected', '=', '1');
        }, 'solutions.author', 'author', 'author.own_company', 'solutions.author.own_company'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie',
            'payload' => $challenges
        ]);

    }

    public function adminGetUsers()
    {
        $users = User::with('author')->get();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie',
            'payload' => $users
        ]);
    }

    public function getUserChallengesByTab(Request $request, $category)
    {
        if (Auth::user()->type == 'investor') {
            $challenges = Challenge::where('author_id', '=', Auth::user()->id)
                ->where('challenges.category', '=', $category)
                ->where('challenges.stage', '<', 3)
                ->get();
        } else {
            $challenges = Challenge::where('status', '=', 1)
                ->where('challenges.category', '=', $category)
                ->where('challenges.stage', '<', 3)
                ->get();
        }

        $ars = [];

        $ts = Auth::user()->teams;

        foreach ($ts as $tt) {
            array_push($ars, $tt->id);
        }

        $c = Challenge::where('challenges.category', '=', $category)->whereHas('teams', function ($query) use ($ars) {
            $query->whereIn('teams.id', $ars);
        })->orderBy('created_at', 'DESC')->get();

        $cc = $challenges->merge($c);

        foreach ($cc as $challenge) {

            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Like')) {
                $challenge->liked = true;
            } else {
                $challenge->liked = false;
            }
            $challenge->comments_count = $challenge->comments()->count();
            $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();

            if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Follow', 1)) {
                $challenge->followed = true;
            } else {
                $challenge->followed = false;
            }
        }

        if (!empty($cc)) {
            return response()->json([
                'success' => true,
                'message' => 'Pobrano poprawnie.',
                'payload' => $cc
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Brak projektów.',
                'payload' => ''
            ]);
        }
    }
}
