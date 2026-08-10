<x-app-layout>

    <div class="container-fluid py-4" style="padding-bottom: 100px">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-1">{{ $template->exists ? 'Edit Template' : 'Buat Template Baru' }}</h4>
                <p class="text-muted mb-0">Gunakan AI untuk membuat template undangan atau edit manual</p>
            </div>
        </div>

        <form id="templateForm" method="POST" action="{{ $template->exists ? route('template-creator.update', $template) : route('template-creator.store') }}" enctype="multipart/form-data">
            @csrf
            @if($template->exists)
                @method('PUT')
            @endif

            <input type="hidden" name="ai_prompt" id="aiPromptInput" value="{{ old('ai_prompt', $template->ai_prompt ?? '') }}">

            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="fw-bold mb-0"><i class="bi bi-gear me-2"></i>Informasi Template</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Template</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $template->name ?? '') }}" placeholder="Contoh: Modern Gold Wedding" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan gaya template ini...">{{ old('description', $template->description ?? '') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Thumbnail</label>
                                <input type="file" name="thumbnail" class="form-control" accept="image/*">
                                @if($template->thumbnail ?? false)
                                    <img src="{{ asset('storage/' . $template->thumbnail) }}" class="mt-2 rounded" style="height: 120px; object-fit: cover;">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="fw-bold mb-0"><i class="bi bi-stars me-2"></i>Generate dengan AI</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Prompt / Deskripsi Template</label>
                                <textarea id="aiPrompt" class="form-control" rows="4" placeholder="Contoh: Template undangan pernikahan modern dengan tema gold dan navy, ada animasi floating heart, minimalis tapi elegan..."></textarea>
                                <div id="aiImproveStatus" class="mt-2 d-none"></div>
                            </div>

                            <div class="d-flex gap-2 mb-3">
                                <button type="button" id="improvePromptBtn" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-magic me-1"></i> Perbaiki Prompt
                                </button>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-semibold">Gaya Desain</label>
                                    <select id="aiStyle" class="form-select">
                                        <option value="modern">Modern</option>
                                        <option value="minimalis">Minimalis</option>
                                        <option value="elegant">Elegant</option>
                                        <option value="rustic">Rustic</option>
                                        <option value="floral">Floral</option>
                                        <option value="islami">Islami</option>
                                        <option value="vintage">Vintage</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold">Skema Warna</label>
                                    <input list="colorSchemePresets" id="aiColorScheme" class="form-control" value="#1B2A4A dan #C6A962" placeholder="Contoh: #1B2A4A dan #C6A962">
                                    <datalist id="colorSchemePresets">
                                        <option value="#1B2A4A dan #C6A962">
                                        <option value="#1A3C34 dan #C5A059">
                                        <option value="#c8a97e dan #fdfaf6">
                                        <option value="#2C2C2C dan #C5A059">
                                        <option value="#1B2A4A dan #FF6B81">
                                        <option value="#8B4513 dan #D2691E">
                                        <option value="#0f172a dan #94a3b8">
                                    </datalist>
                                </div>
                            </div>

                            <button type="button" id="generateAiBtn" class="btn btn-warning w-100 position-relative">
                                <span id="generateBtnText"><i class="bi bi-magic me-1"></i> Generate Template dengan AI</span>
                                <span id="generateBtnLoader" class="d-none position-absolute top-50 start-50 translate-middle">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    <span class="visually-hidden">Loading...</span>
                                </span>
                            </button>

                            <div id="aiGenerateError" class="alert alert-danger mt-3 d-none" role="alert"></div>
                            <div id="aiGenerateSuccess" class="alert alert-success mt-3 d-none" role="alert"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0"><i class="bi bi-code-slash me-2"></i>Kode Template (Blade)</h6>
                            <div class="btn-group btn-group-sm">
                                <button type="button" id="previewBtn" class="btn btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> Preview
                                </button>
                                <button type="button" id="saveBtn" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i> Simpan Template
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 position-relative">
                            <textarea id="templateCode" name="code" class="form-control font-monospace border-0" rows="24" style="resize: vertical; font-size: 0.85rem; line-height: 1.5;" placeholder="<!-- Kode template Blade akan muncul di sini -->">{{ old('code', $code ?? $template->code ?? '') }}</textarea>
                            <div id="codeLoadingOverlay" class="d-none position-absolute top-0 start-0 w-100 h-100 bg-white/75 d-flex align-items-center justify-content-center" style="z-index: 10;">
                                <div class="text-center">
                                    <div class="spinner-border text-warning mb-2" role="status"></div>
                                    <p class="text-muted small mb-0">Menghasilkan kode template...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-eye me-2"></i>Preview Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="previewFrame" src="" style="width: 100%; height: 70vh; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <style>
        .ai-generation-active #generateBtnText { opacity: 0.4; }
        .ai-generation-active #generateBtnLoader { display: inline-block !important; }
        .ai-improve-active #improvePromptBtn { opacity: 0.6; pointer-events: none; }
        .ai-improve-loading #improvePromptBtn .btn-text { display: none; }
        .ai-improve-loading #improvePromptBtn .btn-loader { display: inline; }
        #improvePromptBtn .btn-loader { display: none; }
        .code-update-flash { animation: codeFlash 1.2s ease-out; }
        @keyframes codeFlash {
            0% { box-shadow: inset 0 0 0 2px #C6A962; background-color: rgba(198,169,98,0.08); }
            100% { box-shadow: inset 0 0 0 2px transparent; background-color: transparent; }
        }
    </style>

    <script>
        (function () {
            const generateBtn = document.getElementById('generateAiBtn');
            const improvePromptBtn = document.getElementById('improvePromptBtn');
            const previewBtn = document.getElementById('previewBtn');
            const saveBtn = document.getElementById('saveBtn');
            const codeArea = document.getElementById('templateCode');
            const promptArea = document.getElementById('aiPrompt');
            const styleSelect = document.getElementById('aiStyle');
            const colorInput = document.getElementById('aiColorScheme');
            const errorDiv = document.getElementById('aiGenerateError');
            const successDiv = document.getElementById('aiGenerateSuccess');
            const previewModal = document.getElementById('previewModal');
            const previewFrame = document.getElementById('previewFrame');
            const improveStatus = document.getElementById('aiImproveStatus');
            const codeLoadingOverlay = document.getElementById('codeLoadingOverlay');

            if (!generateBtn || !codeArea) return;

            function setGenerateLoading(isLoading) {
                if (isLoading) {
                    generateBtn.classList.add('ai-generation-active');
                    generateBtn.disabled = true;
                    codeLoadingOverlay.classList.remove('d-none');
                } else {
                    generateBtn.classList.remove('ai-generation-active');
                    generateBtn.disabled = false;
                    codeLoadingOverlay.classList.add('d-none');
                }
            }

            function setImproveLoading(isLoading) {
                if (isLoading) {
                    improvePromptBtn.classList.add('ai-improve-loading');
                    improvePromptBtn.disabled = true;
                    improvePromptBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> <span class="btn-text">Memperbaiki...</span>';
                } else {
                    improvePromptBtn.classList.remove('ai-improve-loading');
                    improvePromptBtn.disabled = false;
                    improvePromptBtn.innerHTML = '<i class="bi bi-magic me-1"></i> <span class="btn-text">Perbaiki Prompt</span>';
                }
            }

            improvePromptBtn.addEventListener('click', async function () {
                const prompt = promptArea.value.trim();
                if (!prompt) {
                    improveStatus.className = 'mt-2 alert alert-warning py-2 small mb-0';
                    improveStatus.textContent = 'Tulis prompt terlebih dahulu sebelum memperbaiki.';
                    return;
                }

                improveStatus.className = 'mt-2 alert alert-info py-2 small mb-0';
                improveStatus.textContent = 'Sedang memperbaiki prompt...';
                setImproveLoading(true);

                try {
                    const response = await fetch('{{ route('template-creator.improve-prompt') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ prompt: prompt }),
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        improveStatus.className = 'mt-2 alert alert-danger py-2 small mb-0';
                        improveStatus.textContent = data.message || 'Gagal memperbaiki prompt.';
                        return;
                    }

                    promptArea.value = data.improved_prompt || prompt;
                    improveStatus.className = 'mt-2 alert alert-success py-2 small mb-0';
                    improveStatus.textContent = 'Prompt berhasil diperbaiki!';
                    setTimeout(() => improveStatus.classList.add('d-none'), 3000);
                } catch (err) {
                    improveStatus.className = 'mt-2 alert alert-danger py-2 small mb-0';
                    improveStatus.textContent = 'Tidak dapat terhubung ke layanan AI.';
                } finally {
                    setImproveLoading(false);
                }
            });

            generateBtn.addEventListener('click', async function () {
                const prompt = promptArea.value.trim();
                if (!prompt) {
                    errorDiv.textContent = 'Mohon isi deskripsi template terlebih dahulu.';
                    errorDiv.classList.remove('d-none');
                    successDiv.classList.add('d-none');
                    return;
                }

                errorDiv.classList.add('d-none');
                successDiv.classList.add('d-none');
                setGenerateLoading(true);

                try {
                    const response = await fetch('{{ route('template-creator.generate') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            prompt: prompt,
                            style: styleSelect.value,
                            color_scheme: colorInput.value,
                            base_template_id: null,
                        }),
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        errorDiv.textContent = data.message || 'Gagal generate template.';
                        errorDiv.classList.remove('d-none');
                        successDiv.classList.add('d-none');
                        return;
                    }

                    codeArea.value = data.code || data.raw || '';
                    document.getElementById('aiPromptInput').value = promptArea.value;

                    successDiv.textContent = 'Template berhasil digenerate!';
                    successDiv.classList.remove('d-none');
                    errorDiv.classList.add('d-none');

                    codeArea.classList.add('code-update-flash');
                    setTimeout(() => codeArea.classList.remove('code-update-flash'), 1200);
                } catch (err) {
                    errorDiv.textContent = 'Tidak dapat terhubung ke layanan AI.';
                    errorDiv.classList.remove('d-none');
                    successDiv.classList.add('d-none');
                } finally {
                    setGenerateLoading(false);
                }
            });

            previewBtn.addEventListener('click', async function () {
                const code = codeArea.value.trim();
                if (!code) {
                    alert('Kode template masih kosong.');
                    return;
                }

                previewBtn.disabled = true;
                previewBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Loading...';

                try {
                    const response = await fetch('{{ route('template-creator.preview-code') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ code: code }),
                    });

                    if (!response.ok) {
                        alert('Gagal memuat preview.');
                        return;
                    }

                    const blob = await response.blob();
                    const url = URL.createObjectURL(blob);
                    previewFrame.src = url;
                    previewModal.classList.add('show');
                } catch (err) {
                    alert('Tidak dapat memuat preview.');
                } finally {
                    previewBtn.disabled = false;
                    previewBtn.innerHTML = '<i class="bi bi-eye me-1"></i> Preview';
                }
            });

            saveBtn.addEventListener('click', function () {
                document.getElementById('templateForm').submit();
            });
        })();
    </script>

</x-app-layout>
