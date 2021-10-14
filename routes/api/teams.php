<?php

use App\Http\Controllers\TeamsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'teams', 'middleware' => 'auth:sanctum'], function () {
    Route::post('user/get/permissions', [TeamsController::class, 'getMemberPermission']);
    Route::post('user/save/permissions', [TeamsController::class, 'saveMemberPermission']);
    Route::post('user/create', [TeamsController::class, 'createTeam']);
    Route::post('user/add', [TeamsController::class, 'addUserToTeam']);
    Route::post('user/invite', [TeamsController::class, 'inviteUser']);
    Route::post('user/invites/get', [TeamsController::class, 'getUserInvites']);
    Route::post('user/invite/accept', [TeamsController::class, 'acceptInvite']);
    Route::post('user/get', [TeamsController::class, 'getUserTeamsFiltered']);
    Route::post('user/delete', [TeamsController::class, 'deleteTeam']);
    Route::post('user/member/delete', [TeamsController::class, 'deleteMember']);
    Route::post('user/add/team', [TeamsController::class, 'addObjectTeam']);
    Route::post('remove-from-selected', [TeamsController::class, 'removeFromSelected']);
    Route::post('add-to-selected', [TeamsController::class, 'addToSelected']);
    Route::post('object/get', [TeamsController::class, 'getObjectTeams']);
});
