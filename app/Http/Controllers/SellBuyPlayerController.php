<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\SellBuyPlayer;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellBuyPlayerController extends Controller
{
    /**
     * Lists all the players to sell and buy.
     */
    public function index(): View
    {
        $teams            = Team::with("players")->paginate(5);
        $sell_buy_players = SellBuyPlayer::where(["sell" => 1, "buy" => 0])
            ->with("player")
            ->get();

        return view(
            "teams.sell-buy-player",
            compact(["teams", "sell_buy_players"])
        );
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
            "name"    => "required",
            "team_id" => "nullable|integer",
        ]);

        Player::create($request->all());

        return response()->json(["success" => true]);
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
            "name" => "required",
            "id"   => "required|integer",
        ]);

        $player       = Player::findOrFail($id);
        $player->name = $request->name;
        $player->save();

        return response()->json(["success" => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $record = Player::findOrFail($id);
        $record->delete();

        return response()->json(["success" => true]);
    }

    /**
     * Sell a Player.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     */
    public function sell(Request $request, int $id): JsonResponse
    {
        $request->validate([
            "amount" => "required",
        ]);

        // Append custom parameters to the request
        $custom_parameters = [
            "sell" => 1,
        ];

        $request->merge($custom_parameters);
        $sell_buy_players = SellBuyPlayer::where([
            "player_id" => $id,
            "sell"      => $request->input("sell"),
            "buy"       => 0,
        ])->first();

        try {
            if ($sell_buy_players) {
                // Update the existing record
                $sell_buy_players->amount = $request->input("amount");
                $sell_buy_players->save();

                return response()->json([
                    "message" =>
                        "Player sell price updated to " .
                        $request->input("amount") .
                        " successfully",
                ]);
            } else {
                // Create a new record
                $sell_payer            = new SellBuyPlayer();
                $sell_payer->player_id = $id;
                $sell_payer->amount    = $request->input("amount");
                $sell_payer->sell      = $request->input("sell");
                $sell_payer->save();

                return response()->json(["message" => "Player up for grabs!!"]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error: " . $e->getMessage(),
            ]);
        }
    }

    /**
     * Buy a Player.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function buy(Request $request): JsonResponse
    {
        $request->validate([
            "player_id" => "required",
            "team_id"   => "required",
        ]);

        // Append custom parameters to the request
        $custom_parameters = [
            "buy" => 1,
        ];

        $request->merge($custom_parameters);

        $sell_buy_players = SellBuyPlayer::where([
            "player_id" => $request->player_id,
            "sell"      => 1,
            "buy"       => 0,
        ])->first();

        try {
            if ($sell_buy_players) {
                
                $team = Team::where("id", $request->team_id)->first();

                if ($sell_buy_players->amount < $team->balance) {
                   
                    $sell_buy_players->buy = 1;
                    $sell_buy_players->save();

                    $player = Player::where("id", $request->player_id)->first();
                    $player->team_id = $request->team_id;
                    $player->save();

                    $team->balance = $team->balance - $sell_buy_players->amount;
                    $team->save();

                    return response()->json([
                        "message" =>
                            "Player " .
                            $player->name .
                            " acquired successfully",
                    ]);
                } else {
                    return response()->json([
                        "message" =>
                            "Sorry selected team does not have sufficient balance to acquire this player!",
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error: " . $e->getMessage(),
            ]);
        }
    }
}
