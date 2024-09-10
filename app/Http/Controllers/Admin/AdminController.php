<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\JobController;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobIndustry;
use App\Models\JobRole;
use App\Models\JobType;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    #-- load admin login file ---#
    public function index(Request $request)
    {
        return view('admin.pages.login');
    }

    #--- dashboard ---#
    public function dashboard(Request $request)
    {
        return view('admin.pages.dashboard');
    }

    #----- check admin login ---#
    public function checkAuth(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin'], $request->remember)) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcom back admin');
            }
            return redirect()->back()->with('warning', 'Credentials not match');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    #--- logout --#
    public function logout()
    {
        Auth::logout();
        return redirect('admin');
    }

    #--- Company ---#
    public function company(Request $request)
    {
        $data = User::where('role', 'company')->latest()->withCount('job')->paginate(10)->appends($request->query());
        return view('admin.pages.companies', ['data' => $data]);
    }

    #--- Employees ---#
    public function employees(Request $request)
    {
        $data = User::where('role', 'employee')->latest()->paginate(10)->appends($request->query());
        return view('admin.pages.employees', ['data' => $data]);
    }

    #--- Jobs ---#
    public function jobs(Request $request)
    {
        $jobData             = new JobController();
        $data                = $jobData->getJobData();
        $data['companies']   = User::where(['role' => 'company', 'status' => 'active'])->get();
        $data['jobs']        = Job::with(['company'])
            ->when($request->company, function ($query) use ($request) {
                $query->where('user_id', $request->company);
            })
            ->when($request->category, function ($query) use ($request) {
                $query->where('job_category', $request->category);
            })
            ->when($request->industry, function ($query) use ($request) {
                $query->where('job_industry', $request->industry);
            })
            ->when($request->type, function ($query) use ($request) {
                $type = explode(',', $request->type);
                $query->where(function ($q) use ($type) {
                    $q->orWhereJsonContains('job_type', $type);
                });
            })->latest()->paginate(25)->appends($request->query());
        return view('admin.pages.jobs', ['data' => $data]);
    }

    #--- Jobs Categories ---#
    public function jobsCategory(Request $request)
    {
        $data = JobCategory::latest()->paginate(10);
        return view('admin.pages.job_category', ['data' => $data]);
    }
    #--- Jobs Roles ---#
    public function jobsRoles(Request $request)
    {
        $data = JobRole::paginate(10);
        return view('admin.pages.job_roles', ['data' => $data]);
    }
    #--- Jobs Types ---#
    public function jobsTypes(Request $request)
    {
        $data = JobType::paginate(10);
        return view('admin.pages.job_types', ['data' => $data]);
    }
    #--- Jobs Industries ---#
    public function jobsIndustry(Request $request)
    {
        $data = JobIndustry::paginate(10);
        return view('admin.pages.job_industries', ['data' => $data]);
    }
}
