<?php
$currentStatus = $statusFilter ?? 'All'; // Default to 'All' if no filter is set
$statuses = ['All', 'Applied', 'Interview', 'Offer', 'Rejected'];
$currentSearch = $searchTerm ?? ''; // Get current search term

$baseClasses = 'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors';
$activeClasses = 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100';
$inactiveClasses = 'bg-gray-100 text-gray-700 hover:bg-gray-200';
?>
<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <!-- Filters and Search -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-8">
                <div class="p-6">
                    <form method="GET" action="{{ route('job-applications.index') }}" id="filter-search-form">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <!-- Status Filters -->
                            <div class="flex flex-wrap gap-2">
                                @foreach ($statuses as $status)
                                    @php
                                        // Build the query parameters for the link
                                        $queryParams = [];
                                        if ($status != 'All') {
                                            $queryParams['status'] = $status;
                                        }
                                        if ($currentSearch) {
                                            $queryParams['search'] = $currentSearch;
                                        }
                                    @endphp
                                    <a href="{{ route('job-applications.index', $queryParams) }}"
                                       class="{{ $baseClasses }} {{ $currentStatus == $status ? $activeClasses : $inactiveClasses }}">
                                        {{ $status }}
                                    </a>
                                @endforeach
                            </div>

                            <!-- Search Box -->
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <!-- Hidden input to preserve status filter when searching -->
                                @if($currentStatus != 'All')
                                    <input type="hidden" name="status" value="{{ $currentStatus }}">
                                @endif
                                <input type="text" name="search" placeholder="Search applications..." value="{{ $currentSearch }}" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-full md:w-64 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <!-- Optional: Add a submit button if needed, or rely on Enter key -->
                                <!-- <button type="submit" class="absolute right-0 top-0 mt-2 mr-2 ...">Search</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Applications List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Your Job Applications</h3>

                    @if($jobApplications->isEmpty())
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-4 text-gray-500">No job applications yet. Start by adding your first application.</p>
                            <a href="{{ route('job-applications.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                                Get Started
                            </a>
                        </div>
                    @else
                        <!-- Desktop view: Table -->
                        <div class="hidden md:block">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company & Position</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Applied</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($jobApplications as $jobApplication)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="min-w-0">
                                                        <div class="text-sm font-medium text-gray-900">{{ $jobApplication->job_title }}</div>
                                                        <div class="text-sm text-gray-500">{{ $jobApplication->company_name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="
                                                    px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full
                                                    @if($jobApplication->status == 'Applied') bg-blue-100 text-blue-800
                                                    @elseif($jobApplication->status == 'Interview') bg-indigo-100 text-indigo-800
                                                    @elseif($jobApplication->status == 'Rejected') bg-red-100 text-red-800
                                                    @elseif($jobApplication->status == 'Offer') bg-green-100 text-green-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ $jobApplication->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $jobApplication->created_at ? $jobApplication->created_at->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $jobApplication->location ?? 'Not specified' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('job-applications.edit', $jobApplication) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                <form method="POST" action="{{ route('job-applications.destroy', $jobApplication) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this application?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile view: Cards -->
                        <div class="md:hidden space-y-4">
                            @foreach ($jobApplications as $jobApplication)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                    <div class="px-4 py-5 sm:p-6">
                                        <div class="flex justify-between">
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $jobApplication->job_title }}</h4>
                                                <p class="text-sm text-gray-600 mt-1">{{ $jobApplication->company_name }}</p>
                                            </div>
                                            <span class="
                                                px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full h-fit
                                                @if($jobApplication->status == 'Applied') bg-blue-100 text-blue-800
                                                @elseif($jobApplication->status == 'Interview') bg-indigo-100 text-indigo-800
                                                @elseif($jobApplication->status == 'Rejected') bg-red-100 text-red-800
                                                @elseif($jobApplication->status == 'Offer') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $jobApplication->status }}
                                            </span>
                                        </div>
                                        
                                        <div class="mt-4 grid grid-cols-2 text-sm">
                                            <div>
                                                <p class="text-gray-500">Date Applied:</p>
                                                <p class="font-medium">{{ $jobApplication->created_at ? $jobApplication->created_at->format('M d, Y') : 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Location:</p>
                                                <p class="font-medium">{{ $jobApplication->location ?? 'Not specified' }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-5 flex justify-end space-x-3">
                                            <a href="{{ route('job-applications.edit', $jobApplication) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('job-applications.destroy', $jobApplication) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100" onclick="return confirm('Are you sure you want to delete this application?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
