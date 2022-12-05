<?php
namespace App\Interfaces;

use App\Http\Requests\rule\CreateRuleRequest;
use App\Http\Requests\rule\UpdateRuleRequest;
use App\Models\Rule;

interface RuleInterface {
    public function index();
    public function store(CreateRuleRequest $request);
    public function update(UpdateRuleRequest $request, Rule $rule);
}
