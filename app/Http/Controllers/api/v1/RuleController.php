<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\rule\CreateRuleRequest;
use App\Http\Requests\rule\UpdateRuleRequest;
use App\Interfaces\RuleInterface;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller implements RuleInterface
{
    public function __construct(private RuleInterface $ruleRepository)
    {
    }

    public function index()
    {
        return $this->ruleRepository->index();
    }

    public function store(CreateRuleRequest $request)
    {
        return $this->ruleRepository->store($request);
    }

    public function update(UpdateRuleRequest $request, Rule $rule)
    {
        return $this->ruleRepository->update($request, $rule);
    }
}
