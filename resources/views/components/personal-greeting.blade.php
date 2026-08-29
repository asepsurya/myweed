@if(!empty($guestName))
    <div id="personalGreeting" class="personal-greeting-banner" style="
        background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%);
        color: #fff;
        text-align: center;
        padding: 12px 16px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 500;
        position: sticky;
        top: 0;
        z-index: 9999;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    ">
        <div class="container">
            <i class="bi bi-person-circle me-2"></i>
            Halo, <strong>{{ $guestName }}</strong>! Undangan ini untuk Anda.
        </div>
    </div>
@endif
