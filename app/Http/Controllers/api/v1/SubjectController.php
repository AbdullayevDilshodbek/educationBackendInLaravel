<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\subject\SubjectCreateRequest;
use App\Http\Requests\subject\SubjectUpdateRequest;
use App\Interfaces\SubjectInterface;
use App\Models\Subject;

/**
 * @group Subjects
 */

class SubjectController extends Controller implements SubjectInterface
{
    public function __construct(private SubjectInterface $subjectRepository)
    {
    }

    /**
     * Get all subjects
     * @authenticated
     * @queryParam search string
     */
    public function index()
    {
        if (!$this->authCan('show_subjects'))
            return $this->forbidden();
        return $this->subjectRepository->index();
    }

    /**
     * Create new Subject
     * @authenticated
     */
    public function store(SubjectCreateRequest $request)
    {
        if (!$this->authCan('add_subjects'))
            return $this->forbidden();
        return $this->subjectRepository->store($request);
    }

    /**
     * Update subject data
     * @authenticated
     */
    public function update(SubjectUpdateRequest $request, Subject $subject)
    {
        if (!$this->authCan('update_subjects'))
            return $this->forbidden();
        return $this->subjectRepository->update($request, $subject);
    }

    /**
     * Change Active status
     * @authenticated
     */
    public function changeActive(Subject $subject)
    {
        if (!$this->authCan('update_subjects'))
            return $this->forbidden();
        return $this->subjectRepository->changeActive($subject);
    }
}
