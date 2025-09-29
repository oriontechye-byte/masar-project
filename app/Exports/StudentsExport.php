<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentsExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    protected $filters;
    protected $testType;

    public function __construct(array $filters, string $testType = 'pre')
    {
        $this->filters = $filters;
        $this->testType = $testType;
    }

    public function query()
    {
        $query = DB::table('students')
            ->leftJoin('test_results', 'students.id', '=', 'test_results.student_id');

        // Apply filters
        if (!empty($this->filters['governorate'])) {
            $query->where('governorate', $this->filters['governorate']);
        }
        if (!empty($this->filters['start_date'])) {
            $query->whereDate('students.created_at', '>=', $this->filters['start_date']);
        }
        if (!empty($this->filters['end_date'])) {
            $query->whereDate('students.created_at', '<=', $this->filters['end_date']);
        }

        // Select columns based on test type
        if ($this->testType === 'post') {
            $query->select(
                'students.full_name', 'students.whatsapp_number', 'students.governorate',
                'students.gpa', 'students.graduation_year', 'students.created_at',
                'test_results.post_score_social', 'test_results.post_score_visual', 'test_results.post_score_intrapersonal',
                'test_results.post_score_kinesthetic', 'test_results.post_score_logical', 'test_results.post_score_naturalist',
                'test_results.post_score_linguistic', 'test_results.post_score_musical'
            )->whereNotNull('test_results.post_score_social'); // Only students who took the post-test
        } else {
            $query->select(
                'students.full_name', 'students.whatsapp_number', 'students.governorate',
                'students.gpa', 'students.graduation_year', 'students.created_at',
                'test_results.score_social', 'test_results.score_visual', 'test_results.score_intrapersonal',
                'test_results.score_kinesthetic', 'test_results.score_logical', 'test_results.score_naturalist',
                'test_results.score_linguistic', 'test_results.score_musical'
            );
        }

        return $query->orderBy('students.created_at', 'desc');
    }

    public function headings(): array
    {
        $baseHeadings = [
            'الاسم الكامل', 'رقم الواتساب', 'المحافظة', 'المعدل', 'سنة التخرج', 'تاريخ التسجيل'
        ];

        $scoreType = ($this->testType === 'post') ? '(بعدي)' : '(قبلي)';

        $scoreHeadings = [
            'الذكاء الاجتماعي ' . $scoreType,
            'الذكاء البصري ' . $scoreType,
            'الذكاء الذاتي ' . $scoreType,
            'الذكاء الحركي ' . $scoreType,
            'الذكاء المنطقي ' . $scoreType,
            'الذكاء الطبيعي ' . $scoreType,
            'الذكاء اللغوي ' . $scoreType,
            'الذكاء الموسيقي ' . $scoreType,
        ];

        return array_merge($baseHeadings, $scoreHeadings);
    }
}
