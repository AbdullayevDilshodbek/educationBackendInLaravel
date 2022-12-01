<?php
namespace App\Interfaces;

use App\Http\Requests\subject\SubjectCreateRequest;
use App\Http\Requests\subject\SubjectUpdateRequest;
use App\Models\Subject;

interface  SubjectInterface
{
    public function index();
    public function store(SubjectCreateRequest $request);
    public function update(SubjectUpdateRequest $request, Subject $subject);
    public function changeActive(Subject $subject);
}
