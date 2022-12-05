<?php
namespace App\Repositories\RuleAndPermission;

use App\Http\Requests\rule\CreateRuleModelRequest;
use App\Http\Requests\rule\UpdateRuleModelRequest;
use App\Http\Resources\RuleModelResource;
use App\Interfaces\RuleModelInterface;
use App\Models\RuleModel;

class RuleModelRepository implements RuleModelInterface
{
    public function __construct(private RuleModel $ruleModel)
    {

    }
    public function index()
    {
        $search = request('search', '');
        $ruleModels = $this->ruleModel::where('title', 'ilike', "%$search%")
            ->paginate(env('PG'));
        return RuleModelResource::collection($ruleModels);
    }

    public function store(CreateRuleModelRequest $request)
    {
        $this->ruleModel::create($request->all());
        return response()->json(['message' => 'Amalyot bajarildi'],201);
    }

    public function update(UpdateRuleModelRequest $request, RuleModel $ruleModel)
    {
        $ruleModel->update($request->all());
        return response()->json(['message' => 'Amalyot bajarildi'],200);
    }
}
