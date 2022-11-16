<?php

namespace App\Repositories;

use App\Http\Requests\OrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Interfaces\OrganizationInterface;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;

class OrganizationRepository extends Repository implements OrganizationInterface
{
    public function __construct(private Organization $organization, private Auth $auth)
    {
    }

    public function index()
    {
        $auth = $this->auth::user();
        $search = request('search', '');
        $organizations = $this->organization::with(['parent'])
            ->where(function($query) use($auth){
                return $query->where('id', $auth->organization_id)
                ->orWhere('parent_id', $auth->organization_id);
            })
            ->where('title', 'like', "%$search%")
            ->orderByDesc('id')
            ->paginate(1);
        return OrganizationResource::collection($organizations);
    }

    public function store(OrganizationRequest $request)
    {
        $this->organization::create([
            'title' => $request->title,
            'parent_id' => $request->parent_id
        ]);
        return response()->json(['message' => $this->message['ok']], 201);
    }

    public function update(OrganizationRequest $request, int $id)
    {
        $organization = $this->organization::find($id);
        $organization->update([
            'title' => $request->title,
            'parent_id' => $request->parent ? $request->parent_id : null
        ]);
        return response()->json(['message' => $this->message['ok']], 200);
    }

    public function changeActive(int $id)
    {
        $organization = $this->organization::find($id);
        $organization->active = !$organization->active;
        $organization->save();
        return response()->json(['message' => $this->message['ok']], 200);
    }

    public function getAllForAutoComplete()
    {
        $selfId = request('id', 0);
        $auth = $this->auth::user();
        return $this->organization::with(['parent'])
            ->where(function ($query) use ($auth) {
                $query->orWhere('id', $auth->organization_id)
                    ->orWhere('parent_id', $auth->organization_id);
            })
            ->where('id', '!=', $selfId)
            ->get();
    }
}
