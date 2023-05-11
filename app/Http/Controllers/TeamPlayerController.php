<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\SellBuyPlayer;
use App\Models\Team;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamPlayerController extends Controller
{
    /**
     * Lists all the players.
     * 
     * @return View
     */
    public function index(): View
    {
        $teams   = Team::with('players')->paginate(5);

        return view('teams.teams-player-listing',compact(['teams']))
                    ->with('i', 1);
    }
  
    /**
     * Adds a player.
     * 
     * @param  Request $request
     * @return JsonResponse
     * 
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name'    => 'required',
            'surname' => 'required',
            'team_id' => 'nullable|integer',
        ]);
        
        Player::create($request->all());
         
        return response()->json(['success' => true]);
    }
  
    /**
     * Update the specified resource in storage.
     * 
     * @param Request $request
     * @param int     $id
     * 
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'name'    => 'required',
            'surname' => 'required'
        ]);
        
        $player          = Player::findOrFail($id);
        $player->name    = $request->name;
        $player->surname = $request->surname;
        $player->save();
          
        return response()->json(['success' => true]);
    }
  
    /**
     * Remove the specified resource from storage.
     * 
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {

        $record = Player::findOrFail($id);
        $record->delete();
         
        return  response()->json(['message' => "Player Deleted Successfully"]);
    }
}
