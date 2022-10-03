<?php

namespace App\Http\Resources;

use App\Models\Attendance;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{

    public function toArray($request)
    {
       $historyAttendance = $this->getAttendanceOfThreeDays();
        return [
            'id' => $this->student_id,
            'student' => [
                'id' => $this->student_id,
                'full_name' => $this->first_name . ' ' . $this->last_name],
            'group' => $this->group_name,
            'attendance' => [
                'first_day' => count($historyAttendance) != 0 ? $historyAttendance[0]['status'] : null,
                'two_day' => count($historyAttendance) > 1 ? $historyAttendance[1]['status'] : null,
                'three_day' => count($historyAttendance) > 2 ? $historyAttendance[2]['status'] : null
            ],
            'bad' => count($historyAttendance) > 3 ? $historyAttendance[0]['status'] == 1 && $historyAttendance[1]['status'] == 1
            && $historyAttendance[2]['status'] == 1 && $historyAttendance[3]['status'] == 1 ? false : true : false
        ];
    }

    public function getAttendanceOfThreeDays()
    {
        return Attendance::Join('lessons', 'lessons.id','=', 'attendances.lesson_id')
            ->where('student_id', $this->student_id)
            ->where('lessons.group_id', $this->id)
            ->orderByDesc('attendances.id')
            ->skip(0)
            ->take(4)
            ->get();
    }
}
