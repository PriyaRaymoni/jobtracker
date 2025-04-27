<x-app-layout>
    <div class="py-6 sm:py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Edit Job Application</h1>
                
                <a href="{{ route('job-applications.index') }}" class="flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Applications
                </a>
            </div>
            
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border border-gray-200">
                <!-- Application Status Banner -->
                @php
                    $statusColors = [
                        'Applied' => 'bg-blue-500',
                        'Interviewing' => 'bg-indigo-500',
                        'Interview' => 'bg-indigo-500',
                        'Offer' => 'bg-purple-500',
                        'Accepted' => 'bg-green-500',
                        'Rejected' => 'bg-red-500'
                    ];
                    $bannerColor = $statusColors[$jobApplication->status] ?? 'bg-gray-500';
                @endphp
                
                <div class="{{ $bannerColor }} px-6 py-3 flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-white bg-opacity-25 mr-3">
                            @if($jobApplication->status == 'Applied')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @elseif($jobApplication->status == 'Interviewing' || $jobApplication->status == 'Interview')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            @elseif($jobApplication->status == 'Offer')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @elseif($jobApplication->status == 'Accepted')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @elseif($jobApplication->status == 'Rejected')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @endif
                        </span>
                        <h2 class="text-white font-semibold">Status: {{ $jobApplication->status }}</h2>
                    </div>
                    
                    <div class="text-sm text-white opacity-80">
                        <span>Applied {{ $jobApplication->application_date ? $jobApplication->application_date->diffForHumans() : 'N/A' }}</span>
                    </div>
                </div>
                
                <!-- Main Form -->
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('job-applications.update', $jobApplication) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Job Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div class="col-span-1">
                                    <label for="job_title" class="block text-sm font-medium text-gray-700 mb-1">Job Title <span class="text-red-500">*</span></label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="job_title" id="job_title" class="pl-10 py-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $jobApplication->job_title }}" required>
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name <span class="text-red-500">*</span></label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <input type="text" name="company_name" id="company_name" class="pl-10 py-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $jobApplication->company_name }}" required>
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="location" id="location" class="pl-10 py-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $jobApplication->location ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <label for="job_type" class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <select name="job_type" id="job_type" class="block py-4 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="Full-time" {{ $jobApplication->job_type == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                            <option value="Part-time" {{ $jobApplication->job_type == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                            <option value="Contract" {{ $jobApplication->job_type == 'Contract' ? 'selected' : '' }}>Contract</option>
                                            <option value="Internship" {{ $jobApplication->job_type == 'Internship' ? 'selected' : '' }}>Internship</option>
                                            <option value="Freelance" {{ $jobApplication->job_type == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Application Status Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Application Status</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div class="col-span-1">
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Current Status <span class="text-red-500">*</span></label>
                                    <div class="relative rounded-md shadow-sm">
                                        <select name="status" id="status" class="block py-4 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                            <option value="Applied" {{ $jobApplication->status == 'Applied' ? 'selected' : '' }}>Applied</option>
                                            <option value="Interview" {{ ($jobApplication->status == 'Interview' || $jobApplication->status == 'Interviewing') ? 'selected' : '' }}>Interview</option>
                                            <option value="Offer" {{ $jobApplication->status == 'Offer' ? 'selected' : '' }}>Offer</option>
                                            <option value="Accepted" {{ $jobApplication->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                                            <option value="Rejected" {{ $jobApplication->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <label for="application_date" class="block text-sm font-medium text-gray-700 mb-1">Application Date <span class="text-red-500">*</span></label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="date" name="application_date" id="application_date" class="pl-10 py-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $jobApplication->application_date ? $jobApplication->application_date->format('Y-m-d') : '' }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-span-1">
                                    <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Salary/Compensation</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="text" name="salary" id="salary" class="pl-7 py-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $jobApplication->salary ?? '' }}" placeholder="75,000">
                                    </div>
                                </div>
                                
                                <div class="col-span-1">
                                    <label for="reminder_date" class="block text-sm font-medium text-gray-700 mb-1">Reminder Date</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <input type="date" name="reminder_date" id="reminder_date" class="pl-10 py-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $jobApplication->reminder_date ? $jobApplication->reminder_date->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                            
                            <div class="grid grid-cols-1 gap-y-5">
                                <div>
                                    <label for="job_link" class="block text-sm font-medium text-gray-700 mb-1">Job Posting URL</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                        </div>
                                        <input type="url" name="job_link" id="job_link" class="pl-10 py-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $jobApplication->job_link ?? '' }}">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                    <div class="mt-1">
                                        <textarea name="notes" id="notes" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $jobApplication->notes }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-4">
                            <form method="POST" action="{{ route('job-applications.destroy', $jobApplication) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="if(confirm('Are you sure you want to delete this job application?')) this.form.submit();" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                            
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('job-applications.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
