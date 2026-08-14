<x-app-layout>

    <div class="container-fluid py-4" style="padding-bottom: 100px">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-1">Template Editor: {{ $template->name }}</h4>
                <p class="text-muted mb-0">Edit kode template dan lihat hasilnya secara langsung</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h6 class="mb-0 fw-bold">Blade Template Editor</h6>
                            <small class="text-muted">File: templates/{{ $template->slug }}/index.blade.php</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('template-creator.preview', $template) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-eye me-1"></i> Preview
                            </a>
                            <button type="button" class="btn btn-primary btn-sm" id="saveCodeBtn">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row g-0" style="height: calc(100vh - 250px); min-height: 500px;">
                            <div class="col-md-6 border-end" style="height: 100%;">
                                <form id="codeEditorForm" action="{{ route('template-creator.editor.save', $template) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <textarea id="codeEditor" name="code" class="form-control border-0" style="height: 100%; width: 100%; font-family: 'Courier New', monospace; font-size: 14px; line-height: 1.6; resize: none; padding: 1rem; background-color: #1e1e1e; color: #d4d4d4;" spellcheck="false">{{ old('code', $code) }}</textarea>
                                </form>
                            </div>
                            <div class="col-md-6" style="height: 100%; background-color: #f8f9fa;">
                                <iframe id="previewFrame" src="{{ route('template-creator.preview', $template) }}" style="width: 100%; height: 100%; border: none; background-color: #fff;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const codeEditor = document.getElementById('codeEditor');
        const previewFrame = document.getElementById('previewFrame');
        const saveBtn = document.getElementById('saveCodeBtn');
        const form = document.getElementById('codeEditorForm');
        let saveTimer;

        function updatePreview() {
            const code = codeEditor.value;
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PUT');
            formData.append('code', code);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    previewFrame.src = previewFrame.src.split('?')[0] + '?v=' + Date.now();
                }
            })
            .catch(err => {
                console.error('Preview update failed:', err);
            });
        }

        codeEditor.addEventListener('input', () => {
            clearTimeout(saveTimer);
            saveTimer = setTimeout(updatePreview, 1000);
        });

        saveBtn.addEventListener('click', () => {
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    previewFrame.src = previewFrame.src.split('?')[0] + '?v=' + Date.now();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Template berhasil disimpan.',
                        confirmButtonColor: '#C6A962',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                }
            });
        });

        // Tab key support in textarea
        codeEditor.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                e.preventDefault();
                const start = this.selectionStart;
                const end = this.selectionEnd;
                this.value = this.value.substring(0, start) + '    ' + this.value.substring(end);
                this.selectionStart = this.selectionEnd = start + 4;
            }
        });
    </script>

</x-app-layout>
