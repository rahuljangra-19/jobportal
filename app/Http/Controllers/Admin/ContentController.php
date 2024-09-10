<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\JobController;
use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobIndustry;
use App\Models\JobRole;
use App\Models\JobType;
use App\Models\Qualification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    #--- creat or update --#
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('job_categories', 'name')->ignore($request->id),
            ],

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->messages()->get('name')[0]]);
        }
        try {
            if ($request->id) {
                $category =  JobCategory::find($request->id);
                if ($request->status) {
                    $category->status = $request->status;
                }
                $msg = 'Job Category updated';
            } else {
                $category = new JobCategory();
                $msg = 'Job Category created';
            }
            $category->name = $request->name;
            $category->save();
            return response()->json(['status' => 200, 'message' => $msg]);
        } catch (Exception $e) {
            return response()->json(['status' => 400, 'message' => 'something went wrong']);
        }
    }
    #---- Get data ----#
    public function getCategory(Request $request)
    {

        $data = JobCategory::find($request->id);
        return response()->json(['status' => 200, 'data' => $data]);
    }

    #----- Delete category ----#
    public function deleteCategory($id)
    {
        $category = JobCategory::find($id);
        $category->status = 2;
        $category->save();
        return redirect()->back()->with('success', 'Job Category deleted');
    }

    #--- creat or update --#
    public function createRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('job_roles', 'name')->ignore($request->id),
            ],

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->messages()->get('name')[0]]);
        }
        try {
            if ($request->id) {
                $role =  JobRole::find($request->id);
                if ($request->status) {
                    $role->status = $request->status;
                }
                $msg = 'Job Role updated';
            } else {
                $role = new JobRole();
                $msg = 'Job Role created';
            }
            $role->name = $request->name;
            $role->save();
            return response()->json(['status' => 200, 'message' => $msg]);
        } catch (Exception $e) {
            return response()->json(['status' => 400, 'message' => 'something went wrong']);
        }
    }
    #---- Get data ----#
    public function getRole(Request $request)
    {
        $data = JobRole::find($request->id);
        return response()->json(['status' => 200, 'data' => $data]);
    }

    #----- Delete Roles ----#
    public function deleteRole($id)
    {
        $role = JobRole::find($id);
        $role->status = 2;
        $role->save();
        return redirect()->back()->with('success', 'Job Role deleted');
    }

    #--- creat or update --#
    public function createType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('job_types', 'name')->ignore($request->id),
            ],

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->messages()->get('name')[0]]);
        }
        try {
            if ($request->id) {
                $type =  JobType::find($request->id);
                if ($request->status) {
                    $type->status = $request->status;
                }
                $msg = 'Job type updated';
            } else {
                $type = new JobType();
                $msg = 'Job type created';
            }
            $type->name = $request->name;
            $type->save();
            return response()->json(['status' => 200, 'message' => $msg]);
        } catch (Exception $e) {
            return response()->json(['status' => 400, 'message' => 'something went wrong']);
        }
    }
    #---- Get data ----#
    public function getType(Request $request)
    {
        $data = JobType::find($request->id);
        return response()->json(['status' => 200, 'data' => $data]);
    }

    #----- Delete Types ----#
    public function deleteType($id)
    {
        $role = JobType::find($id);
        $role->status = 2;
        $role->save();
        return redirect()->back()->with('success', 'Job type deleted');
    }


    #--- creat or update --#
    public function createIndustry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('job_industries', 'name')->ignore($request->id),
            ],

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->messages()->get('name')[0]]);
        }
        try {
            if ($request->id) {
                $industry =  JobIndustry::find($request->id);
                if ($request->status) {
                    $industry->status = $request->status;
                }
                $msg = 'Job Industry updated';
            } else {
                $industry = new JobIndustry();
                $msg = 'Job Industry created';
            }
            $industry->name = $request->name;
            $industry->save();
            return response()->json(['status' => 200, 'message' => $msg]);
        } catch (Exception $e) {
            return response()->json(['status' => 400, 'message' => 'something went wrong']);
        }
    }
    #---- Get data ----#
    public function getIndustry(Request $request)
    {
        $data = JobIndustry::find($request->id);
        return response()->json(['status' => 200, 'data' => $data]);
    }

    #----- Delete industry ----#
    public function deleteIndustry($id)
    {
        $industry = JobIndustry::find($id);
        $industry->status = 2;
        $industry->save();
        return redirect()->back()->with('success', 'Job Industry deleted');
    }


    #--- create company ---#
    public function createCompany(Request $request)
    {
        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'company_name' => ['required'],
            'user_name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($request->id)],
            'password' => ['min:6',  $request->id ? 'nullable' : 'required'],
            'status' => [$request->id ? 'required' : 'nullable'],
            'company_type' => ['required'],
        ]);

        try {
            if ($request->id) {
                $company            = User::find($request->id);
                $company->status    = $request->status;
                $msg                = 'company  updated successful';
            } else {
                $company            = new User();
                $msg                = 'company created successful';
            }
            $company->role          = 'company';
            $company->token         = Str::random(15);
            $company->first_name    = $request->first_name;
            $company->last_name     = $request->last_name;
            $company->user_name     = $request->user_name;
            if (!empty($request->email)) {
                $company->email     = $request->email;
            }
            if ($request->password) {
                $company->password  = Hash::make($request->password);
            }
            $company->company_name  = $request->company_name;
            $company->company_type  = $request->company_type;
            $company->save();

            return redirect()->back()->with('success', $msg);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'something went wrong');
            dd($e);
        }
    }

    #--- edit company ---#
    public function editCompany($id)
    {
        if ($id) {
            $data['title'] = 'Update company';
            $data['company'] = User::where('role', 'company')->find($id);
            return view('admin.pages.create-company', ['data' => $data]);
        }
    }
    #--- load blade create  company ---#
    public function Company(Request $request)
    {
        $data['title'] = 'Create company';
        return view('admin.pages.create-company', ['data' => $data]);
    }
    #--- delete company ---#
    public function deleteCompany($id)
    {
        if ($id) {
            $company = User::where('role', 'company')->find($id);
            if ($company) {
                $company->status = 'deleted';
                $company->save();
                return redirect()->back()->with('success', 'company deleted successful');
            }
        }
        return redirect()->back()->with('error', 'something went wrong');
    }


    #-- create or update employee --#
    public function createEmployee(Request $request)
    {
        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'user_name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($request->id)],
            'password' => ['min:6',  $request->id ? 'nullable' : 'required'],
            'status' => [$request->id ? 'required' : 'nullable'],
        ]);

        try {
            if ($request->id) {
                $employee = User::find($request->id);
                $employee->status = $request->status;
                $msg = 'employee updated successful';
            } else {
                $employee = new User();
                $msg = 'employee created successful';
            }
            $employee->role          = 'employee';
            $employee->token         = Str::random(15);
            $employee->first_name    = $request->first_name;
            $employee->last_name     = $request->last_name;
            $employee->user_name     = $request->user_name;
            if (!empty($request->email)) {
                $employee->email     = $request->email;
            }
            if ($request->password) {
                $employee->password = Hash::make($request->password);
            }
            $employee->save();
            return redirect()->back()->with('success', $msg);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'something went wrong');
            dd($e);
        }
    }

    #-- blade file employee --#
    public function employee(Request $request)
    {
        $data['title'] = 'Create employee';
        return view('admin.pages.create-employee', ['data' => $data]);
    }
    #-- edit employee --#
    public function editEmployee($id)
    {
        $data['title'] = 'Update employee';
        $data['employee'] = User::where('role', 'employee')->find($id);
        return view('admin.pages.create-employee', ['data' => $data]);
    }
    #-- deleted employee --#
    public function deleteEmployee($id)
    {
        if ($id) {
            $employee = User::where('role', 'employee')->find($id);
            if ($employee) {
                $employee->status = 'deleted';
                $employee->save();
                return redirect()->back()->with('success', 'employee deleted successful');
            }
        }
        return redirect()->back()->with('error', 'something went wrong');
    }


    #---- update job ---#
    public function updateJob(JobRequest $request, $jobId)
    {
        try {
            $job                     = Job::find($jobId);
            $job->title              = $request->job_title;
            $job->job_role           = $request->job_role;
            $job->job_industry       = $request->job_industry;
            $job->job_category       = $request->job_category;
            $job->vacancies          = $request->vacancies;
            $job->experience         = $request->experience;
            $job->deadline           = $request->deadline;
            $job->description        = $request->job_desc;
            $job->salary_type        = $request->salary_type;
            if ($request->location == 'other_location') {
                $location            = $this->getCity($request->city) . ',' . $this->getState($request->state) . ',' . $this->getCountry($request->country);
                $job->location       = $location;
            }
            if ($request->salary_type === 'range') {
                $job->salary         = $request->min_salary;
                $job->max_salary     = $request->max_salary;
            }
            if ($request->salary_type === 'fixed') {
                $job->salary         = $request->fixed_salary;
                $job->max_salary     = $request->fixed_salary;
            }
            $job->status = $request->status ?? 1;
            $job->job_type           = json_encode($request->job_type);
            $job->qualification      = json_encode($request->qualification);
            $job->save();

            return redirect()->back()->with('success', 'Job updated successfully');
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('warning', 'Something went wrong');
        }
    }
    #---- update job ---#
    public function editJob($id)
    {
        if ($id) {
            $job                     =  new JobController();
            $data                    =  $job->getJobData();
            $data['title']           = 'Update Job';
            $data['job']             = Job::find($id);
            $data['qualifications']  = Qualification::where('status', true)->get();

            return view('admin.pages.edit-job', ['data' => $data]);
        }
    }
    #---- delete job ---#
    public function deleteJob($id)
    {
        if ($id) {
            $job = Job::find($id);
            if ($job) {
                $job->status = 2;
                $job->save();
                return redirect()->back()->with('success', 'Job deleted successful');
            }
        }
        return redirect()->back()->with('error', 'something went wrong');
    }
}
