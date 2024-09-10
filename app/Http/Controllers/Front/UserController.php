<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileCompleteRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\AppliedJob;
use App\Models\EmpResume;
use App\Models\EmpSkill;
use App\Models\JobIndustry;
use App\Models\Qualification;
use App\Models\User;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ImageTrait;
    #--- load blade file ----#
    public function profile(Request $request)
    {
        if (Gate::allows('profile_status')) {
            $data['job_industries'] = JobIndustry::all();
            $data['qualifications'] = Qualification::all();
            return view('front.auth.profile_complete', ['data' => $data]);
        }
        return redirect()->route('index');
    }

    public function settings(Request $request)
    {
        if (Gate::allowIf(['company', 'employee'])) {
            $user = User::with(['skills', 'country', 'state', 'city'])->find(Auth::id());
            $data['job_industries'] = JobIndustry::all();
            $data['qualifications'] = Qualification::all();
            return view('front.pages.setings', ['user' => $user, 'data' => $data]);
        }
        abort(404);
    }



    #---- Profile completed ----#
    public function completeProfile(ProfileCompleteRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::find(Auth::id());
            $user->phone                = $request->phone;
            $user->country_id           = $request->country;
            $user->state_id             = $request->state;
            $user->city_id              = $request->city;
            $user->profile              = $request->profile;
            $user->industry_id          = $request->industry;
            $user->qualifications       = json_encode($request->qualification);
            if ($request->password) {
                $user->password         = Hash::make($request->password);
            }
            if ($request->exp) {
                $user->exp              = formatExperience($request->exp);
            }
            if ($request->file('image')) {
                $image                  = $this->resizeImage($request->file('image'));
                $user->image            = $image;
            }
            $user->is_profile_completed = true;
            $user->save();

            if ($request->file('resume')) {
                $resume                 = $this->uploadMedia($request->file('resume'), 'resumes');
                $empResume              = new EmpResume();
                $empResume->file        = $resume;
                $empResume->user_id     = Auth::id();
                $empResume->save();
            }

            if ($request->skills) {
                foreach ($request->skills as $skill) {
                    $empSkill           = new EmpSkill();
                    $empSkill->user_id  = Auth::id();
                    $empSkill->name     = $skill;
                    $empSkill->save();
                }
            }
            DB::commit();
            return redirect()->route('index')->with(['success' => 'Profile completed']);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with(['error', 'Something went wrong']);
        }
    }

    #--- update Profile --#
    public function updateProfile(ProfileUpdateRequest $request)
    {
        try {
            $user = User::find(Auth::id());
            $user->phone                = $request->phone;
            $user->country_id           = $request->country;
            $user->state_id             = $request->state;
            $user->city_id              = $request->city;
            $user->last_name            = $request->last_name;
            $user->first_name           = $request->first_name;
            $user->user_name            = $request->user_name;
            if (Auth::user()->role == 'employee') {
                $user->profile          = $request->profile;
                $user->industry_id      = $request->industry;
                $user->qualifications   = json_encode($request->qualification);
                $user->exp              = formatExperience($request->exp);
            }
            if (Auth::user()->role == 'company') {
                $user->company_name     = $request->company_name;
                $user->company_type     = $request->company_type;
            }

            if ($request->file('image')) {
                $image                  = $this->resizeImage($request->file('image'));
                $user->image = $image;
            }
            $user->save();

            if ($request->file('resume')) {
                $resume                  = $this->uploadMedia($request->file('resume'), 'resumes');
                $empResume               = EmpResume::where('user_id', Auth::id())->first();
                if (empty($empResume)) {
                    $empResume           = new EmpResume();
                    $empResume->user_id  = Auth::id();
                }
                $empResume->file         = $resume;
                $empResume->save();
            }

            if ($request->skills) {
                foreach ($request->skills as $skill) {
                    if (!EmpSkill::where('name', $skill)->where('user_id', Auth::id())->exists()) {
                        $empSkill              = new EmpSkill();
                        $empSkill->user_id     = Auth::id();
                        $empSkill->name        = $skill;
                        $empSkill->save();
                    }
                }
            }
            return redirect()->back()->with(['success' => 'Profile Update']);
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with(['error', 'Something went wrong']);
        }
    }

    #--- Resume  Page ---#
    public function resume($userId, $jobId = '')
    {

        $userId = Crypt::decrypt($userId);
        if ($jobId) {
            $jobId                  = Crypt::decrypt($jobId);
            $resume                 = AppliedJob::select('*', 'resume as file')->where(['user_id' => $userId, 'job_id' => $jobId])->whereNotNull('resume')->first();
            if (empty($resume)) {
                $resume             =  EmpResume::where('user_id', $userId)->first();
            }
        } else {
            $resume                 =  EmpResume::where('user_id', $userId)->first();
        }

        return view('front.pages.resume', ['resume' => $resume]);
    }

    public function getDownload(Request $request)
    {
        if ($request->file) {
            $file            = $request->file;
            $headers         = array(
                'Content-Type: application/pdf',
            );
            if (Storage::exists($file)) {
                return Storage::download($file, 'resume.pdf', $headers);
            }
        }
    }
}
