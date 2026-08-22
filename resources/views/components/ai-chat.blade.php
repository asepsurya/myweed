<div id="ai-chat-widget" class="ai-chat-widget">
    <button id="ai-chat-toggle" class="ai-chat-toggle" type="button" aria-label="Buat Undangan dengan AI">
        <i class="bi bi-chat-dots-fill"></i>
    </button>

    <div id="ai-chat-panel" class="ai-chat-panel">
        <div class="ai-chat-header">
            <div class="d-flex align-items-center gap-2">
                <div class="ai-chat-avatar">
                    <i class="bi bi-stars"></i>
                </div>
                <div>
                    <div class="ai-chat-title">Asisten Undangan AI</div>
                    <div class="ai-chat-subtitle">Buat undangan dalam 1 menit</div>
                </div>
            </div>
            <button id="ai-chat-close" class="ai-chat-close" type="button" aria-label="Tutup chat">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div id="ai-chat-messages" class="ai-chat-messages">
            <div class="ai-message ai">
                <div class="ai-message-bubble">
                    <p>Hai! Saya <strong>Asisten Undangan AI</strong> dari RuangUndang. ✨</p>
                    <p>Saya akan membantu Anda membuat undangan pernikahan digital secara otomatis.</p>
                    <p>Cukup ceritakan:</p>
                    <ul>
                        <li>Nama mempelai pria & wanita</li>
                        <li>Tanggal pernikahan</li>
                        <li>Lokasi akad / resepsi</li>
                    </ul>
                    <p class="mb-0">Atau pilih topik di bawah untuk mulai.</p>
                </div>
            </div>
        </div>

        <div id="ai-chat-suggestions" class="ai-chat-suggestions">
            <button type="button" class="ai-chip" data-message="Saya mau buat undangan pernikahan">
                <i class="bi bi-suit-heart me-1"></i> Undangan pernikahan
            </button>
            <button type="button" class="ai-chip" data-message="Saya butuh tema yang elegan dan minimalis">
                <i class="bi bi-palette me-1"></i> Tema elegan
            </button>
            <button type="button" class="ai-chip" data-message="Bagaimana cara share undangan ke WhatsApp?">
                <i class="bi bi-whatsapp me-1"></i> Bagikan ke WhatsApp
            </button>
        </div>

        <div id="ai-chat-create" class="ai-chat-create d-none">
            <a href="{{ route('dashboard.user') }}?template_id=2" class="ai-chat-create-btn">
                <i class="bi bi-suit-heart-fill me-1"></i> Buat Undangan
            </a>
            @guest
                <a href="{{ route('register') }}" class="ai-chat-login-link">
                    Belum punya akun? Daftar
                </a>
            @endguest
        </div>

        <div id="ai-chat-wa-fallback" class="ai-chat-wa-fallback">
            <a href="https://wa.me/6287731402487?text=Halo%20saya%20butuh%20bantuan%20dengan%20aplikasi%20RuangUndang"
               target="_blank"
               rel="noopener noreferrer"
               class="ai-chat-wa-btn">
                <i class="bi bi-whatsapp"></i> Chat WhatsApp untuk Bantuan
            </a>
        </div>

        <form id="ai-chat-form" class="ai-chat-form" autocomplete="off">
            @csrf
            <input type="hidden" id="ai-chat-history" value="[]">
            <div class="input-group">
                <input type="text" id="ai-chat-input" class="form-control"
                    placeholder="Tulis nama mempelai atau tanggal pernikahan..." maxlength="500">
                <button class="ai-chat-send" type="submit" aria-label="Kirim pesan">
                    <i class="bi bi-arrow-right-short"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.ai-chat-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    font-family: inherit;
}

.ai-chat-toggle {
    width: 56px;
    height: 56px;
    border: none;
    border-radius: 50%;
    background: linear-gradient(135deg, #C6A962, #A68B4B);
    color: #FFFFFF;
    font-size: 1.5rem;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(198, 169, 98, 0.45);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.ai-chat-toggle:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 12px 30px rgba(198, 169, 98, 0.55);
}

.ai-chat-panel {
    position: absolute;
    bottom: 70px;
    right: 0;
    width: 360px;
    max-width: calc(100vw - 40px);
    height: 500px;
    max-height: calc(100vh - 120px);
    background: #FFFFFF;
    border: 1px solid #E8E4DE;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(27, 42, 74, 0.18);
    display: none;
    flex-direction: column;
    overflow: hidden;
    animation: aiChatIn 0.3s ease;
}

.ai-chat-panel.open {
    display: flex;
}

@keyframes aiChatIn {
    from {
        opacity: 0;
        transform: translateY(12px) scale(0.97);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.ai-chat-header {
    padding: 14px 16px;
    border-bottom: 1px solid #E8E4DE;
    background: linear-gradient(135deg, #1B2A4A, #243b6b);
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}

.ai-chat-avatar {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.15);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.ai-chat-title {
    font-weight: 700;
    font-size: 0.95rem;
    line-height: 1.2;
}

.ai-chat-subtitle {
    font-size: 0.75rem;
    opacity: 0.8;
}

.ai-chat-close {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.12);
    color: #FFFFFF;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease;
    flex-shrink: 0;
}

.ai-chat-close:hover {
    background: rgba(255, 255, 255, 0.25);
}

.ai-chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    background: #F7F5F2;
    -webkit-overflow-scrolling: touch;
}

.ai-message {
    display: flex;
    flex-direction: column;
}

.ai-message.user {
    align-items: flex-end;
}

.ai-message.ai {
    align-items: flex-start;
}

.ai-message-bubble {
    max-width: 85%;
    padding: 10px 14px;
    border-radius: 14px;
    font-size: 0.9rem;
    line-height: 1.5;
    word-wrap: break-word;
}

.ai-message.user .ai-message-bubble {
    background: #1B2A4A;
    color: #FFFFFF;
    border-bottom-right-radius: 4px;
    padding-right: 36px;
    position: relative;
}

.ai-message.user .ai-message-bubble::after {
    content: 'YOU';
    position: absolute;
    right: 10px;
    top: 10px;
    width: 28px;
    height: 20px;
    background: rgba(255, 255, 255, 0.15);
    color: #FFFFFF;
    border-radius: 6px;
    font-size: 9px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
    letter-spacing: 0.5px;
}

.ai-message.ai .ai-message-bubble {
    background: #FFFFFF;
    color: #1B2A4A;
    border: 1px solid #E8E4DE;
    border-bottom-left-radius: 4px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
    padding-left: 36px;
    position: relative;
}

.ai-message.ai .ai-message-bubble::before {
    content: 'AI';
    position: absolute;
    left: 10px;
    top: 10px;
    width: 20px;
    height: 20px;
    background: linear-gradient(135deg, #C6A962, #A68B4B);
    color: #FFFFFF;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
    z-index: 2;
}

.ai-message.ai .ai-message-bubble .wa-inline-icon {
    position: absolute;
    right: 10px;
    bottom: 10px;
    width: 22px;
    height: 22px;
    background: #25D366;
    color: #fff;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    z-index: 2;
    transition: transform 0.2s ease;
}

.ai-message.ai .ai-message-bubble .wa-inline-icon:hover {
    transform: scale(1.1);
    color: #fff;
}

.ai-message.ai .ai-message-bubble .wa-inline-icon svg {
    width: 14px;
    height: 14px;
    fill: currentColor;
}

.ai-message.ai .ai-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    padding: 8px 12px;
    border-radius: 8px;
    background: linear-gradient(135deg, #C6A962, #A68B4B);
    color: #FFFFFF;
    font-weight: 700;
    font-size: 0.85rem;
    text-decoration: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.ai-message.ai .ai-action-btn:hover {
    color: #FFFFFF;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(198, 169, 98, 0.35);
}

.ai-message.ai .ai-message-bubble p {
    margin: 0 0 6px 0;
}

.ai-message.ai .ai-message-bubble p:last-child {
    margin-bottom: 0;
}

.ai-message.ai .ai-message-bubble ul,
.ai-message.ai .ai-message-bubble ol {
    margin: 0 0 6px 0;
    padding-left: 20px;
}

.ai-message.ai .ai-message-bubble li {
    margin-bottom: 2px;
}

.ai-message.ai .ai-message-bubble strong {
    font-weight: 700;
}

.ai-message.ai .ai-message-bubble em {
    font-style: italic;
}

.ai-message.ai .ai-message-bubble code {
    background: rgba(0, 0, 0, 0.06);
    padding: 1px 5px;
    border-radius: 4px;
    font-size: 0.85em;
}

.ai-message.ai .ai-message-bubble pre {
    background: rgba(0, 0, 0, 0.06);
    padding: 8px 10px;
    border-radius: 8px;
    overflow-x: auto;
    font-size: 0.85rem;
}

.ai-message.ai .ai-message-bubble blockquote {
    margin: 0 0 6px 0;
    padding: 6px 10px;
    border-left: 3px solid #C6A962;
    background: rgba(198, 169, 98, 0.08);
    border-radius: 0 8px 8px 0;
}

.ai-message.ai .ai-message-bubble a {
    color: #A68B4B;
    text-decoration: underline;
    text-underline-offset: 2px;
}

.ai-message.ai .ai-message-bubble h1,
.ai-message.ai .ai-message-bubble h2,
.ai-message.ai .ai-message-bubble h3,
.ai-message.ai .ai-message-bubble h4 {
    font-size: 0.95rem;
    font-weight: 700;
    margin: 4px 0 2px 0;
}

.ai-chat-suggestions {
    padding: 10px 12px;
    background: #FFFFFF;
    border-top: 1px solid #E8E4DE;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    flex-shrink: 0;
}

.ai-chip {
    padding: 6px 12px;
    border: 1px solid #E8E4DE;
    border-radius: 50px;
    background: #F7F5F2;
    color: #6B7280;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s ease;
}

.ai-chip:hover {
    background: #1B2A4A;
    color: #FFFFFF;
    border-color: #1B2A4A;
}

.ai-chat-create {
    padding: 12px 16px;
    background: #FFFFFF;
    border-top: 1px solid #E8E4DE;
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex-shrink: 0;
}

.ai-chat-create-btn {
    padding: 10px;
    border-radius: 10px;
    background: linear-gradient(135deg, #C6A962, #A68B4B);
    color: #FFFFFF;
    font-weight: 700;
    font-size: 0.9rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.ai-chat-create-btn:hover {
    color: #FFFFFF;
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(198, 169, 98, 0.35);
}

.ai-chat-login-link {
    font-size: 0.85rem;
    color: #6B7280;
    text-decoration: none;
}

.ai-chat-login-link:hover {
    color: #1B2A4A;
}

.ai-chat-wa-fallback {
    padding: 10px 16px;
    background: #FFFFFF;
    border-top: 1px solid #E8E4DE;
    display: none;
    flex-direction: column;
    gap: 8px;
    flex-shrink: 0;
}

.ai-chat-wa-fallback.show {
    display: flex;
}

.ai-chat-wa-btn {
    padding: 10px;
    border-radius: 10px;
    background: #25D366;
    color: #FFFFFF;
    font-weight: 700;
    font-size: 0.9rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.ai-chat-wa-btn:hover {
    color: #FFFFFF;
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(37, 211, 102, 0.35);
}

.ai-chat-form {
    padding: 12px 16px;
    background: #FFFFFF;
    border-top: 1px solid #E8E4DE;
    flex-shrink: 0;
}

.ai-chat-error {
    margin-top: 6px;
    font-size: 0.8rem;
    color: #dc2626;
}

.ai-typing {
    display: inline-flex;
    gap: 4px;
    padding: 8px 12px;
}

.ai-typing span {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #9CA3AF;
    animation: aiBounce 1.2s infinite ease-in-out;
}

.ai-typing span:nth-child(2) {
    animation-delay: 0.15s;
}

.ai-typing span:nth-child(3) {
    animation-delay: 0.3s;
}

@keyframes aiBounce {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.4;
    }

    30% {
        transform: translateY(-6px);
        opacity: 1;
    }
}

@media (max-width: 480px) {
    .ai-chat-widget {
        bottom: 16px;
        right: 16px;
    }

    .ai-chat-panel {
        width: calc(100vw - 32px);
        height: calc(100vh - 100px);
    }
}
</style>

<script>
(function () {
    "use strict";

    const widget = document.getElementById('ai-chat-widget');
    const toggleBtn = document.getElementById('ai-chat-toggle');
    const closeBtn = document.getElementById('ai-chat-close');
    const panel = document.getElementById('ai-chat-panel');
    const form = document.getElementById('ai-chat-form');
    const input = document.getElementById('ai-chat-input');
    const historyInput = document.getElementById('ai-chat-history');
    const messagesContainer = document.getElementById('ai-chat-messages');
    const createBox = document.getElementById('ai-chat-create');

    if (!widget || !toggleBtn || !panel || !form || !input) return;

    function togglePanel(forceState) {
        const isOpen = panel.classList.contains('open');
        const nextState = forceState !== undefined ? forceState : !isOpen;
        panel.classList.toggle('open', nextState);
        if (nextState) setTimeout(() => input.focus(), 150);
    }

    toggleBtn.addEventListener('click', () => togglePanel());
    closeBtn.addEventListener('click', () => togglePanel(false));

    function getHistory() {
        try {
            return JSON.parse(historyInput.value || '[]');
        } catch (_e) {
            return [];
        }
    }

    function setHistory(history) {
        historyInput.value = JSON.stringify(history.slice(-20));
    }

    function appendMessage(role, text) {
        const wrapper = document.createElement('div');
        wrapper.className = 'ai-message ' + (role === 'user' ? 'user' : 'ai');

        const bubble = document.createElement('div');
        bubble.className = 'ai-message-bubble';

        if (role === 'ai') {
            const isSubscription = /langganan|subscription|premium|upgrade/i.test(text);

            bubble.innerHTML = text;

            if (isSubscription) {
                const actionBtn = document.createElement('a');
                actionBtn.href = '{{ route('subscribe.page') }}';
                actionBtn.className = 'ai-action-btn';
                actionBtn.innerHTML = '<i class="bi bi-star-fill"></i> Lihat Paket Langganan';
                actionBtn.target = '_blank';
                bubble.appendChild(actionBtn);
            }

            const waIcon = document.createElement('a');
            waIcon.href = 'https://wa.me/6287731402487?text=Halo%20saya%20butuh%20bantuan%20dengan%20aplikasi%20RuangUndang';
            waIcon.target = '_blank';
            waIcon.rel = 'noopener noreferrer';
            waIcon.className = 'wa-inline-icon';
            waIcon.title = 'Chat WhatsApp';
            waIcon.innerHTML = '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
            bubble.appendChild(waIcon);
        } else {
            bubble.textContent = text;
        }

        wrapper.appendChild(bubble);
        messagesContainer.appendChild(wrapper);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function showTyping() {
        const wrapper = document.createElement('div');
        wrapper.className = 'ai-message ai';
        wrapper.id = 'ai-typing-indicator';

        const bubble = document.createElement('div');
        bubble.className = 'ai-message-bubble ai-typing';
        bubble.innerHTML = '<span></span><span></span><span></span>';

        wrapper.appendChild(bubble);
        messagesContainer.appendChild(wrapper);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function hideTyping() {
        const typing = document.getElementById('ai-typing-indicator');
        if (typing) typing.remove();
    }

    function showError(message) {
        const existing = widget.querySelector('.ai-chat-error');
        if (existing) existing.remove();

        const error = document.createElement('div');
        error.className = 'ai-chat-error';
        error.textContent = message;
        form.appendChild(error);
        setTimeout(() => error.remove(), 4000);
    }

    function showWaFallback() {
        const fallback = document.getElementById('ai-chat-wa-fallback');
        if (fallback) fallback.classList.add('show');
    }

    function hideWaFallback() {
        const fallback = document.getElementById('ai-chat-wa-fallback');
        if (fallback) fallback.classList.remove('show');
    }

    async function sendMessage(e) {
        if (e) e.preventDefault();

        const message = input.value.trim();
        if (!message) return;

        const history = getHistory();

        appendMessage('user', message);
        input.value = '';
        showTyping();

        try {
            const response = await fetch('/api/ai/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    message: message,
                    history: history,
                    model: '{{ env("AI_MODEL_PRIMARY") }}',
                }),
            });

            hideTyping();

            const data = await response.json().catch(() => ({}));

            if (!response.ok || !data.success) {
                showError(data.message || 'Gagal menghubungi asisten AI.');
                appendMessage('ai', 'Maaf, ada kendala saat ini. Coba kirim pesan sekali lagi.');
                showWaFallback();
                return;
            }

            const replyHtml = data.reply || 'Baik, saya catat ya.';
            const replyText = data.reply_text || replyHtml.replace(/<[^>]+>/g, '');
            const hasFallback = data.has_fallback === true;

            appendMessage('ai', replyHtml);

            if (hasFallback) {
                showWaFallback();
            } else {
                hideWaFallback();
            }

            history.push({ role: 'user', content: message });
            history.push({ role: 'assistant', content: replyText });
            setHistory(history);

            const lower = replyText.toLowerCase();
            const hasInvitationKeyword =
                lower.includes('undangan') &&
                (lower.includes('buat') || lower.includes('cukup') ||
                    lower.includes('informasi') || lower.includes('klik'));

            if (hasInvitationKeyword) {
                createBox.classList.remove('d-none');
            }
        } catch (_err) {
            hideTyping();
            showError('Tidak dapat terhubung ke layanan AI.');
            appendMessage('ai', 'Koneksi ke AI gangguan. Coba lagi sebentar lagi ya.');
            showWaFallback();
        }
    }

    form.addEventListener('submit', sendMessage);

    document.querySelectorAll('.ai-chip').forEach(function (chip) {
        chip.addEventListener('click', function () {
            const msg = this.getAttribute('data-message');
            if (!msg) return;
            input.value = msg;
            input.focus();
            sendMessage();
        });
    });

    document.addEventListener('click', function (event) {
        if (!widget.contains(event.target)) {
            togglePanel(false);
        }
    });
})();
</script>
