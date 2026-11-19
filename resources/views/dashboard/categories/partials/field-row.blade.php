<div class="field-row">
    <div class="row g-3 align-items-end mb-2">
        <div class="col-md-3">
            <label class="form-label small fw-semibold mb-0">Nama Field <span class="text-danger">*</span></label>
            <input type="text" name="fields[{{ $index }}][name]" class="form-control form-control-sm" value="{{ $field['name'] ?? '' }}" required placeholder="contoh: groom_name">
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold mb-0">Label <span class="text-danger">*</span></label>
            <input type="text" name="fields[{{ $index }}][label]" class="form-control form-control-sm" value="{{ $field['label'] ?? '' }}" required placeholder="Contoh: Nama Mempelai Pria">
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold mb-0">Tipe</label>
            <select name="fields[{{ $index }}][type]" class="form-select form-select-sm">
                <option value="text" {{ ($field['type'] ?? 'text') === 'text' ? 'selected' : '' }}>Text</option>
                <option value="textarea" {{ ($field['type'] ?? 'text') === 'textarea' ? 'selected' : '' }}>Textarea</option>
                <option value="number" {{ ($field['type'] ?? 'text') === 'number' ? 'selected' : '' }}>Number</option>
                <option value="date" {{ ($field['type'] ?? 'text') === 'date' ? 'selected' : '' }}>Date</option>
                <option value="time" {{ ($field['type'] ?? 'text') === 'time' ? 'selected' : '' }}>Time</option>
                <option value="email" {{ ($field['type'] ?? 'text') === 'email' ? 'selected' : '' }}>Email</option>
                <option value="url" {{ ($field['type'] ?? 'text') === 'url' ? 'selected' : '' }}>URL</option>
                <option value="image" {{ ($field['type'] ?? 'text') === 'image' ? 'selected' : '' }}>Image</option>
                <option value="boolean" {{ ($field['type'] ?? 'text') === 'boolean' ? 'selected' : '' }}>Boolean (Checkbox)</option>
            </select>
        </div>
        <div class="col-md-2">
            <div class="form-check d-flex align-items-center">
                <input type="checkbox" name="fields[{{ $index }}][required]" value="1" class="form-check-input" {{ ($field['required'] ?? false) ? 'checked' : '' }}>
                <label class="form-check-label mb-0 small fw-semibold">Required</label>
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="this.closest('.field-row').remove(); if(typeof updateFieldsInput === 'function') updateFieldsInput();">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>
</div>
