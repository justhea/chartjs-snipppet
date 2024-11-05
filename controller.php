public function dashboardPassAndFailed(Request $request)
    {
        $passed = Summary::where("ga", ">=", 75)
            ->count();
        $failed = Summary::where("ga", "<", 75)
            ->count();

        return response()->json([
            "passed" => $passed,
            "failed" => $failed,
        ]);
    }

    public function dashboardGradesDifference(Request $request)
    {
        $class_a = Summary::whereBetween('ga', [90, 100])
            ->count();
        $class_b = Summary::whereBetween('ga', [85, 89])
            ->count();
        $class_c = Summary::whereBetween('ga', [80, 84])
            ->count();
        $class_d = Summary::whereBetween('ga', [75, 79])
            ->count();


        return response()->json([
            "class_a" => $class_a,
            "class_b" => $class_b,
            "class_c" => $class_c,
            "class_d" => $class_d,

        ]);
    }

    public function dashboardSectionCount(Request $request)
    {

        $sections = Summary::select('section')
            ->distinct()
            ->pluck('section'); // Only get the 'section' values as a list
    

        $labels = [];
        $data = [];
    

        foreach ($sections as $section) {

            $count = Summary::where("section", $section)->count();
    

            $labels[] = "Section {$section}";
            $data[] = $count;
        }
    

        return response()->json([
            
            'labels' => $labels,
            'data' => $data,
        ]);
    }
    
    public function dashboardGradesAverage()
{
    $sectionAverages = Summary::selectRaw('section, AVG(ga) as average_ga')
        ->groupBy('section')
        ->pluck('average_ga', 'section')
        ->toArray();

    $chartData = [
        'labels' => array_keys($sectionAverages),
        'datasets' => [
            [
                'data' => array_values($sectionAverages),
                'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
            ]
        ]
    ];

    return response()->json($chartData);
}

public function dashboardSectionPassing()
{
    $passingData = Summary::selectRaw('section, 
        COUNT(*) as total_students, 
        SUM(CASE WHEN ga >= 70 THEN 1 ELSE 0 END) as passing_students')
        ->groupBy('section')
        ->get()
        ->map(function ($item) {
            $passingRate = $item->total_students > 0 
                ? ($item->passing_students / $item->total_students) * 100 
                : 0;
            return [
                'section' => 'Section ' . $item->section,
                'passing_rate' => round($passingRate, 2)
            ];
        });

    $chartData = [
        'labels' => $passingData->pluck('section')->toArray(),
        'datasets' => [
            [
                'data' => $passingData->pluck('passing_rate')->toArray(),
                'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
            ]
        ]
    ];

    return response()->json($chartData);
}
