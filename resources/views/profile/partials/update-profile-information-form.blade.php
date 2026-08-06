<section>
    <header class="mb-4">
        <h5 class="fw-semibold">
            {{ __('Profile Information') }}
        </h5>

        <p class="text-muted small mb-0">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Resend verification -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Update profile -->
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input
                id="name"
                name="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input
                id="email"
                name="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username" readonly
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning mt-3 mb-0">
                    <small>
                        {{ __('Your email address is unverified.') }}
                        <button
                            form="send-verification"
                            class="btn btn-link p-0 align-baseline"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </small>

                    @if (session('status') === 'verification-link-sent')
                        <div class="text-success small mt-2">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-primary">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-success small">
                    {{ __('Saved.') }}
                </span>
            @endif
        </div>
    </form>
</section>

