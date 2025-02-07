@extends('layout')

@section('content')
    <div class="px-4">
        <h1 class="text-2xl font-bold mt-4">Device Log Report</h1>
        <div
            class="w-full h-[80vh] bg-gray-50 shadow text-sm text-gray-500 font-mono p-4 rounded-lg shadow-md overflow-y-auto mt-2">
            <div id="logContainer" class="space-y-2">
                @forelse($logs as $log)
                    <p>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i:s') }} - {{ $log->log_message }}</p>
                @empty
                    <p class="text-gray-500">No logs available.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
