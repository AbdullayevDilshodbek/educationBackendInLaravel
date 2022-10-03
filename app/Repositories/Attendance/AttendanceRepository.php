<?php

namespace App\Repositories\Attendance;

use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\Group;
use App\Repositories\Attendance\AttendanceInterface;
use Illuminate\Http\Request;

class AttendanceRepository implements AttendanceInterface
{
    private Group $group;

    public function __construct(Group $group, Attendance $attendance)
    {
        $this->group = $group;
    }

    public function index()
    {
        $groupStudents = $this->group::where('groups.id', request('group_id'))
            ->Join('group_to_students as gs', 'gs.group_id', '=', 'groups.id')
            ->Join('students as s', 's.id', '=', 'gs.student_id')
            ->groupBy('gs.student_id')
            ->orderByDesc('gs.student_id')
            ->select(['groups.id', 'gs.student_id', 'groups.group_name', 's.first_name', 's.last_name'])
            ->get();
        return AttendanceResource::collection($groupStudents);
    }

    public function store(Request $request)
    {

    }
}
