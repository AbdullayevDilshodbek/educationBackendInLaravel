<?php

namespace App\Repositories;

use App\Http\Requests\PositionRequest;
use App\Http\Resources\PositionResource;
use App\Interfaces\PositionInterface;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;

class PositionRepository implements PositionInterface
{

    public function __construct(private Position $position, private Auth $auth)
    {}

    public function index()
    {
        $search = request('search' ,'');
        $positions = $this->position::where('organization_id', $this->auth::user()->organization_id)
            ->where('title', 'like', "%$search%")
            ->paginate(env('PG'));
        return PositionResource::collection($positions);
    }

    public function store(PositionRequest $request)
    {
        $this->position::create([
            'title' => $request->title,
            'organization_id' => $this->auth::user()->organization_id
        ]);
        return response()->json(['message' => env('MESSAGE_SUCCESS')], 201);
    }

    public function update(PositionRequest $request, int $id)
    {
        $this->position::find($id)
            ->update([
                'title' => $request->title
            ]);
        return response()->json(['message' => env('MESSAGE_SUCCESS')],200);
    }

    public function changeActive(int $id)
    {
        $position = $this->position::find($id);
        $position->update([
            'active' => !$position->active
        ]);
        return response()->json(['message' => env('MESSAGE_SUCCESS')],200);
    }

    public function getAllForAutoComplete()
    {
        return $this->position::where('organization_id', $this->auth::user()->organization_id)
            ->get();
    }
}
