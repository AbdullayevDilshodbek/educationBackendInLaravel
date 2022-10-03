<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\Group;
use App\Models\Lesson;
use App\Repositories\Attendance\AttendanceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller implements AttendanceInterface
{

    private AttendanceInterface $attendanceRepository;

    public function __construct(AttendanceInterface $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function index()
    {
        return $this->attendanceRepository->index();
        // return AttendanceResource::collection(Group::where('groups.id', request('group_id'))
        //     ->Join('group_to_students as gs', 'gs.group_id', '=', 'groups.id')
        //     ->Join('students as s', 's.id', '=', 'gs.student_id')
        //     ->groupBy('gs.student_id')
        //     ->orderByDesc('gs.student_id')
        //     ->select(['groups.id', 'gs.student_id', 'groups.group_name', 's.first_name', 's.last_name'])
        //     ->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $now = date('Y-m-d');
        $check = Lesson::where('date', $now)
            ->where('group_id', $request->group_id)
            ->first();
        $lesson = null;
        DB::beginTransaction();
        try {
            if (!$check) {
                $lesson = Lesson::create([
                    'group_id' => $request->group_id,
                    'date' => $now
                ]);
            } else {
                $lesson = $check;
            }
            foreach ($request->attendance as $item) {
                $student_data = [
                    'student_id' => $item['student_id'],
                    'lesson_id' => $lesson->id,
                    'status' => $item['status']
                ];
                $validator = Validator::make($student_data, [
                    'student_id' => 'required',
                    'lesson_id' => 'required',
                    'status' => 'required',
                ], [
                    'student_id.required' => 'Student mavjud emas',
                    'lesson_id.required' => 'Dars ni aniqlashdagi xatolik',
                    'status.required' => 'Student kelgan yoki kelmagani belgilanmadi',
                ]);
                if ($validator->fails())
                    return response()->json(['message' => $validator->getMessageBag()], 400);
                if (!$check) {
                    Attendance::create([
                        'student_id' => $item['student_id'],
                        'lesson_id' => $lesson->id,
                        'status' => $item['status'],
                    ]);
                } else {
                    Attendance::Join('lessons as l', 'l.id', '=', 'attendances.lesson_id')
                        ->where('l.group_id', $request->group_id)
                        ->where('attendances.student_id', $item['student_id'])
                        ->where('l.date', $now)
                        ->update([
                            'status' => $item['status']
                        ]);
                }
            }
            $message = $check ? 'Davomad yangilandi' : 'Davomad yaratildi';
            DB::commit();
            return response()->json(['message' => $message], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => 'Xatolik yuz berdi, qayta urinib ko\'ring'], 400);
        }
    }
}
