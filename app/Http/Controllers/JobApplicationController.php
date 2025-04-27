<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $jobApplications = JobApplication::where('user_id', Auth::id())->get();
        $totalApplications = $jobApplications->count();
        $appliedCount = $jobApplications->where('status', 'Applied')->count();
        $interviewingCount = $jobApplications->where('status', 'Interviewing')->count();
        $offerCount = $jobApplications->where('status', 'Offer')->count();
        $rejectedCount = $jobApplications->where('status', 'Rejected')->count();

        return view('dashboard', compact('jobApplications', 'totalApplications', 'appliedCount', 'interviewingCount', 'offerCount', 'rejectedCount'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobApplications = JobApplication::where('user_id', Auth::id())->get();
        return view('job-applications.index', compact('jobApplications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job-applications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'job_title' => 'required',
            'company_name' => 'required',
            'location' => 'nullable',
            'job_link' => 'nullable|url',
            'salary' => 'nullable|numeric',
            'job_type' => 'nullable',
            'status' => 'required',
            'application_date' => 'nullable|date',
            'notes' => 'nullable',
            'reminder_date' => 'nullable|date',
        ]);

        $validatedData['user_id'] = Auth::id();

        JobApplication::create($validatedData);

        return redirect()->route('job-applications.index')->with('success', 'Job application created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobApplication $jobApplication)
    {
        // Not needed for this project
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobApplication $jobApplication)
    {
        return view('job-applications.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobApplication $jobApplication)
    {
        $validatedData = $request->validate([
            'job_title' => 'required',
            'company_name' => 'required',
            'status' => 'required',
            'application_date' => 'nullable|date',
            'notes' => 'nullable',
            'reminder_date' => 'nullable|date',
            'location' => 'nullable',
            'job_link' => 'nullable|url',
            'salary' => 'nullable|numeric',
            'job_type' => 'nullable',

        ]);

        $jobApplication->update($validatedData);

        return redirect()->route('job-applications.index')->with('success', 'Job application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $jobApplication)
    {
        $jobApplication->delete();

        return redirect()->route('job-applications.index')->with('success', 'Job application deleted successfully.');
    }
}
