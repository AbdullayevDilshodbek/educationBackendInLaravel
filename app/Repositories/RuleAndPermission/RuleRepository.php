<?php

namespace App\Repositories\RuleAndPermission;

use App\Http\Requests\rule\CreateRuleRequest;
use App\Http\Requests\rule\UpdateRuleRequest;
use App\Http\Resources\RuleResource;
use App\Interfaces\RuleInterface;
use App\Models\Rule;
use App\Models\RuleModel;

class RuleRepository implements RuleInterface
{
    public function __construct(private RuleModel $ruleModel,private Rule $rule)
    {
    }
    public function index()
    {
        $search = request('search', '');
        $rules = $this->rule::where('title', 'ilike', "%$search%")
            ->paginate(env('PG'));
        return RuleResource::collection($rules);
    }

    public function store(CreateRuleRequest $request)
    {
        $this->rule::create($request->all());
        return response()->json(['message' => 'Amalyot bajarildi'],201);
    }

    public function update(UpdateRuleRequest $request, Rule $rule)
    {
        $rule->update($request->all());
    }
}
