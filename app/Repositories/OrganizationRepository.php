<?php

namespace App\Repositories;

use App\Http\Requests\OrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Interfaces\OrganizationInterface;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;

class OrganizationRepository implements OrganizationInterface
{
    public function __construct(private Organization $organization, private Auth $auth){}

    public function index()
    {
        $auth = $this->auth::user();
        $organizations = $this->organization::with(['parent'])
            ->orWhere('id', $auth->organization_id)
            ->orWhere('parent_id', $auth->organization_id)
            ->paginate(env('PG'));
        return OrganizationResource::collection($organizations);
    }

    public function store(OrganizationRequest $request)
    {
        $this->organization::create([
            'title' => $request->title,
            'parent_id' => $request->parent_id
        ]);
        return response()->json(['message' => env('MESSAGE_SUCCESS')],201);
    }

    public function update(OrganizationRequest $request, Organization $organization)
    {
        $organization->update([
            'title' => $request->title,
            'parent_id' => $request->parent_id
        ]);
        return response()->json(['message' => env('MESSAGE_SUCCESS')],200);
    }

    public function changeActive(int $id)
    {
        $organization = $this->organization::find($id);
        $organization->active = !$organization->active;
        $organization->save();
        return response()->json(['message' => env('MESSAGE_SUCCESS')],200);
    }

    public function getAllForAutoComplete()
    {
        $auth = $this->auth::user();
        return $this->organization::with(['parent'])
            ->orWhere('id', $auth->organization_id)
            ->orWhere('parent_id', $auth->organization_id)
            ->get();
    }
}
