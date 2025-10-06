<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Calendar Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Kalender Aktivitas Pegawai</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Jadwal dan status aktivitas pegawai
                </p>
            </div>
            
            <!-- Calendar Container with proper wire:ignore -->
            <div wire:ignore.self class="calendar-wrapper">
                <div id="calendar" 
                     data-events='@json($events)' 
                     class="fc-calendar-container"
                     style="min-height: 600px;">
                    <!-- Loading state -->
                    <div class="flex items-center justify-center h-96" id="calendar-loading">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
                        <span class="ml-3 text-gray-600">Memuat kalender...</span>
                    </div>
                </div>
            </div>
            
            <!-- Empty state -->
            @if(count($events) === 0)
                <div class="text-center py-8 text-gray-500">
                    <div class="text-4xl mb-4">📅</div>
                    <p>Tidak ada aktivitas yang dijadwalkan</p>
                </div>
            @endif
        </div>
        
        <!-- Legend -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Keterangan Status:</h3>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center">
                    <div class="w-4 h-4 rounded bg-yellow-400 mr-2"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Pending</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 rounded bg-green-500 mr-2"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Disetujui</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 rounded bg-red-500 mr-2"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Ditolak</span>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* FullCalendar Custom Styles */
            .fc-calendar-container {
                background: white;
                border-radius: 8px;
                border: 1px solid #e5e7eb;
            }
            
            .fc .fc-toolbar-title {
                font-size: 1.5rem;
                font-weight: 600;
                color: #1f2937;
            }
            
            .fc .fc-button-primary {
                background-color: #3b82f6;
                border-color: #3b82f6;
            }
            
            .fc .fc-button-primary:hover {
                background-color: #2563eb;
                border-color: #2563eb;
            }
            
            .fc .fc-daygrid-event {
                font-size: 0.875rem;
                border-radius: 4px;
                margin: 1px;
                padding: 2px 4px;
            }
            
            .fc .fc-daygrid-day-number {
                color: #374151;
                font-weight: 500;
            }
            
            .fc .fc-col-header-cell {
                background-color: #f9fafb;
                font-weight: 600;
                color: #374151;
            }
            
            #calendar-loading {
                display: flex;
            }
            
            .fc-calendar-container.loaded #calendar-loading {
                display: none;
            }
        </style>
    @endpush

    @push('scripts')
        @vite('resources/js/calendar.js')
        <script>
            // Additional initialization if needed
            document.addEventListener('livewire:navigated', function() {
                console.log('Livewire navigated - reinitializing calendar if needed');
                // Calendar will auto-initialize via calendar.js
            });
        </script>
    @endpush
</x-filament-panels::page>
