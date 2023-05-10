<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
  /**
     * Lists all the players.
     * 
     * @param  void
     * @return View
     */
    public function index(): View
    {
        $players = Player::where('team_id', 1)->latest()->paginate(5);  
        $teams   = Team::pluck('name', 'id');

        return view('teams.index',compact(['players', 'teams']))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Adds a player.
     * 
     * @param  Request $request
     * @return JsonResponse
     * 
     */
    public function store(Request $request):JsonResponse
    {
        $request->validate([
            'name'    => [
                    'required',
                    Rule::unique('teams', 'name'),
                ],
            'country' => [
                    'required',
                    'string',
                    'regex:/^[a-zA-Z]{3}$/',
                ],
            'balance' => 'required',
        ], [
            'country.size' => 'The country code must be exactly :size characters long.',
        ],);
         
        $team = Team::create($request->all());
        return response()->json(['success' => true, 'id' => $team->id, 'name' => json_encode($team->name)]);
    }

  
    /**
     * Show the form to edit Player Details.
     * 
     * @param Player $player
     * @return View
     */
    public function edit(Player $player): View
    {
        return view('teams.edit',compact('players'));
    }
  
    /**
     * Update the specified resource in storage.
     * 
     * @param Request $request
     * @param int     $team_id
     * 
     * @return JsonResponse
     */
    public function update(Request $request, int $team_id): JsonResponse
    {

        $request->validate([
            'name'    => [
                    'required',
                    Rule::unique('teams', 'name'),
                ],
            'country' => [
                    'required',
                    'string',
                    'regex:/^[a-zA-Z]{3}$/',
                ],
            'balance' => 'required',
        ], [
            'country.size' => 'The country code must be exactly :size characters long.',
        ],);
        
        $team          = Team::findOrFail($team_id);
        $team->name    = $request->name;
        $team->country = $request->country;
        $team->balance = $request->balance;
        $team->save();
        
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
        $team    = Team::findOrFail($id); 
        $players = Player::where('team_id', $id)->get();

        foreach($players as $player) {
            $player->delete();
        }

        $team->delete();
         
        return  response()->json(['success' => true]);
    }
}
