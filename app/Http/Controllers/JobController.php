<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\AppliedJob;
use App\Models\City;
use App\Models\Country;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobIndustry;
use App\Models\JobRole;
use App\Models\JobType;
use App\Models\Qualification;
use App\Models\State;
use App\Models\User;
use App\Traits\CommonTrait;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Auth\Access\Gate as AccessGate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Stmt\Catch_;

class JobController extends Controller
{
    use ImageTrait, CommonTrait;

    #-- find candidates blade file ---#
    public function findCandidates(Request $request)
    { 
        if (Gate::allows('company')) {
            if ($request->ajax()) {
                $data = $this->getEmp($request);
                $html = view('components.emp-feed', ['data' => $data])->render();

                return response()->json(['status' => 200, 'message' => 'emps', 'data' => $html, 'pagination' => (string) $data->links()]);
            }
            $data = $this->getEmp($request);
            return view('front.pages.find_candidates', ['data' => $data]);
        }
        return redirect()->route('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getEmp($request, $limit = '')
    {
        $emp = User::where('role', 'employee');
        $emp->when($request->profile, function ($query) use ($request) {
            $query->where('profile', 'LIKE', '%' . $request->profile . '%');
        });
        $emp->when($request->location, function ($query) use ($request) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        });
        $emp->when($request->industry, function ($query) use ($request) {
            if (is_array($request->industry)) {
                $industries = $request->industry;
            } else {
                $industries = explode(',', $request->industry);
            }
            $query->whereIn('industry_id', $industries);
        });

        if ($limit) {
            return $emp->with(['skills'])->limit($limit)->inRandomOrder()->get();
        }
        return $emp->with(['skills'])->paginate(12)->appends($request->query());
    }

    public function getJobs($request, $limit = '')
    {
        DB::enableQueryLog();
        $userId = Auth::id();
        $jobs  =  Job::where('jobs.status', true)
            ->leftJoin('applied_jobs', function ($join) use ($userId) {
                $join->on('jobs.id', '=', 'applied_jobs.job_id')
                    ->where('applied_jobs.user_id', '=', $userId);
            })
            ->select('jobs.*', 'applied_jobs.id as user_applied');
        $jobs->when($request->title, function ($query) use ($request) {
            $query->where('title', 'LIKE', '%' . $request->title . '%');
        });
        $jobs->when($request->location, function ($query) use ($request) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        });
        $jobs->when($request->industry, function ($query) use ($request) {
            if (is_array($request->industry)) {
                $industries = $request->industry;
            } else {
                $industries = explode(',', $request->industry);
            }
            $query->whereIn('job_industry', $industries);
        });
        $jobs->when($request->types, function ($query) use ($request) {
            if (is_array($request->types)) {
                $types = $request->types;
            } else {
                $types = explode(',', $request->types);
            }
            $query->where(function ($q) use ($types) {
                $q->orWhereJsonContains('job_type', $types);
            });
        });
        $jobs->when($request->category, function ($query) use ($request) {
            if (is_array($request->category)) {
                $category = $request->category;
            } else {
                $category = explode(',', $request->category);
            }
            $query->whereIn('job_category', $category);
        });
        $jobs->when($request->roles, function ($query) use ($request) {
            if (is_array($request->roles)) {
                $roles = $request->roles;
            } else {
                $roles = explode(',', $request->roles);
            }
            $query->whereIn('job_role', $roles);
        });
        $jobs->when($request->salary, function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    // Case 1: Salary is fixed and matches the provided salary
                    $q->whereColumn('salary', 'max_salary')
                        ->where('salary', '<=', (int)$request->salary);
                })
                    ->orWhere(function ($q) use ($request) {
                        // Case 2: Salary is within a range and falls below or equal to the provided salary
                        $q->where('salary', '<=', (int)$request->salary)
                            ->where('max_salary', '>=', (int)$request->salary);
                    });
            });
        });

        $jobs = $jobs->with(['role', 'industry', 'category']);
        if ($limit) {
            return    $jobs->limit($limit)->inRandomOrder()->get();
        }
        return $jobs->latest()->paginate(12)->appends($request->query());
        dd(DB::getQueryLog());
    }

    public function getJob($id)
    {
        return Job::where('id', $id)->with(['role', 'industry', 'category'])->first();
    }

    public function getJobData()
    {
        $data['job_types']          = JobType::where('status', 1)->get();
        $data['job_categories']     = JobCategory::where('status', 1)->get();
        $data['job_roles']          = JobRole::where('status', 1)->get();
        $data['job_industries']     = JobIndustry::where('status', 1)->get();

        return $data;
    }
    public function findJobs(Request $request)
    {
        if (auth()->check() && auth()->user()->role !== 'employee') {
            return redirect()->route('index');
        }

        $jobs = $this->getJobs($request);
        if ($request->ajax()) {
            $html = view('components.job-feed', ['jobs' => $jobs, 'viewType' => 1])->render();

            return response()->json(['status' => 200, 'message' => 'jobs', 'data' => $html, 'pagination' => (string) $jobs->links()]);
        }
        $data = $this->getJobData();

        return view('front.pages.find_jobs', compact('data', 'jobs'));
    }

    public function index()
    { 
        if (Gate::allows('company')) {

            $data = $this->getJobData();
            $data['qualifications'] = Qualification::where('status', true)->get();
            $company = User::with(['country', 'state', 'city'])->find(Auth::id());
            return view('front.pages.create-post', compact('data', 'company'));
        }
        return redirect()->route('index');
    }

    public function editJobs($id)
    {
        if (Gate::allows('company')) {
            $data = $this->getJobData();
            $data['qualifications'] = Qualification::where('status', true)->get();
            $job = Job::find(Crypt::decrypt($id));

            return view('front.pages.create-post', compact('data', 'job'));
        }
        return redirect()->route('index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        try {

            $job = new Job();
            $job->user_id = Auth::id();
            $job->title = $request->job_title;
            $job->job_role = $request->job_role;
            $job->job_industry = $request->job_industry;
            $job->job_category = $request->job_category;
            $job->vacancies = $request->vacancies;
            $job->experience = $request->experience;
            $job->deadline = $request->deadline;
            $job->description = $request->job_desc;
            $job->salary_type = $request->salary_type;
            $job->location = $this->getLocation($request);
            if ($request->salary_type === 'range') {
                $job->salary = $request->min_salary;
                $job->max_salary = $request->max_salary;
            }
            if ($request->salary_type === 'fixed') {
                $job->salary = $request->fixed_salary;
                $job->max_salary = $request->fixed_salary;
            }

            $job->job_type = json_encode($request->job_type);
            $job->qualification = json_encode($request->qualification);
            $job->save();

            return redirect()->back()->with('success', 'Job created successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Something went wrong');
        }
    }

    public function updateJobs(JobRequest $request, $id)
    {
        try {
            $job = Job::find($id);
            $job->title                 = $request->job_title;
            $job->job_role              = $request->job_role;
            $job->job_industry          = $request->job_industry;
            $job->job_category          = $request->job_category;
            $job->vacancies             = $request->vacancies;
            $job->experience            = $request->experience;
            $job->deadline              = $request->deadline;
            $job->description           = $request->job_desc;
            $job->salary_type           = $request->salary_type;
            $job->location              = $this->getLocation($request);
            if ($request->salary_type === 'range') {
                $job->salary            = $request->min_salary;
                $job->max_salary        = $request->max_salary;
            }
            if ($request->salary_type === 'fixed') {
                $job->salary            = $request->fixed_salary;
                $job->max_salary        = $request->fixed_salary;
            }
            $job->job_type              = json_encode($request->job_type);
            $job->qualification         = json_encode($request->qualification);
            $job->save();

            return redirect()->back()->with('success', 'Job updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Something went wrong');
        }
    }


    function getSalary($request)
    {
        if ($request->salary_type == 'range') {
            $salary                = $request->min_salary . '-' . $request->max_salary;
        }
        if ($request->salary_type == 'fixed') {
            $salary                =  $request->fixed_salary;
        }
        return $salary;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function jobDetails($id)
    {
        $jobId  = Crypt::decrypt($id);
        $job    = $this->getJob($jobId);
        $check  = AppliedJob::where('user_id', Auth::id())->where('job_id', $jobId)->exists();
        return view('front.pages.job-details', ['job' => $job, 'check' => $check]);
    }

    public function myJobDetails($id)
    {
        if (Gate::allows('company')) {
            $jobId          = Crypt::decrypt($id);
            $job            = Job::find($jobId);
            $job->users     = AppliedJob::where(['job_id' => $jobId])->with(['user.country', 'user.state', 'user.city'])->paginate(20);

            return view('front.pages.single-job-details', ['job' => $job]);
        }
        abort(403);
    }

    #--- Apply jobs -----#
    public function applyJob(Request $request)
    {
        $request->validate([
            'id' => ['required']
        ]);

        $check = AppliedJob::where(['job_id' => Crypt::decrypt($request->id), 'user_id' => Auth::id()])->first();
        if ($check) {
            return redirect()->back()->with(['warning' => 'You have already applied ']);
        }
        try {
            $applyJob               = new AppliedJob();
            $applyJob->user_id      = Auth::id();
            $applyJob->job_id       =  Crypt::decrypt($request->id);
            $applyJob->cover_letter = $request->letter;
            if ($request->file('resume')) {
                $applyJob->resume = $this->uploadMedia($request->file('resume'), 'resumes');
            }
            $applyJob->save();
            return redirect()->back()->with(['success' => 'Job applied successfully']);
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with(['error' => 'Something went wrong']);
        }
    }

    #---- My jobs ---#
    public function myJobs(Request $request)
    {
        if (Gate::allows('company')) {
            $data = $this->getJobData();
            $data['jobs'] = Job::where('user_id', Auth::id())
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
                })->withCount('applied')->paginate(10);
            return view('front.pages.my-jobs', ['data' => $data]);
        }
        return redirect()->route('index');
    }

    #---- My applied jobs Employee ---#
    public function appliedJobs(Request $request)
    {
        if (Gate::allows('employee')) {
            $data = $this->getJobData();
            $data['jobs']  = AppliedJob::select('jobs.*')->where('applied_jobs.user_id', Auth::id())->join('jobs', 'applied_jobs.job_id', '=', 'jobs.id')
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
                })->paginate(10)->appends($request->query());
            return view('front.pages.applied-jobs', ['data' => $data]);
        }
        return redirect()->route('index');
    }
}
