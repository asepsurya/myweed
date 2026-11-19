<x-app-layout>
<style>
    .fields-builder .field-row {
        border: 1px solid var(--bs-border-color);
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background: var(--bs-tertiary-bg);
    }
    .field-type-badge {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Tambah Kategori Undangan</h1>
            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card mb-4">
            <div class="card-header fw-semibold">
                <i class="bi bi-tag me-2"></i> Informasi Kategori
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Wedding Invitation">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required placeholder="Contoh: wedding">
                        <div class="form-text">Digunakan untuk URL dan identifikasi kategori.</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Ikon <span class="text-muted small">(Bootstrap Icons)</span></label>
                        <input type="text" name="icon" class="form-control" value="{{ old('icon', 'bi-folder') }}" placeholder="bi-heart">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Urutan</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat kategori ini">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktif (tersedia untuk pengguna)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
                <i class="bi bi-sliders me-2"></i> Field Dinamis
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addFieldRow()">
                    <i class="bi bi-plus me-1"></i> Tambah Field
                </button>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">Konfigurasi field formulir yang akan ditampilkan saat pengguna membuat undangan dengan kategori ini.</p>
                <div id="fieldsBuilder" class="fields-builder">
                    @php $defaultFields = old('dynamic_fields', []); @endphp
                    @foreach($defaultFields as $index => $field)
                        @include('dashboard.categories.partials.field-row', ['field' => $field, 'index' => $index])
                    @endforeach
                </div>
                <input type="hidden" name="dynamic_fields" id="dynamicFieldsInput" value='{{ json_encode(old('dynamic_fields', [])) }}'>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-builder-next">
                <i class="bi bi-save me-1"></i> Simpan Kategori
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let fieldCount = {{ json_encode(count(old('dynamic_fields', []))) }};

    function addFieldRow() {
        const index = fieldCount++;
        const container = document.getElementById('fieldsBuilder');
        const row = document.createElement('div');
        row.className = 'field-row';
        row.innerHTML = `
            <div class="row g-3 align-items-end mb-2">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold mb-0">Nama Field <span class="text-danger">*</span></label>
                    <input type="text" name="fields[${index}][name]" class="form-control form-control-sm" required placeholder="contoh: groom_name">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold mb-0">Label <span class="text-danger">*</span></label>
                    <input type="text" name="fields[${index}][label]" class="form-control form-control-sm" required placeholder="Contoh: Nama Mempelai Pria">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold mb-0">Tipe</label>
                    <select name="fields[${index}][type]" class="form-select form-select-sm">
                        <option value="text">Text</option>
                        <option value="textarea">Textarea</option>
                        <option value="number">Number</option>
                        <option value="date">Date</option>
                        <option value="time">Time</option>
                        <option value="email">Email</option>
                        <option value="url">URL</option>
                        <option value="image">Image</option>
                        <option value="boolean">Boolean (Checkbox)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="form-check d-flex align-items-center">
                        <input type="checkbox" name="fields[${index}][required]" value="1" class="form-check-input">
                        <label class="form-check-label mb-0 small fw-semibold">Required</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="this.closest('.field-row').remove(); updateFieldsInput();">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(row);
        updateFieldsInput();
    }

    function updateFieldsInput() {
        const rows = document.querySelectorAll('#fieldsBuilder .field-row');
        const fields = [];
        rows.forEach(row => {
            const nameInput = row.querySelector('input[name$="[name]"]');
            const labelInput = row.querySelector('input[name$="[label]"]');
            const typeSelect = row.querySelector('select[name$="[type]"]');
            const requiredInput = row.querySelector('input[name$="[required]"]');
            if (nameInput && labelInput && typeSelect) {
                fields.push({
                    name: nameInput.value.trim(),
                    label: labelInput.value.trim(),
                    type: typeSelect.value,
                    required: requiredInput ? requiredInput.checked : false
                });
            }
        });
        document.getElementById('dynamicFieldsInput').value = JSON.stringify(fields);
    }

    document.querySelectorAll('#fieldsBuilder .field-row input, #fieldsBuilder .field-row select').forEach(el => {
        el.addEventListener('change', updateFieldsInput);
        el.addEventListener('input', updateFieldsInput);
    });
</script>
@endpush
</x-app-layout>
