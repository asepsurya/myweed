<x-app-layout>
    @push('styles')
        <style>
            .log-viewer-container {
                height: calc(100vh - 180px);
                min-height: 500px;
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid var(--bs-border-color);
                background: var(--adminuiux-bg-2);
            }
            .log-viewer-container iframe {
                width: 100%;
                height: 100%;
                border: none;
            }
        </style>
    @endpush

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-semibold">
                <i class="bi bi-journal-text me-2 text-primary"></i>Log Viewer
            </h4>
            <p class="text-muted small mb-0">Monitor application logs and errors</p>
        </div>
        <a href="{{ route('logs.index') }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
            <i class="bi bi-box-arrow-up-right me-1"></i>Open in New Tab
        </a>
    </div>

    <div class="log-viewer-container">
        <iframe src="{{ route('logs.index') }}" title="Laravel Log Viewer"></iframe>
    </div>
</x-app-layout>
