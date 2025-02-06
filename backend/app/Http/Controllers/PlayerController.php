<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Models\Player;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PlayerResource::collection(Player::with('teams')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlayerRequest $request)
    {
        $data = $request->validated();
        $player = Player::create($data);
        
        $team = [];
        foreach($data['team'] as $key => $value){
            if($key != 'id'){
                $team[$key] = $value;
            }
        }

        $player->teams()->attach($data['team']['id'], $team);
        
        return new PlayerResource($player->load('teams'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        return new PlayerResource($player->load('teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlayerRequest $request, Player $player)
    {
        $player->update($request->validated());
        return new PlayerResource($player);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $player->teams()->detach();
        $player->delete();
        return response()->noContent();
    }
}
