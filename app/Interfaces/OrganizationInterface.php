<?php

namespace App\Interfaces;

use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;

interface OrganizationInterface
{
    public function index();
    public function store(OrganizationRequest $request);
    public function update(OrganizationRequest $request, Organization $organization);
    public function changeActive(int $id);
    public function getAllForAutoComplete();
}
