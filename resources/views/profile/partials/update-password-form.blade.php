<section>
    <header class="mb-4">
        <h5 class="fw-semibold">
            {{ __('Update Password') }}
        </h5>

        <p class="text-muted small mb-0">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="mb-3">
            <label for="current_password" class="form-label">
                {{ __('Current Password') }}
            </label>
            <input
                id="current_password"
                name="current_password"
                type="password"
                class="form-control @error('current_password') is-invalid @enderror"
                autocomplete="current-password"
            >
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <label for="password" class="form-label">
                {{ __('New Password') }}
            </label>
            <input
                id="password"
                name="password"
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                autocomplete="new-password"
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">
                {{ __('Confirm Password') }}
            </label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-control"
                autocomplete="new-password"
            >
        </div>

        <!-- Actions -->
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-primary">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-success small">
                    {{ __('Saved.') }}
                </span>
            @endif
        </div>
    </form>
</section>
