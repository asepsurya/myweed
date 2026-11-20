@php
    $currentIcon = old('icon', ($category->icon ?? 'bi-folder'));
    $currentSvg = old('icon_svg', ($category->icon_svg ?? ''));
@endphp

<div class="icon-picker">
    <label class="form-label fw-semibold d-block">Ikon Kategori <span class="text-muted small">(Bootstrap Icons)</span></label>

    <div class="d-flex align-items-center gap-3 mb-2 p-2 rounded-3 border bg-body-tertiary">
        <div class="rounded-3 d-flex align-items-center justify-content-center bg-white border flex-shrink-0"
            style="width: 56px; height: 56px;">
            <i class="bi {{ $currentIcon }}" id="categoryIconPreview" style="font-size: 1.6rem;"></i>
        </div>
        <div style="min-width: 0;">
            <div class="fw-semibold small text-truncate" id="categoryIconName">{{ $currentIcon }}</div>
            <div class="text-muted" style="font-size: 0.72rem;">Klik ikon di bawah untuk memilih</div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary ms-auto flex-shrink-0" id="categoryIconClear">
            <i class="bi bi-x-lg me-1"></i> Reset
        </button>
    </div>

    <input type="hidden" name="icon" id="categoryIconInput" value="{{ $currentIcon }}">

    <div class="input-group mb-2">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" class="form-control" id="categoryIconSearch" placeholder="Cari ikon... (contoh: heart, cake, calendar)">
        <span class="input-group-text text-muted small" id="categoryIconCount">0 ikon</span>
    </div>

    <div class="border rounded-3 p-2" id="categoryIconGrid"
        style="max-height: 260px; overflow-y: auto; display: grid; grid-template-columns: repeat(auto-fill, minmax(50px, 1fr)); gap: 4px; align-content: start;">
    </div>

    <div class="mt-3 pt-3 border-top">
        <label class="form-label small fw-semibold d-block">
            <i class="bi bi-upload me-1"></i>Atau Upload Ikon SVG
            <span class="text-muted">(opsional — jika diisi, SVG ini yang dipakai menggantikan ikon di atas)</span>
        </label>
        <input type="hidden" name="icon_svg" id="categoryIconSvgInput" value="{{ $currentSvg }}">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center bg-white border flex-shrink-0"
                style="width: 56px; height: 56px;" id="categorySvgPreviewBox">
                <i class="bi bi-upload text-muted" style="font-size: 1.4rem;"></i>
            </div>
            <div>
                <label class="btn btn-sm btn-outline-secondary mb-0" for="categoryIconSvgFile">
                    <i class="bi bi-upload me-1"></i>Pilih File SVG
                </label>
                <input type="file" id="categoryIconSvgFile" accept=".svg,image/svg+xml" class="d-none">
                <button type="button" class="btn btn-sm btn-outline-danger ms-1 {{ $currentSvg ? '' : 'd-none' }}"
                    id="categoryIconSvgClear">
                    <i class="bi bi-x-lg me-1"></i>Hapus
                </button>
                <div class="form-text">Format .svg, maksimal 100 KB.</div>
            </div>
        </div>
        <div class="text-danger small mt-1" id="categoryIconSvgError"></div>
    </div>
</div>

<script src="{{ asset('assets/js/bootstrap-icons-list.js') }}?v={{ @filemtime(public_path('assets/js/bootstrap-icons-list.js')) }}"></script>
<script>
    (function () {
        const picker = document.querySelector('.icon-picker');
        if (!picker) return;
        if (!window.BOOTSTRAP_ICONS) {
            const cnt = picker.querySelector('#categoryIconCount');
            if (cnt) cnt.textContent = 'Daftar ikon gagal dimuat';
            return;
        }

        const hidden = picker.querySelector('#categoryIconInput');
        const preview = picker.querySelector('#categoryIconPreview');
        const nameEl = picker.querySelector('#categoryIconName');
        const grid = picker.querySelector('#categoryIconGrid');
        const search = picker.querySelector('#categoryIconSearch');
        const clearBtn = picker.querySelector('#categoryIconClear');
        const countEl = picker.querySelector('#categoryIconCount');

        const current = hidden.value || 'bi-folder';

        function select(icon) {
            hidden.value = icon;
            preview.className = 'bi ' + icon;
            nameEl.textContent = icon;
            grid.querySelectorAll('.icon-picker-btn').forEach(function (btn) {
                btn.classList.toggle('active', btn.dataset.icon === icon);
            });
        }

        function render(filter) {
            const q = (filter || '').toLowerCase().replace(/^bi-/, '').trim();
            const icons = q
                ? window.BOOTSTRAP_ICONS.filter(function (name) { return name.replace('bi-', '').includes(q); })
                : window.BOOTSTRAP_ICONS;

            countEl.textContent = icons.length + ' ikon';
            grid.innerHTML = '';

            const frag = document.createDocumentFragment();
            icons.forEach(function (icon) {
                const name = icon.indexOf('bi-') === 0 ? icon : 'bi-' + icon;
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'icon-picker-btn';
                if (name === hidden.value) btn.classList.add('active');
                btn.dataset.icon = name;
                btn.title = name;
                btn.innerHTML = '<i class="bi ' + name + '"></i>';
                btn.addEventListener('click', function () { select(name); });
                frag.appendChild(btn);
            });
            grid.appendChild(frag);
        }

        /* ── Upload SVG ── */
        const svgInput = picker.querySelector('#categoryIconSvgInput');
        const svgFile = picker.querySelector('#categoryIconSvgFile');
        const svgPreviewBox = picker.querySelector('#categorySvgPreviewBox');
        const svgClear = picker.querySelector('#categoryIconSvgClear');
        const svgError = picker.querySelector('#categoryIconSvgError');

        function renderSvgPreview(src) {
            if (!svgPreviewBox) return;
            svgPreviewBox.innerHTML = '';
            if (src) {
                const img = document.createElement('img');
                img.src = src;
                img.alt = '';
                img.style.cssText = 'width:1.6rem;height:1.6rem;object-fit:contain;';
                svgPreviewBox.appendChild(img);
                if (svgClear) svgClear.classList.remove('d-none');
            } else {
                svgPreviewBox.innerHTML = '<i class="bi bi-upload text-muted" style="font-size:1.4rem;"></i>';
                if (svgClear) svgClear.classList.add('d-none');
            }
        }

        if (svgFile) {
            svgFile.addEventListener('change', function () {
                const file = this.files && this.files[0];
                if (svgError) svgError.textContent = '';
                if (!file) return;

                if (!/\.svg$/i.test(file.name) && file.type !== 'image/svg+xml') {
                    if (svgError) svgError.textContent = 'File harus berformat .svg';
                    this.value = '';
                    return;
                }
                if (file.size > 100 * 1024) {
                    if (svgError) svgError.textContent = 'Ukuran SVG maksimal 100 KB';
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    if (svgInput) svgInput.value = e.target.result;
                    renderSvgPreview(e.target.result);
                };
                reader.readAsDataURL(file);
            });
        }

        if (svgClear) {
            svgClear.addEventListener('click', function () {
                if (svgInput) svgInput.value = '';
                if (svgFile) svgFile.value = '';
                renderSvgPreview('');
            });
        }

        search.addEventListener('input', function () { render(search.value); });
        clearBtn.addEventListener('click', function () { select('bi-folder'); search.value = ''; render(''); });

        select(current);
        render('');
        renderSvgPreview(svgInput ? svgInput.value : '');
    })();
</script>