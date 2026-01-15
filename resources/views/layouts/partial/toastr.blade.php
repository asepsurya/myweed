@if (session('success') || session('error') || session('warning'))
<div class="toast-container position-fixed top-0 end-0 p-3">

    @php
        $type = session('success') ? 'success' : (session('error') ? 'error' : 'warning');
        $message = session($type);

        $borderClass = match($type) {
            'success' => 'border-success',
            'error'   => 'border-danger',
            'warning' => 'border-warning',
        };


        $icon = match($type) {
            'success' => 'bi-check-circle-fill text-success',
            'error'   => 'bi-x-circle-fill text-danger',
            'warning' => 'bi-exclamation-triangle-fill text-warning',
        };


    @endphp

    <div class="toast border-0 {{ $borderClass }}"
         role="alert"
         aria-live="assertive"
         aria-atomic="true"
         data-bs-delay="2500">

        <div class="toast-header">
            <img src="{{ asset('tempelate/logo_apps.png') }}" class="rounded me-2" width="20">
            <strong class="me-auto">Weeding Creative</strong>
            <small>now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>

        <div class="toast-body d-flex align-items-center gap-2">
            <i class="bi {{ $icon }}"></i>
            <span>{{ $message }}</span>
        </div>

    </div>

</div>
@endif
