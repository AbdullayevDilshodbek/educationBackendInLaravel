<?php

namespace App\Interfaces;

use App\Http\Requests\PositionRequest;

interface PositionInterface
{
    public function index();
    public function store(PositionRequest $request);
    public function update(PositionRequest $request, int $id);
    public function changeActive(int $id);
}
