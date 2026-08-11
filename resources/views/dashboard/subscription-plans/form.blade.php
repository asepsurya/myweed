<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark m-0">
                <i class="bi bi-tags me-2"></i>
                {{ isset($subscriptionPlan) ? 'Edit Paket' : 'Tambah Paket' }}
            </h2>
            <a href="{{ route('subscribe.page') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="container mt-4" style="max-width: 700px;">
        <div class="card">
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ isset($subscriptionPlan) ? route('subscription-plans.update', $subscriptionPlan) : route('subscription-plans.store') }}" method="POST">
                    @csrf
                    @if(isset($subscriptionPlan))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Paket</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $subscriptionPlan->name ?? '') }}" required placeholder="Contoh: Pro Wedding">
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label fw-semibold">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $subscriptionPlan->slug ?? '') }}" required placeholder="Contoh: pro-wedding">
                        <div class="form-text">Huruf kecil, tanpa spasi, dan unik.</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label fw-semibold">Harga (Rp)</label>
                                <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $subscriptionPlan->price ?? 0) }}" min="0" required>
                                <div class="form-text">Hanya angka, tanpa titik atau koma.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration" class="form-label fw-semibold">Durasi (Hari)</label>
                                <input type="number" name="duration" id="duration" class="form-control" value="{{ old('duration', $subscriptionPlan->duration ?? 30) }}" min="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Fitur / Keunggulan</label>
                        <textarea name="description" id="description" rows="6" class="form-control" placeholder="Satu fitur per baris">{{ old('description', isset($subscriptionPlan) ? implode("\n", json_decode($subscriptionPlan->description ?? '[]')) : '') }}</textarea>
                        <div class="form-text">Setiap baris akan menjadi satu poin keunggulan.</div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_free" id="is_free" value="1" {{ old('is_free', isset($subscriptionPlan) && $subscriptionPlan->is_free ? 'checked' : '') ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_free">
                                Paket Gratis
                            </label>
                            <div class="form-text">Jika dicentang, harga otomatis menjadi Rp 0 dan pengguna bisa mengaktifkan tanpa pembayaran.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('subscribe.page') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> {{ isset($subscriptionPlan) ? 'Simpan Perubahan' : 'Tambah Paket' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
