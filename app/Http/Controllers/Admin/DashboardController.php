 <?php
    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    class DashboardController extends Controller
    {
        public function index()
        {
            $totalStudents = DB::table('students')->count();
            // You can add more stats here later
            // $testsTaken = DB::table('test_results')->count();

            return view('admin.dashboard', [
                'totalStudents' => $totalStudents,
            ]);
        }
    }
    
