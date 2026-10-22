<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Packages\University\Enums\StudentInterviewStatusEnum;
use Packages\University\Models\AcademicYear;
use Packages\University\Models\College;
use Packages\University\Models\StudentInterview;

class StudentInterviewReportController extends Controller
{
    public function printReport(Request $request)
    {
        $query = StudentInterview::with(['student.academicRecord', 'college', 'academicYear', 'conductedBy'])
            ->orderBy('created_at', 'DESC');

        if ($request->filled('college_id')) {
            $query->where('college_id', $request->college_id);
        }

        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('interview_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('interview_date', '<=', $request->to);
        }

        $records = $query->get();

        $total = $records->count();
        $pending = $records->filter(fn($r) => $r->status === StudentInterviewStatusEnum::Pending || $r->status === 'pending')->count();
        $passed = $records->filter(fn($r) => $r->status === StudentInterviewStatusEnum::Passed || $r->status === 'passed')->count();
        $rejected = $records->filter(fn($r) => $r->status === StudentInterviewStatusEnum::Rejected || $r->status === 'rejected')->count();
        $evaluated = $passed + $rejected;
        $passRate = $evaluated > 0 ? round(($passed / $evaluated) * 100, 1) : 0;

        $selectedCollege = $request->filled('college_id') ? College::find($request->college_id) : null;
        $selectedYear = $request->filled('academic_year_id') ? AcademicYear::find($request->academic_year_id) : null;

        return view('filament.reports.student-interviews-report', [
            'records' => $records,
            'total' => $total,
            'pending' => $pending,
            'passed' => $passed,
            'rejected' => $rejected,
            'passRate' => $passRate,
            'selectedCollege' => $selectedCollege,
            'selectedYear' => $selectedYear,
            'filters' => $request->all(),
        ]);
    }

    public function printCard(StudentInterview $record)
    {
        $record->load(['student.academicRecord.college', 'student.academicRecord.academicYear', 'college', 'academicYear', 'conductedBy']);

        return view('filament.reports.student-interview-card', [
            'record' => $record,
            'student' => $record->student,
        ]);
    }
}
