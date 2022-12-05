<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\rule\CreateRuleModelRequest;
use App\Http\Requests\rule\UpdateRuleModelRequest;
use App\Interfaces\RuleModelInterface;
use App\Models\RuleModel;
use Illuminate\Http\Request;

class RuleModelController extends Controller implements RuleModelInterface
{
    public function __construct(private RuleModelInterface $ruleModelRepository)
    {

    }

    public function index()
    {
        return $this->ruleModelRepository->index();
    }

    public function store(CreateRuleModelRequest $request)
    {
        return $this->ruleModelRepository->store($request);
    }

    public function update(UpdateRuleModelRequest $request, RuleModel $ruleModel)
    {
        return $this->ruleModelRepository->update($request, $ruleModel);
    }
}
