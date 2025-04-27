<x-app-layout>
    {{-- <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                {{ __('My Applications') }}
            </h2>
            <a href="{{ route('job-applications.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Add Application
            </a>
        </div>
    </x-slot> --}}

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <p class="text-sm font-medium text-gray-500">Total Applications</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $jobApplications->count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <p class="text-sm font-medium text-gray-500">Applied This Week</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">
                        {{ $jobApplications->where('created_at', '>=', now()->subWeek())->count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <p class="text-sm font-medium text-gray-500">Interviews</p>
                    <p class="text-2xl font-bold text-indigo-600 mt-1">
                        {{ $jobApplications->where('status', 'Interviewing')->count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <p class="text-sm font-medium text-gray-500">Offers</p>
                    <p class="text-2xl font-bold text-purple-600 mt-1">
                        {{ $jobApplications->where('status', 'Offer')->count() }}</p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Application Status Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <h3 class="font-semibold text-lg text-gray-800 leading-tight mb-4">Application Status</h3>
                    <div class="h-64">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <!-- Applications Over Time Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <h3 class="font-semibold text-lg text-gray-800 leading-tight mb-4">Applications Over Time</h3>
                    <div class="h-64">
                        <canvas id="timelineChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Applications Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-6">Recent Applications</h3>

                @if($jobApplications->isEmpty())
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-4 text-gray-500">No job applications yet. Start by adding your first application.</p>
                        <a href="{{ route('job-applications.create') }}"
                            class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                            Get Started
                        </a>
                    </div>
                @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($jobApplications as $jobApplication)
                                                <div class="group">
                                                    <a href="{{ route('job-applications.edit', $jobApplication) }}"
                                                        class="block bg-white overflow-hidden border border-gray-200 rounded-xl hover:shadow-md transition duration-300 h-full">
                                                        <div class="p-5">
                                                            <!-- Card Header - Company and Job Title -->
                                                            <div class="flex justify-between items-start">
                                                                <div>
                                                                    <h4 class="font-bold text-lg text-gray-900 line-clamp-1">
                                                                        {{ $jobApplication->job_title }}</h4>
                                                                    <p class="text-gray-700 mt-1 flex items-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500"
                                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                                        </svg>
                                                                        {{ $jobApplication->company_name }}
                                                                    </p>
                                                                </div>
                                                                <span class="
                                                                            @if($jobApplication->status == 'Applied') bg-blue-100 text-blue-800
                                                                            @elseif($jobApplication->status == 'Interview') bg-indigo-100 text-indigo-800
                                                                            @elseif($jobApplication->status == 'Rejected') bg-red-100 text-red-800
                                                                            @elseif($jobApplication->status == 'Offer') bg-green-100 text-green-800
                                                                            @else bg-gray-100 text-gray-800 @endif
                                                                            px-3 py-1 rounded-full text-xs font-medium">
                                                                    {{ $jobApplication->status }}
                                                                </span>
                                                            </div>

                                                            <!-- Application Details -->
                                                            <div class="grid grid-cols-2 gap-4 mt-4">
                                                                <div class="flex items-center text-sm text-gray-500">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                    </svg>
                                                                    <span>{{ $jobApplication->created_at->format('M d, Y') }}</span>
                                                                </div>

                                                                @if($jobApplication->location)
                                                                    <div class="flex items-center text-sm text-gray-500">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        </svg>
                                                                        <span class="truncate">{{ $jobApplication->location }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <!-- Simplified Progress Tracker -->
                                                            <div class="mt-5 pt-4 border-t border-gray-100">
                                                                <div class="flex justify-between text-xs text-gray-500 mb-2">
                                                                    <span>Application Progress</span>
                                                                    
                                                                    @php
                                                                        // Define the stages and their order
                                                                        $stages = ['Applied', 'Interviewing', 'Offer', 'Accepted'];
                                                                        $currentStage = $jobApplication->status;
                                                                        
                                                                        if ($currentStage == 'Rejected') {
                                                                            $progressText = 'Rejected';
                                                                            $progressColor = 'bg-red-500';
                                                                            $progress = 100; // Show full red bar for rejected
                                                                        } else {
                                                                            // Find current stage index
                                                                            $stageIndex = array_search($currentStage, $stages);
                                                                            // Make sure $stageIndex is not false and is converted to integer
                                                                            $stageIndex = $stageIndex !== false ? (int)$stageIndex : 0;
                                                                            
                                                                            // Calculate progress - make sure we're using proper math
                                                                            $progress = ($stageIndex / (count($stages) - 1)) * 100;
                                                                            
                                                                            // Ensure progress is a number
                                                                            $progress = is_numeric($progress) ? $progress : 0;
                                                                            
                                                                            // Determine color
                                                                            if ($currentStage == 'Applied') $progressColor = 'bg-blue-500';
                                                                            elseif ($currentStage == 'Interview') $progressColor = 'bg-indigo-500';
                                                                            elseif ($currentStage == 'Offer') $progressColor = 'bg-purple-500';
                                                                            elseif ($currentStage == 'Accepted') $progressColor = 'bg-green-500';
                                                                            else $progressColor = 'bg-gray-500';
                                                                        }
                                                                        
                                                                        // Debug info - add this temporarily to see what's happening
                                                                        // echo "<!-- Stage: $currentStage, Index: $stageIndex, Progress: $progress -->";
                                                                    @endphp
                                                                    
                                                                    <span>{{ $currentStage }}</span>
                                                                </div>
                                                                
                                                                <!-- Progress Bar - Adding !important to override any conflicting styles -->
                                                                <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden relative">
                                                                    <div class="{{ $progressColor }} h-1.5 absolute left-0 top-0" style="width: {{ $progress }}% !important;"></div>
                                                                </div>
                                                                
                                                                <!-- Stage Markers - Simpler Version -->
                                                                <div class="flex justify-between mt-1">
                                                                    @foreach($stages as $index => $stage)
                                                                        <div class="text-[0.65rem] @if(array_search($currentStage, $stages) >= $index && $currentStage != 'Rejected') font-bold @endif
                                                                            @if($currentStage == 'Rejected') text-gray-400 @else text-gray-500 @endif">
                                                                            ●
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                            <!-- View Details Button -->
                                                            <div class="mt-4 flex justify-end">
                                                                <span
                                                                    class="text-indigo-600 text-sm font-medium group-hover:text-indigo-800 transition-colors duration-200 flex items-center">
                                                                    View details
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20"
                                                                        fill="currentColor">
                                                                        <path fill-rule="evenodd"
                                                                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                @endforeach
                            </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Status Chart
                    const statusCtx = document.getElementById('statusChart').getContext('2d');
                    const statusData = {
                        labels: ['Applied', 'Interview', 'Rejected', 'Offer'],
                        datasets: [{
                            label: 'Number of Applications',
                            data: [
                                {{ $jobApplications->where('status', 'Applied')->count() }},
                                {{ $jobApplications->where('status', 'Interviewing')->count() }},
                                {{ $jobApplications->where('status', 'Rejected')->count() }},
                                {{ $jobApplications->where('status', 'Offer')->count() }}
                            ],
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.7)', // blue
                                'rgba(79, 70, 229, 0.7)',  // indigo
                                'rgba(239, 68, 68, 0.7)',  // red
                                'rgba(16, 185, 129, 0.7)'  // green
                            ],
                            borderColor: [
                                'rgb(59, 130, 246)',
                                'rgb(79, 70, 229)',
                                'rgb(239, 68, 68)',
                                'rgb(16, 185, 129)'
                            ],
                            borderWidth: 1
                        }]
                    };

                    new Chart(statusCtx, {
                        type: 'bar',
                        data: statusData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });

                    // Timeline Chart - Last 7 days
                    const timelineCtx = document.getElementById('timelineChart').getContext('2d');
                    const dates = [];
                    const counts = [
                        @php
                            // Pre-calculate the counts for the last 7 days in PHP
                            for ($i = 6; $i >= 0; $i--) {
                                $date = now()->subDays($i)->format('Y-m-d');
                                $count = $jobApplications->filter(function ($application) use ($date) {
                                    return $application->created_at->format('Y-m-d') === $date;
                                })->count();

                                echo $count;
                                if ($i > 0)
                                    echo ', ';
                            }
                        @endphp
        ];

                    // Create an array of the last 7 days
                    for (let i = 6; i >= 0; i--) {
                        const date = new Date();
                        date.setDate(date.getDate() - i);
                        const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                        dates.push(formattedDate);
        }

                    new Chart(timelineCtx, {
                        type: 'line',
                        data: {
                            labels: dates,
                            datasets: [{
                                label: 'Applications',
                                data: counts,
                                borderColor: 'rgb(99, 102, 241)',
                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
    @endpush
</x-app-layout>
