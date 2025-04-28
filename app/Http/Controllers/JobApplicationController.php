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
        $interviewingCount = $jobApplications->where('status', 'Interview')->count();
        $offerCount = $jobApplications->where('status', 'Offer')->count();
        $rejectedCount = $jobApplications->where('status', 'Rejected')->count();

        return view('dashboard', compact('jobApplications', 'totalApplications', 'appliedCount', 'interviewingCount', 'offerCount', 'rejectedCount'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statusFilter = $request->query('status');
        $searchTerm = $request->query('search'); // Get search term

        $query = JobApplication::where('user_id', Auth::id());

        // Apply status filter
        if ($statusFilter && $statusFilter !== 'All') {
            if ($statusFilter === 'Interview') {
                $query->whereIn('status', ['Interview', 'Interviewing']);
            } else {
                $query->where('status', $statusFilter);
            }
        }

        // Apply search filter
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('job_title', 'like', "%{$searchTerm}%")
                  ->orWhere('company_name', 'like', "%{$searchTerm}%")
                  ->orWhere('location', 'like', "%{$searchTerm}%");
            });
        }

        $jobApplications = $query->orderBy('created_at', 'desc')->get();

        // Pass both filters to the view
        return view('job-applications.index', compact('jobApplications', 'statusFilter', 'searchTerm'));
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
