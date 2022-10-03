<?php

namespace App\Repositories\Attendance;

use Illuminate\Http\Request;

interface AttendanceInterface {
    public function index();
    public function store(Request $request);
}
