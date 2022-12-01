<?php

namespace App\Repositories;

use App\Http\Requests\subject\SubjectCreateRequest;
use App\Http\Requests\subject\SubjectUpdateRequest;
use App\Http\Resources\SubjectResource;
use App\Interfaces\SubjectInterface;
use App\Models\Subject;

class SubjectRepository implements SubjectInterface
{

    public function __construct(private Subject $subject)
    {
    }

    public function index()
    {
        $search = request('search', '');
        return SubjectResource::collection($this->subject::orderByDesc('id')
            ->where('title', 'ILike', "%$search%")
            ->paginate(env('PG')));
    }

    public function store(SubjectCreateRequest $request)
    {
        $this->subject::create([
            'title' => $request->title
        ]);
        return response()->json(['message' => 'Amalyot bajarildi'],201);
    }

    public function update(SubjectUpdateRequest $request, Subject $subject)
    {
        $subject->update([
            'title' => $request->title
        ]);
        return response()->json(['message' => 'Amalyot bajarildi'],200);
    }

    public function changeActive(Subject $subject)
    {
        $subject->active = !$subject->active;
        $subject->save();
        return response()->json(['message' => 'Amalyot bajarildi'],200);
    }

}
