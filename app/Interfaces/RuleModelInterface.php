<?php
namespace App\Interfaces;

use App\Http\Requests\rule\CreateRuleModelRequest;
use App\Http\Requests\rule\UpdateRuleModelRequest;
use App\Models\RuleModel;

interface RuleModelInterface {
    public function index();
    public function store(CreateRuleModelRequest $request);
    public function update(UpdateRuleModelRequest $request, RuleModel $ruleModel);
}
