<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

use App\Models\CustomerInformation;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index()
    {
        if (!check_access("dashboard")) {
            Alert::error('Error', "You don't have permission!");
            auth()->logout();
            return redirect()->route('admin.dashboard');
        }
        $monthlypurchase = null;
        $todaypurchase = null;
        $user = User::find(auth()->user()->id);
        $roles = $user->getRoleNames();

        $products = Product::where('status', 1)->get();

        $today = date('Y-m-d');
        $month = date('Y-m');

        if ($roles->contains('Super Admin')  && session('branch_id') == null) {

            // ===================== ALL BRANCH SUMMARY =====================
            $todaySale = \DB::table('sales')
                ->whereDate('date', $today)
                ->sum('total_amount');

            $todaySaleCount = \DB::table('sales')
                ->whereDate('date', $today)
                ->count();

            $monthlySale = \DB::table('sales')
                ->where('date', 'like', $month . '%')
                ->sum('total_amount');

            $monthlySaleCount = \DB::table('sales')
                ->where('date', 'like', $month . '%')
                ->count();

            $monthlyAverageSale = $monthlySaleCount > 0 ? $monthlySale / $monthlySaleCount : 0;


            // ===================== BRANCH WISE SUMMARY =====================
            $branchSales = \DB::table('branches')
                ->leftJoin('sales', 'branches.id', '=', 'sales.branch_id')
                ->select(
                    'branches.id',
                    'branches.name',
                    \DB::raw("SUM(CASE WHEN DATE(sales.date) = '$today' THEN sales.total_amount ELSE 0 END) AS today_sale"),
                    \DB::raw("COUNT(CASE WHEN DATE(sales.date) = '$today' THEN 1 END) AS today_sale_count"),

                    \DB::raw("SUM(CASE WHEN DATE_FORMAT(sales.date, '%Y-%m') = '$month' THEN sales.total_amount ELSE 0 END) AS monthly_sale"),
                    \DB::raw("COUNT(CASE WHEN DATE_FORMAT(sales.date, '%Y-%m') = '$month' THEN 1 END) AS monthly_sale_count")
                )
                ->groupBy('branches.id', 'branches.name')
                ->get();

            $suppliers = Supplier::all();
            $customers = CustomerInformation::all();
        } else {

            // ============ NORMAL USER (ONE BRANCH ONLY) =============
            $branchId = session('branch_id');

            $todaySale = \DB::table('sales')
                ->where('branch_id', $branchId)
                ->whereDate('date', $today)
                ->sum('total_amount');

            $todaySaleCount = \DB::table('sales')
                ->where('branch_id', $branchId)
                ->whereDate('date', $today)
                ->count();
            $todaypurchase = \DB::table('purchases')
                ->where('branch_id', $branchId)
                ->whereDate('purchase_date', $today)
                ->sum('total_amount');

            $monthlypurchase = \DB::table('purchases')
                ->where('branch_id', $branchId)
                ->where('purchase_date', 'like', $month . '%')
                ->sum('total_amount');

            $monthlySale = \DB::table('sales')
                ->where('branch_id', $branchId)
                ->where('date', 'like', $month . '%')
                ->sum('total_amount');

            $monthlySaleCount = \DB::table('sales')
                ->where('branch_id', $branchId)
                ->where('date', 'like', $month . '%')
                ->count();

            $monthlyAverageSale = $monthlySaleCount > 0 ? $monthlySale / $monthlySaleCount : 0;

            $branchSales = [];

            $suppliers = Supplier::where('branch_id', $branchId)->get();

            $customers = CustomerInformation::where('branch_id', $branchId)->get();
        }

        return view('backend.dashboard', compact(
            'products',
            'suppliers',
            'customers',
            'todaySale',
            'todaySaleCount',
            'monthlySale',
            'monthlySaleCount',
            'monthlyAverageSale',
            'branchSales',
            'todaypurchase',
            'monthlypurchase'
        ));
    }



    public function update_branch(Request $request)
    {


        // If branch_id is central (for example ID = 0), set session to null
        if ($request->branch_id == 0) { // change 0 to whatever ID represents central
            session(['branch_id' => null]);
        } else {
            // Store selected branch_id in session
            session(['branch_id' => $request->branch_id]);
        }

        Alert::success('Login', 'Branch assigned successfully!');

        return redirect($request->redirect_to ?? route('admin.dashboard'));
    }



    public function login()
    {
        return view('backend.login');
    }

    public function doLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                Alert::warning('Invalid', 'Invalid data given!');
                return redirect()->back()->withInput()->withErrors($validator);
            }
            $creds = $request->except('_token');
            if (auth()->attempt($creds)) {

                $user = auth()->user();

                // Check if user has Super Admin role
                if ($user->roles->pluck('name')->contains('Super Admin')) {

                    return redirect()->route('admin.dashboard');
                }

                // Check how many branches are assigned to the user
                $userBranches = $user->branches;

                if ($userBranches->count() == 1) {
                    // Only one branch assigned, set in session
                    session(['branch_id' => $userBranches->first()->branch_id]);
                    return redirect()->route('admin.dashboard');
                } elseif ($userBranches->count() > 1) {
                    $branches = $userBranches;
                    return view('backend.assign_branch', compact('branches'));
                } else {
                    // No branch assigned
                    Alert::warning('No Branch', 'No branch assigned to your account!');
                    auth()->logout();
                    return redirect()->back();
                }
            }
            Alert::error('Login', 'Invalid Email or Password!');
            return redirect()->back();
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }


    public function assign_branch(Request $request)
    {
        $branches = \App\Models\Branch::where('status', 1)->get();
        // original URL ধরার জন্য
        $redirectTo = $request->query('redirect_to', url()->previous());

        return view('backend.assign_branch_modal', compact('branches', 'redirectTo'));
    }

    public function logout()
    {
        try {
            $user = User::find(auth()->user()->id);

            // Clear branch session
            session()->forget('branch_id');

            // Logout user
            auth()->logout();

            Alert::success('Logout', 'Logout Successful!');
            return redirect()->route('admin.login');
        } catch (\Exception $exception) {
            Alert::error('Error', $exception->getMessage());
            return redirect()->back();
        }
    }
}
