<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }} | The Wedding</title>
    <meta name="description" content="Undangan Pernikahan {{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }} - {{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('d F Y') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&family=Vujahday+Script&family=Annapurna+SIL:wght@400;700&display=swap');

body {
    padding: 0;
    margin: 0;
    background-color: #1a0203;
}

/* Lock scroll sebelum undangan dibuka */
body.locked {
    overflow: hidden;
}

.main-container {
    max-width: 480px;
    margin: 0 auto;
    position: relative;
    background-color: #fff;
    overflow: hidden;
    width: 100%;
    min-height: 100vh;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

/* Wrapper untuk Cover Locked */
.cover-wrapper {
    position: fixed;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 480px;
    height: 100%;
    z-index: 1000;
    transition: transform 0.9s cubic-bezier(0.7, 0, 0.2, 1), opacity 0.9s ease;
}
.cover-wrapper.hide-cover {
    transform: translateX(-50%) translateY(-100%);
    opacity: 0;
    pointer-events: none;
}

.cover-1,
.cover-1 * {
    box-sizing: border-box;
}

.cover-1 {
    background: #ff0000;
    height: 100svh;
    min-height: 883px;
    position: relative;
    overflow: hidden;
}

.rectangle-1 {
    background: linear-gradient(to left, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2));
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0px;
    top: 0px;
    object-fit: cover;
}

.head {
    display: flex;
    flex-direction: column;
    gap: 27px;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 530px;
    position: absolute;
    left: 50%;
    translate: -50% -50%;
    top: 50%;
}

.the-wedding-of {
    color: #ffffff;
    text-align: center;
    font-family: "Annapurna SIL", sans-serif;
    font-size: 24px;
    line-height: 22px;
    letter-spacing: -0.04em;
    font-weight: 700;
    position: relative;
    align-self: stretch;
    height: 26px;
}

.frame-1 {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: center;
    justify-content: center;
    align-self: stretch;
    flex-shrink: 0;
    position: relative;
}

.islan-aslan {
    color: #ffffff;
    text-align: center;
    font-family: "Vujahday Script", sans-serif;
    font-size: 96px;
    line-height: 81px;
    letter-spacing: -0.04em;
    font-weight: 400;
    position: relative;
    align-self: stretch;
}

._30-06-2026 {
    color: #ffffff;
    text-align: center;
    font-family: "Annapurna SIL", sans-serif;
    font-size: 24px;
    line-height: 22px;
    letter-spacing: -0.04em;
    font-weight: 700;
    position: relative;
    align-self: stretch;
    height: 26px;
}

.group-3 {
    position: absolute;
    inset: 0;
}

.rectangle-5 {
    background: #8b1111;
    border-radius: 25px;
    width: 48%;
    height: 45px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 82%;
}

.buka-undangan {
    color: #ffffff;
    text-align: center;
    font-family: "Arimo", sans-serif;
    font-size: 15px;
    line-height: 45px;
    letter-spacing: -0.04em;
    font-weight: 700;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 82%;
    white-space: nowrap;
    cursor: pointer;
    z-index: 10;
}

.javanese-paperize-7-1 {
    width: 150%;
    height: auto;
    position: absolute;
    left: -1%;
    top: -25%;
    object-fit: cover;
    aspect-ratio: 597/257;
}

.javanese-paperize-7-2 {
    width: 150%;
    height: auto;
    position: absolute;
    left: -14%;
    bottom: -20%;
    top: auto;
    object-fit: cover;
    aspect-ratio: 597/257;
}

.section-2,
.section-2 * {
    box-sizing: border-box;
}

.section-2 {
    width:100%;
    background: #8b1111;
    height: 883px;
    min-height: 100svh;
    position: relative;
    overflow: hidden;
}

.rectangle-6 {
    background: linear-gradient(to left,
            rgba(243, 1, 1, 0.2),
            rgba(243, 1, 1, 0.2));
    width: 100%;
    height: 200px;
    position: absolute;
    left: 0;
    top: 619px;
    object-fit: cover;
}

.house-java-m-1 {
    width: 288px;
    height: 240px;
    position: absolute;
    left: 206px;
    top: 565px;
    object-fit: cover;
    aspect-ratio: 288/240;
}

.afb-133-e-7-a-7-ec-4-a-6-d-b-886-ec-09-db-826-bcd-1-1 {
    width: 149px;
    height: 274px;
    position: absolute;
    left: -39.03px;
    top: 559px;
    transform-origin: 0 0;
    transform: rotate(3.131deg) scale(1, 1);
    object-fit: cover;
    aspect-ratio: 149/274;
}

.menu {
    position: absolute;
    inset: 0;
}

.rectangle-4 {
    background: #3d080a;
    border-radius: 39px;
    width: 368px;
    height: 66px;
    position: absolute;
    left: 22px;
    top: 782px;
}

.group-2 {
    width: 315.24px;
    height: 40.99px;
    position: absolute;
    left: 48px;
    top: 792px;
    overflow: visible;
}

.vector-1 {
    width: 403px;
    height: 354px;
    position: absolute;
    left: -1px;
    top: 1px;
    overflow: visible;
    object-fit: cover;
}

.red-rose-1-1-1 {
    width: 282px;
    height: 382px;
    position: absolute;
    left: -128.93px;
    top: -30px;
    transform-origin: 0 0;
    transform: rotate(5.268deg) scale(1, 1);
    object-fit: cover;
    aspect-ratio: 282/382;
}

.rectangle-14 {
    width: 500px;
    position: absolute;
    top: -10%;
}

.assets-dreamy-javanese-1-1 {
    width: 279px;
    height: 403px;
    position: absolute;
    left: -80px;
    top: 499.19px;
    transform-origin: 0 0;
    transform: rotate(-40.499deg) scale(1, 1);
    aspect-ratio: 279/403;
}

.janur-maroon-1 {
    width: 100%;
    height: 442px;
    position: absolute;
    left: 691.79px;
    top: 94px;
    transform-origin: 0 0;
    transform: rotate(11.72deg) scale(-1, 1);
    object-fit: cover;
    aspect-ratio: 1;
}

.javanese-paperize-7-3 {
    width: 307px;
    height: 132px;
    position: absolute;
    left: 201px;
    top: 252px;
    transform-origin: 0 0;
    transform: rotate(0deg) scale(-1, 1);
    object-fit: cover;
    aspect-ratio: 307/132;
}


.group-5 {
    position: absolute;
    inset: 0;
    aspect-ratio: 336/265.44;
}

.dan-di-antara-tanda-tanda-kebesaran-nya-ialah-dia-menciptakan-pasangan-untukmu-agar-kamu-merasa-tentram-qs-ar-rum-21 {
    color: #ffffff;
    text-align: center;
    font-family: "Arimo", sans-serif;
    font-size: 14px;
    line-height: 25px;
    font-weight: 400;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 498.57px;
    width: 84%;
    height: auto;
}

   .group-4 {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 320px;
    max-width: 90%;
    height: auto;
}

@media (max-width: 768px) {
    .group-4 {
        width: 70%;
    }
}

@media (max-width: 480px) {
    .group-4 {
        width: 85%;
    }
}

@media (max-width: 360px) {
    .group-4 {
        width: 92%;
    }
}
.group-4 img {
    width: 100%;
    height: auto;
    object-fit: contain;
    display: block;
}
.section-3,
.section-3 * {
    box-sizing: border-box;
}

.section-3 {
    background: #8b1111;
    height: 883px;
    min-height: 100svh;
    position: relative;
    overflow: hidden;
}

.javanese-paperize-2-1-1 {
    width: 360px;
    height: 193px;
    position: absolute;
    left: -112px;
    top: 598px;
    object-fit: cover;
    aspect-ratio: 360/193;
}

.pengantin {
    color: #ffffff;
    text-align: center;
    font-family: "Annapurna SIL", sans-serif;
    font-size: 32px;
    line-height: 25px;
    font-weight: 700;
    position: absolute;
    left: 75%;
    transform: translateX(-50%);
    top: 65px;
    width: auto;
    height: 102px;
    white-space: nowrap;
}

.javanese-paperize-7-4 {
    width: 1174px;
    height: 505px;
    position: absolute;
    left: 584.06px;
    top: 25.31px;
    transform-origin: 0 0;
    transform: rotate(-13.663deg) scale(-1, 1);
    object-fit: cover;
    aspect-ratio: 1174/505;
}

.janur-maroon-2 {
    width: 415px;
    height: 415px;
    position: absolute;
    left: -120.56px;
    top: -5px;
    transform-origin: 0 0;
    transform: rotate(4.9deg) scale(1, 1);
    object-fit: cover;
    aspect-ratio: 1;
}

.red-rose-1-1-2 {
    width: 299px;
    height: 405px;
    position: absolute;
    left: -32px;
    top: 65px;
    object-fit: cover;
    aspect-ratio: 299/405;
}

.group-6 {
    position: absolute;
    inset: 0;
}

.rectangle-7 {
    border-radius: 30px;
    width: 290.85px;
    height: 279.74px;
    position: absolute;
    left: 61px;
    top: 153px;
    object-fit: cover;
}

.rectangle-8 {
    width: 282.52px;
    height: 82.44px;
    position: absolute;
    left: 69.34px;
    top: 350.3px;
    overflow: visible;
}

.adinda-mawaria {
    color: #ffffff;
    text-align: center;
    font-family: "Annapurna SIL", sans-serif;
    font-size: 24px;
    line-height: 25px;
    font-weight: 700;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 358.63px;
    width: auto;
    height: 37.98px;
    white-space: nowrap;
}

.bapak-sanusi-s-m-ibu-jubaedah-dari-london-utara {
    color: #ffffff;
    text-align: left;
    font-family: "Arimo", sans-serif;
    font-size: 12px;
    line-height: 17px;
    font-weight: 400;
    position: absolute;
    left: 129.54px;
    top: 382.72px;
    width: 228.79px;
    height: 59.28px;
}

.group-7 {
    position: absolute;
    inset: 0;
}

.rectangle-72 {
    border-radius: 30px;
    width: 290.85px;
    height: 279.74px;
    position: absolute;
    left: 61px;
    top: 461px;
    object-fit: cover;
}

.rectangle-82 {
    border-radius: 0px;
    width: 282.52px;
    height: 82.44px;
    position: absolute;
    left: 60px;
    top: 659px;
    overflow: visible;
}

.adinda-mawaria2 {
    color: #ffffff;
    text-align: center;
    font-family: "Annapurna SIL", sans-serif;
    font-size: 24px;
    line-height: 25px;
    font-weight: 700;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 667px;
    width: auto;
    height: 37.98px;
    white-space: nowrap;
}

.bapak-sanusi-s-m-ibu-jubaedah-dari-london-utara2 {
    color: #ffffff;
    text-align: left;
    font-family: "Arimo", sans-serif;
    font-size: 12px;
    line-height: 17px;
    font-weight: 400;
    position: absolute;
    left: 84px;
    top: 695px;
    width: 228.79px;
    height: 59.28px;
}

.afb-133-e-7-a-7-ec-4-a-6-d-b-886-ec-09-db-826-bcd-1-2 {
    width: 127.38px;
    height: 233.08px;
    position: absolute;
    left: -27px;
    top: 252.32px;
    transform-origin: 0 0;
    transform: rotate(-9.633deg) scale(1, 1);
    object-fit: cover;
    aspect-ratio: 127.38/233.08;
}

.afb-133-e-7-a-7-ec-4-a-6-d-b-886-ec-09-db-826-bcd-1-3 {
    width: 111.88px;
    height: 204.72px;
    position: absolute;
    left: 424.56px;
    top: 593.72px;
    transform-origin: 0 0;
    transform: rotate(-9.633deg) scale(-1, 1);
    object-fit: cover;
    aspect-ratio: 111.88/204.72;
}

.section-4,
.section-4 * {
    box-sizing: border-box;
}

.section-4 {
    background: #8b1111;
    height: 883px;
    min-height: 100svh;
    position: relative;
    overflow: hidden;
}

.javanese-paperize-7-5 {
    width: 831.76px;
    height: 357.61px;
    position: absolute;
    left: 598.69px;
    top: 509.47px;
    transform-origin: 0 0;
    transform: rotate(-13.663deg) scale(-1, 1);
    object-fit: cover;
    aspect-ratio: 831.76/357.61;
}

.javanese-paperize-2-1-1 {
    width: 360px;
    height: 193px;
    position: absolute;
    left: -76px;
    top: -15px;
    object-fit: cover;
    aspect-ratio: 360/193;
}

.house-java-m-2 {
    width: 308px;
    height: 256px;
    position: absolute;
    left: 215px;
    top: -33px;
    object-fit: cover;
    aspect-ratio: 308/256;
}

.menu {
    position: absolute;
    inset: 0;
}

.rectangle-4 {
    background: #3d080a;
    border-radius: 39px;
    width: 368px;
    height: 66px;
    position: absolute;
    left: 22px;
    top: 782px;
}

.group-2 {
    width: 305.95px;
    height: 40.99px;
    position: absolute;
    left: 57.29px;
    top: 795px;
    overflow: visible;
}

.love-story {
    color: #ffffff;
    text-align: center;
    font-family: "Annapurna SIL", sans-serif;
    font-size: 32px;
    line-height: 25px;
    font-weight: 700;
    position: absolute;
    left: 30%;
    transform: translateX(-50%);
    top: 177px;
    width: auto;
    height: 92px;
    white-space: nowrap;
}

.rectangle-9 {
    border-radius: 20px;
    width: 163px;
    height: 171px;
    position: absolute;
    left: 48px;
    top: 233px;
    object-fit: cover;
}

.rectangle-13 {
    border-radius: 20px;
    width: 137px;
    height: 171px;
    position: absolute;
    left: 228px;
    top: 594px;
    object-fit: cover;
}

.rectangle-10 {
    border-radius: 20px;
    width: 163px;
    height: 265px;
    position: absolute;
    left: 48px;
    top: 417px;
    object-fit: cover;
}

.rectangle-12 {
    border-radius: 20px;
    width: 144px;
    height: 129px;
    position: absolute;
    left: 225px;
    top: 456px;
    object-fit: cover;
}

.rectangle-11 {
    border-radius: 20px;
    width: 36.3%;
    height: 216px;
    position: absolute;
    left: 55.5%;
    top: 233px;
    object-fit: cover;
}

/* ========================
   SECTION 5 - WEDDING DATE
   ======================== */
.section-wedding-date {
    background: linear-gradient(160deg, #3d080a 0%, #8b1111 50%, #3d080a 100%);
    padding: 60px 24px 70px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.section-wedding-date::before,
.section-wedding-date::after {
    content: '';
    display: block;
    height: 3px;
    background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.4), transparent);
    margin: 0 auto;
}

.section-wedding-date::before {
    margin-bottom: 0;
}

.section-wedding-date::after {
    margin-top: 0;
}

.wedding-date-content {
    max-width: 420px;
    margin: 0 auto;
}

.wedding-date-label {
    font-family: 'Arimo', sans-serif;
    font-size: 13px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.7);
    margin: 0 0 8px;
}

.wedding-date-title {
    font-family: 'Vujahday Script', cursive;
    text-align: center;
    font-size: 56px;
    font-weight: 400;
    color: #ffffff;
    margin: 0 0 16px;
    line-height: 1.1;
}

.wedding-date-divider {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-bottom: 32px;
}

.wedding-date-divider span:not(.diamond) {
    display: block;
    height: 1px;
    width: 60px;
    background: rgba(255, 255, 255, 0.4);
}

.diamond {
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
}

/* Countdown */
.countdown-wrapper {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-bottom: 36px;
}

.countdown-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 14px 16px 10px;
    min-width: 64px;
    backdrop-filter: blur(4px);
}

.count {
    font-family: 'Arimo', sans-serif;
    font-size: 32px;
    font-weight: 700;
    color: #ffffff;
    line-height: 1;
}

.count-label {
    font-family: 'Arimo', sans-serif;
    font-size: 10px;
    color: rgba(255, 255, 255, 0.65);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-top: 6px;
}

/* Date Info Cards */
.wedding-date-info {
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-bottom: 36px;
}

.date-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 14px;
    padding: 16px 18px;
    text-align: left;
    backdrop-filter: blur(6px);
}

.date-icon {
    font-size: 24px;
    line-height: 1;
    flex-shrink: 0;
    margin-top: 2px;
}

.date-card-text {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.date-card-text strong {
    font-family: 'Annapurna SIL', sans-serif;
    font-size: 15px;
    color: #ffffff;
    font-weight: 700;
}

.date-card-text span {
    font-family: 'Arimo', sans-serif;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.75);
    line-height: 1.5;
}

.maps-button {
    display: inline-block;
    background: #ffffff;
    color: #8b1111;
    font-family: 'Arimo', sans-serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.05em;
    padding: 14px 32px;
    border-radius: 50px;
    text-decoration: none;
    transition: background 0.2s, color 0.2s, transform 0.15s;
}

.maps-button:hover {
    background: #3d080a;
    color: #ffffff;
    transform: translateY(-2px);
}

/* ========================
   RSVP SECTION
   ======================== */
.section-rsvp {
    background: linear-gradient(160deg, #8b1111 0%, #3d080a 50%, #8b1111 100%);
    padding: 60px 24px 80px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.rsvp-content {
    max-width: 420px;
    margin: 0 auto;
}

.rsvp-title {
    font-family: 'Annapurna SIL', sans-serif;
    font-size: 48px;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 16px;
    line-height: 1.1;
}

.rsvp-divider {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-bottom: 32px;
}

.rsvp-divider span:not(.diamond) {
    display: block;
    height: 1px;
    width: 50px;
    background: rgba(255, 255, 255, 0.4);
}

.rsvp-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.rsvp-input {
    
    padding: 14px 18px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff;
    font-family: 'Arimo', sans-serif;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
}

.rsvp-input::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.rsvp-input:focus {
    border-color: rgba(255, 255, 255, 0.6);
}

.rsvp-select {
    width: 100%;
    padding: 14px 18px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff;
    font-family: 'Arimo', sans-serif;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
    text-align: left;
}

.rsvp-select:focus {
    border-color: rgba(255, 255, 255, 0.6);
}

.rsvp-kehadiran {
    display: flex;
    gap: 24px;
    justify-content: center;
    font-family: 'Arimo', sans-serif;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.8);
}

.rsvp-kehadiran label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.rsvp-kehadiran input[type="radio"] {
    accent-color: #ff4444;
    width: 16px;
    height: 16px;
}

.rsvp-textarea {
    
    padding: 14px 18px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff;
    font-family: 'Arimo', sans-serif;
    font-size: 14px;
    outline: none;
    resize: vertical;
    transition: border-color 0.2s;
}

.rsvp-textarea::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.rsvp-textarea:focus {
    border-color: rgba(255, 255, 255, 0.6);
}

.rsvp-button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 50px;
    background: #ffffff;
    color: #8b1111;
    font-family: 'Arimo', sans-serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: background 0.2s, color 0.2s, transform 0.15s;
}

.rsvp-button:hover {
    background: #3d080a;
    color: #ffffff;
    transform: translateY(-2px);
}

/* RSVP Additional Styles */
.rsvp-deadline-text {
    font-family: 'Arimo', sans-serif;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.7);
    text-align: center;
    margin-bottom: 12px;
}

.rsvp-message-text {
    font-family: 'Arimo', sans-serif;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.85);
    text-align: center;
    font-style: italic;
    margin-bottom: 16px;
    padding: 12px 16px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.12);
}

.rsvp-feedback {
    text-align: center;
    margin-top: 12px;
    font-family: 'Arimo', sans-serif;
    font-size: 14px;
    min-height: 20px;
}

.rsvp-success {
    color: #86efac;
}

.rsvp-error {
    color: #fca5a5;
}

.rsvp-list-wrapper {
    margin-top: 28px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.06);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.rsvp-list-title {
    font-family: 'Annapurna SIL', sans-serif;
    font-size: 16px;
    color: rgba(255, 255, 255, 0.85);
    text-align: center;
    margin: 0 0 16px;
    font-weight: 700;
}

.rsvp-list {
    max-height: 320px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.rsvp-list-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 14px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.08);
}

.rsvp-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.rsvp-item-content {
    flex: 1;
    min-width: 0;
}

.rsvp-item-name {
    font-family: 'Annapurna SIL', sans-serif;
    font-size: 14px;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 2px;
}

.rsvp-item-message {
    font-family: 'Arimo', sans-serif;
    font-size: 12px;
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
    line-height: 1.5;
    word-wrap: break-word;
}

.rsvp-count {
    text-align: center;
    font-family: 'Arimo', sans-serif;
    font-size: 12px;
    color: rgba(255, 255, 255, 0.55);
    margin-top: 14px;
}

.rsvp-empty {
    text-align: center;
    color: rgba(255, 255, 255, 0.5);
    font-size: 13px;
    padding: 24px 0;
    line-height: 1.8;
}

.rsvp-error-msg {
    text-align: center;
    color: #fca5a5;
    font-size: 13px;
    padding: 24px 0;
}

.rsvp-whatsapp {
    text-align: center;
    margin-top: 20px;
}

.rsvp-whatsapp-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: #25d366;
    color: #ffffff;
    font-family: 'Arimo', sans-serif;
    font-size: 14px;
    font-weight: 700;
    border-radius: 50px;
    text-decoration: none;
    transition: background 0.2s, transform 0.15s;
}

.rsvp-whatsapp-button:hover {
    background: #1da851;
    transform: translateY(-2px);
    color: #ffffff;
}

/* ========================
   FOOTER
   ======================== */
.site-footer {
    background: #1a0203;
    padding: 48px 24px 36px;
    text-align: center;
}

.footer-content {
    max-width: 420px;
    margin: 0 auto;
}

.footer-names {
    font-family: 'Vujahday Script', cursive;
    font-size: 48px;
    font-weight: 400;
    color: #ffffff;
    line-height: 1;
    margin-bottom: 16px;
}

.footer-divider {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-bottom: 20px;
}

.footer-divider span:not(.diamond) {
    display: block;
    height: 1px;
    width: 50px;
    background: rgba(255, 255, 255, 0.3);
}

.footer-tagline {
    font-family: 'Arimo', sans-serif;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.65);
    line-height: 1.8;
    margin: 0 0 20px;
}

.footer-date {
    font-family: 'Annapurna SIL', sans-serif;
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 0.15em;
    color: rgba(255, 255, 255, 0.85);
    margin: 0 0 28px;
}

.footer-copy {
    font-family: 'Arimo', sans-serif;
    font-size: 11px;
    color: rgba(255, 255, 255, 0.35);
    margin: 0;
    letter-spacing: 0.05em;
}

/* ========================
   FIX: Posisi responsif sisa elemen piksel tetap
   ======================== */
/* Section 2 nav bar */
.rectangle-4 {
    background: #3d080a;
    border-radius: 39px;
    width: 91%;
    height: 66px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 782px;
}

.group-2 {
    width: 76%;
    height: 40.99px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 795px;
    overflow: visible;
}

/* Bapak/Ibu teks - section 3 */
.bapak-sanusi-s-m-ibu-jubaedah-dari-london-utara {
    color: #ffffff;
    text-align: center;
    font-family: 'Arimo', sans-serif;
    font-size: 12px;
    line-height: 17px;
    font-weight: 400;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 382.72px;
    width: 57%;
    height: auto;
}

.bapak-sanusi-s-m-ibu-jubaedah-dari-london-utara2 {
    color: #ffffff;
    text-align: center;
    font-family: 'Arimo', sans-serif;
    font-size: 12px;
    line-height: 17px;
    font-weight: 400;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 695px;
    width: 57%;
    height: auto;
}

/* Foto pengantin - section 3 */
.rectangle-7 {
    border-radius: 30px;
    width: 72%;
    height: 279.74px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 153px;
    object-fit: cover;
}

.rectangle-8 {
    width: 70%;
    height: 82.44px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 350.3px;
    overflow: visible;
}

.rectangle-72 {
    border-radius: 30px;
    width: 72%;
    height: 279.74px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 461px;
    object-fit: cover;
}

.rectangle-82 {
    border-radius: 0px;
    width: 70%;
    height: 82.44px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 659px;
    overflow: visible;
}

/* Foto Love Story - section 4 */
.rectangle-9 {
    border-radius: 20px;
    width: 40.5%;
    height: 171px;
    position: absolute;
    left: 12%;
    top: 233px;
    object-fit: cover;
}

.rectangle-13 {
    border-radius: 20px;
    width: 34%;
    height: 171px;
    position: absolute;
    left: 56.7%;
    top: 594px;
    object-fit: cover;
}

.rectangle-10 {
    border-radius: 20px;
    width: 40.5%;
    height: 265px;
    position: absolute;
    left: 12%;
    top: 417px;
    object-fit: cover;
}

.rectangle-12 {
    border-radius: 20px;
    width: 35.8%;
    height: 129px;
    position: absolute;
    left: 56%;
    top: 456px;
    object-fit: cover;
}

/* Media query tambahan untuk layar lebih lebar */
@media screen and (min-width: 402px) {
    .house-java-m-1 {
        left: 51%;
    }

    .house-java-m-2 {
        left: 53%;
    }

    .afb-133-e-7-a-7-ec-4-a-6-d-b-886-ec-09-db-826-bcd-1-3 {
        left: 105%;
    }
}

@media screen and (max-width: 768px) {

    .cover-1,
    .section-2,
    .section-3,
    .section-4,
    .section-wedding-date,
    .section-rsvp {
        height: auto;
        min-height: 100svh;
    }

    .the-wedding-of,
    ._30-06-2026 {
        font-size: 20px;
    }

    .islan-aslan {
        font-size: 64px;
        line-height: 56px;
    }

    .countdown-wrapper {
        gap: 8px;
    }

    .countdown-box {
        min-width: 56px;
        padding: 12px 10px 8px;
    }

    .count {
        font-size: 26px;
    }

    .rsvp-title {
        font-size: 40px;
    }

    .rsvp-divider span:not(.diamond) {
        width: 40px;
    }

    .nav-label {
        font-size: 9px;
    }
}

/* ========================
   BOTTOM NAVIGATION
   ======================== */
.bottom-nav {
    display: none !important;
    position: fixed;
    bottom: 16px;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 448px;
    height: 64px;
    background: rgba(26, 2, 3, 0.92);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 32px;
    align-items: stretch;
    justify-content: space-around;
    z-index: 9999;
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.12);
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.5s ease, transform 0.5s ease;
}

.bottom-nav.active {
    opacity: 1;
    pointer-events: auto;
}

.nav-item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    text-decoration: none;
    color: rgba(255, 255, 255, 0.45);
    transition: color 0.25s, transform 0.2s;
    position: relative;
    padding: 8px 0 6px;
}

.nav-item::after {
    content: '';
    position: absolute;
    top: 0;
    left: 25%;
    width: 50%;
    height: 2px;
    background: #ff4444;
    border-radius: 0 0 3px 3px;
    transform: scaleX(0);
    transition: transform 0.25s;
}

.nav-item.active {
    color: #ffffff;
}

.nav-item.active::after {
    transform: scaleX(1);
}

.nav-item:hover {
    color: rgba(255, 255, 255, 0.85);
    transform: translateY(-2px);
}

.nav-item svg {
    width: 22px;
    height: 22px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.nav-label {
    font-family: 'Arimo', sans-serif;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

/* ========================
   DECORATIVE ANIMATIONS (CONTINUOUS)
   ======================== */

/* Gentle float up and down */
@keyframes floatY {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-14px); }
}

/* Float down */
@keyframes floatYdown {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(14px); }
}

/* Sway left-right */
@keyframes swayX {
    0%, 100% { transform: rotate(11.72deg) scale(-1, 1) translateX(0); }
    50%       { transform: rotate(11.72deg) scale(-1, 1) translateX(-12px); }
}

/* Gentle pulse + rotate */
@keyframes floatRotate1 {
    0%, 100% { transform: rotate(3.131deg) scale(1, 1) translateY(0); }
    50%       { transform: rotate(6deg) scale(1, 1) translateY(-10px); }
}

/* Rose bounce */
@keyframes roseBounce {
    0%, 100% { transform: rotate(5.268deg) scale(1, 1) translateY(0); }
    40%       { transform: rotate(3deg) scale(1, 1) translateY(-16px); }
    60%       { transform: rotate(7deg) scale(1, 1) translateY(-8px); }
}

/* Red rose 2 – subtle sway */
@keyframes roseSway2 {
    0%, 100% { transform: translateX(0) translateY(0); }
    33%       { transform: translateX(6px) translateY(-8px); }
    66%       { transform: translateX(-4px) translateY(-4px); }
}

/* Janur 2 drift */
@keyframes janurFloat2 {
    0%, 100% { transform: rotate(4.9deg) scale(1, 1) translate(0, 0); }
    50%       { transform: rotate(6.5deg) scale(1, 1) translate(-8px, -12px); }
}

/* Head text breathing effect */
@keyframes pulseOpacity {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.85; }
}

/* Apply animations continuously */
.janur-maroon-1 {
    animation: swayX 5s ease-in-out infinite;
}

.janur-maroon-2 {
    animation: janurFloat2 6s ease-in-out infinite;
}

.red-rose-1-1-1 {
    animation: roseBounce 7s ease-in-out infinite;
}

.red-rose-1-1-2 {
    animation: roseSway2 5.5s ease-in-out infinite;
}

.afb-133-e-7-a-7-ec-4-a-6-d-b-886-ec-09-db-826-bcd-1-1 {
    animation: floatRotate1 6s ease-in-out infinite;
}

/* Tambahkan animasi ke elemen lain agar hidup */
.javanese-paperize-7-1 { animation: floatY 6s ease-in-out infinite; }
.javanese-paperize-7-2 { animation: floatYdown 7s ease-in-out infinite; }
.house-java-m-1 { animation: floatYdown 8s ease-in-out infinite; }
.house-java-m-2 { animation: floatY 7s ease-in-out infinite; }
.head { animation: pulseOpacity 4s ease-in-out infinite; }

    </style>
</head>

<body class="locked">
    <div class="main-container">
        
        <!-- COVER LOCKED WRAPPER -->
        <div id="cover-wrapper" class="cover-wrapper">
            <div id="cover" class="cover-1">
               <img loading="lazy"
    class="rectangle-1"
    src="{{ storage_url_with_fallback($invitation->gallery_cover, asset('images/default-cover.jpg')) }}"
    alt="Cover">
                <div class="head">
                    <div class="the-wedding-of">The Wedding Of</div>
                    <div class="frame-1">
                        <div class="islan-aslan">{{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }}</div>
                    </div>
                    <div class="_30-06-2026">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale("id")->translatedFormat("l, d F Y") }}</div>
                </div>
                <div class="rectangle-5"></div>
                <div class="buka-undangan" id="open-invitation">BUKA UNDANGAN</div>
                <img loading="lazy" class="javanese-paperize-7-1" src="{{ url('template-assets/' . $invitation->template->slug . '/images/javanese-paperize-7-10.png') }}" />
                <img loading="lazy" class="javanese-paperize-7-2" src="{{ url('template-assets/' . $invitation->template->slug . '/images/javanese-paperize-7-20.png') }}" />
            </div>
        </div>

        <div id="ayat" class="section-2">
            <img loading="lazy" class="rectangle-6" src="{{ url('template-assets/' . $invitation->template->slug . '/images/rectangle-60.png') }}" />
            <img loading="lazy" class="house-java-m-1" src="{{ url('template-assets/' . $invitation->template->slug . '/images/house-java-m-10.png') }}" />
            <img loading="lazy" class="afb-133-e-7-a-7-ec-4-a-6-d-b-886-ec-09-db-826-bcd-1-1"
                src="{{ url('template-assets/' . $invitation->template->slug . '/images/afb-133-e-7-a-7-ec-4-a-6-d-b-886-ec-09-db-826-bcd-1-10.png') }}" />
            <img loading="lazy" class="rectangle-14" src="{{ url('template-assets/' . $invitation->template->slug . '/images/rectangle-14.png') }}" />
            <img loading="lazy" class="red-rose-1-1-1" src="{{ url('template-assets/' . $invitation->template->slug . '/images/red-rose-1-1-10.png') }}" />
            <div class="assets-dreamy-javanese-1-1"></div>
            <img loading="lazy" class="janur-maroon-1" src="{{ url('template-assets/' . $invitation->template->slug . '/images/janur-maroon-10.png') }}" />
            <img loading="lazy" class="javanese-paperize-7-3" src="{{ url('template-assets/' . $invitation->template->slug . '/images/javanese-paperize-7-30.png') }}" />
<img loading="lazy" class="group-4" src="{{ url('template-assets/' . $invitation->template->slug . '/images/group-40.svg') }}" />
            <div
                class="dan-di-antara-tanda-tanda-kebesaran-nya-ialah-dia-menciptakan-pasangan-untukmu-agar-kamu-merasa-tentram-qs-ar-rum-21">
                 {!! nl2br(e(str_replace('(', "\n(", $invitation->wedding_quote))) !!}
            </div>
            
        </div>
        
        <div id="pengantin" class="section-3">
            <img loading="lazy" class="javanese-paperize-2-1-1" src="{{ url('template-assets/' . $invitation->template->slug . '/images/javanese-paperize-2-1-10.png') }}" />
            
            <img loading="lazy" class="javanese-paperize-7-4" src="{{ url('template-assets/' . $invitation->template->slug . '/images/javanese-paperize-7-40.png') }}" />
            <img loading="lazy" class="janur-maroon-2" src="{{ url('template-assets/' . $invitation->template->slug . '/images/janur-maroon-20.png') }}" />
            <img loading="lazy" class="red-rose-1-1-2" src="{{ url('template-assets/' . $invitation->template->slug . '/images/red-rose-1-1-20.png') }}" />
            <img loading="lazy" class="rectangle-7" src="{{ $invitation->foto_wanita ? storage_url($invitation->foto_wanita) : url('template-assets/' . $invitation->template->slug . '/images/rectangle-70.png') }}" />
            <img loading="lazy" class="rectangle-8" src="{{ url('template-assets/' . $invitation->template->slug . '/images/rectangle-80.svg') }}" />
            <div class="adinda-mawaria">{{ $invitation->groom_name }}</div>
            <div class="bapak-sanusi-s-m-ibu-jubaedah-dari-london-utara">
                {{ $invitation->groom_child_order_text ? 'Putra ' . $invitation->groom_child_order_text . ' dari' : 'Putra dari' }} Bapak {{ $invitation->groom_father_name ?? 'Fulan' }} &amp; Ibu {{ $invitation->groom_mother_name ?? 'Fulana' }}
                <br />
                {{ $invitation->groom_username_instagram ? 'dari ' . $invitation->groom_username_instagram : '' }}
            </div>
            <img loading="lazy" class="rectangle-72" src="{{ $invitation->foto_pria ? storage_url($invitation->foto_pria) : url('template-assets/' . $invitation->template->slug . '/images/rectangle-71.png') }}" />
            <img loading="lazy" class="rectangle-82" src="{{ url('template-assets/' . $invitation->template->slug . '/images/rectangle-81.svg') }}" />
            <div class="adinda-mawaria2">{{ $invitation->bride_name }}</div>
            <div class="bapak-sanusi-s-m-ibu-jubaedah-dari-london-utara2">
                {{ $invitation->bride_child_order_text ? 'Putri ' . $invitation->bride_child_order_text . ' dari' : 'Putri dari' }} Bapak {{ $invitation->bride_father_name ?? 'Surya' }} &amp; Ibu {{ $invitation->bride_mother_name ?? 'Dewi' }}
                <br />
                {{ $invitation->bride_username_instagram ? 'dari ' . $invitation->bride_username_instagram : '' }}
            </div>
            <img loading="lazy" class="afb-133-e-7-a-7-ec-4-a-6-d-b-886-ec-09-db-826-bcd-1-2"
                src="{{ url('template-assets/' . $invitation->template->slug . '/images/afb-133-e-7-a-7-ec-4-a-6-d-b-886-ec-09-db-826-bcd-1-20.png') }}" />
            <img loading="lazy" class="afb-133-e-7-a-7-ec-4-a-6-d-b-886-ec-09-db-826-bcd-1-3"
                src="{{ url('template-assets/' . $invitation->template->slug . '/images/afb-133-e-7-a-7-ec-4-a-6-d-b-886-ec-09-db-826-bcd-1-30.png') }}" />
        </div>
        
        <div id="lovestory" class="section-4">
           
             <div class="wedding-date-content mvb" style="z-index: 10;">
                <div class="fade-in">
                
                    <h2 class="wedding-date-title serif-font">Momen Bahagia</h2>
                    <div class="wedding-date-divider">
                        <span></span><span class="diamond">&#10022;</span><span></span>
                    </div>
                </div>
                @php
                    $galleriesPerPage = 6;
                    $currentPage = request('page', 1);
                    $totalGalleries = $invitation->galleries->count();
                    $paginatedGalleries = $invitation->galleries->forPage($currentPage, $galleriesPerPage);
                    $totalPages = ceil($totalGalleries / $galleriesPerPage);
                @endphp

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; padding: 0 8px; margin-bottom:30px;">
                    @forelse ($paginatedGalleries as $photo)
                        <a href="{{ storage_url($photo->image) }}" data-fancybox="gallery" style="display: block; border-radius: 12px; overflow: hidden;">
                            <img loading="lazy" src="{{ storage_url($photo->image) }}" 
                                 style="width: 100%; height: 180px; object-fit: cover; display: block; border-radius: 12px;" 
                                 alt="Gallery">
                        </a>
                    @empty
                        <div style="text-align: center; color: rgba(255,255,255,0.6); padding: 40px; grid-column: 1 / -1;">
                            Belum ada foto galeri
                        </div>
                    @endforelse
                </div>

                @if($totalPages > 1)
                <div class="gallery-pagination" style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-bottom: 20px;">
                    @for ($i = 1; $i <= $totalPages; $i++)
                        @if ($i == $currentPage)
                            <span style="width: 32px; height: 32px; background: #ffffff; color: #8b1111; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: 'Arimo', sans-serif; font-size: 13px; font-weight: 700;">{{ $i }}</span>
                        @else
                            <a href="?page={{ $i }}" style="width: 32px; height: 32px; background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.7); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: 'Arimo', sans-serif; font-size: 13px; text-decoration: none; transition: all 0.2s;">{{ $i }}</a>
                        @endif
                    @endfor
                </div>
                @endif
            </div>
            
        </div>

        <!-- SECTION 5 - WEDDING DATE -->
        <section id="tanggal" class="section-wedding-date">
            <div class="wedding-date-content">
                <p class="wedding-date-label">Hari Pernikahan</p>
                <h2 class="wedding-date-title">{{ $invitation->groom_nickname }} &amp; {{ $invitation->bride_nickname }}</h2>
                <div class="wedding-date-divider">
                    <span></span><span class="diamond">&#10022;</span><span></span>
                </div>
                <div class="countdown-wrapper">
                    <div class="countdown-box">
                        <span class="count" id="days">00</span>
                        <span class="count-label">Hari</span>
                    </div>
                    <div class="countdown-box">
                        <span class="count" id="hours">00</span>
                        <span class="count-label">Jam</span>
                    </div>
                    <div class="countdown-box">
                        <span class="count" id="minutes">00</span>
                        <span class="count-label">Menit</span>
                    </div>
                    <div class="countdown-box">
                        <span class="count" id="seconds">00</span>
                        <span class="count-label">Detik</span>
                    </div>
                </div>
                <div class="wedding-date-info">
                    <div class="date-card">
                        <div class="date-icon">&#128197;</div>
                        <div class="date-card-text">
                            <strong>Akad Nikah</strong>
                            <span>{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale("id")->translatedFormat("l, d F Y") }}</span>
                            <span>Pukul {{ $invitation->akad_time ?? '08.00' }} - {{ $invitation->akad_time_end ?? '08.00' }}</span>
                        </div>
                    </div>
                    <div class="date-card">
                        <div class="date-icon">&#128146;</div>
                        <div class="date-card-text">
                            <strong>Resepsi</strong>
                            <span>{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale("id")->translatedFormat("l, d F Y") }}</span>
                            <span>Pukul {{ $invitation->resepsi_time ?? '11.00' }} - {{ $invitation->resepsi_time_end ?? '16.00' }} </span>
                        </div>
                    </div>
                    <div class="date-card">
                        <div class="date-icon">&#128205;</div>
                        <div class="date-card-text">
                            <strong>Lokasi</strong>
                            <span>{{ $invitation->resepsi_location ?? $invitation->akad_location ?? 'Gedung Serbaguna' }}</span>
                            <span>{{ $invitation->resepsi_address ?? $invitation->akad_address ?? 'Jl. Contoh No. 1, Jakarta' }}</span>
                        </div>
                    </div>
                </div>
                <a class="maps-button" href="{{ $invitation->resepsi_maps ?: ($invitation->akad_maps ?: '#') }}" target="_blank">Lihat Lokasi di Maps</a>
            </div>
        </section>

        <!-- SECTION 6 - RSVP -->
        @if($invitation->enable_rsvp === 1)
        <section id="rsvp" class="section-rsvp">
            <div class="rsvp-content">
                <h2 class="rsvp-title">Ucapan dan Doa</h2>
                <div class="rsvp-divider">
                    <span></span><span class="diamond">&#10022;</span><span></span>
                </div>

                @if($invitation->rsvp_deadline)
                <div class="rsvp-deadline-text">
                    Batas RSVP: {{ \Carbon\Carbon::parse($invitation->rsvp_deadline)->format('d/m/Y') }}
                </div>
                @endif

                @if($invitation->rsvp_message)
                <div class="rsvp-message-text">
                    "{{ $invitation->rsvp_message }}"
                </div>
                @endif

                <form id="rsvpForm" class="rsvp-form">
                    @csrf
                    <input type="text" class="rsvp-input" placeholder="Nama Lengkap" name="name" required>
                    <select class="rsvp-select" name="attending" required>
                        <option value="" disabled selected>Konfirmasi Kehadiran</option>
                        <option value="1">Hadir</option>
                        <option value="2">Tidak Hadir</option>
                        <option value="3">Masih Ragu</option>
                    </select>
                    <textarea id="rsvpMessageInput" class="rsvp-textarea" placeholder="Pesan / Doa (Opsional)" name="message" rows="3"></textarea>
                    <button type="submit" class="rsvp-button" id="rsvpButton">
                        <span id="buttonText">Kirim Konfirmasi</span>
                    </button>
                </form>

                <div id="rsvpMessage" class="rsvp-feedback"></div>

                <div class="rsvp-list-wrapper">
                    <h4 class="rsvp-list-title">Tinggalkan kami doa terbaik anda untuk momen bahagia kami</h4>
                    <div id="rsvpList" class="rsvp-list"></div>
                    <div class="rsvp-count">
                        ({{ $invitation->rsvps->count() }} Ucapan & Doa Restu)
                    </div>
                </div>

                @if($invitation->rsvp_whatsapp)
                <div class="rsvp-whatsapp">
                    <a href="https://wa.me/{{ $invitation->rsvp_whatsapp }}?text=Halo,%20saya%20ingin%20konfirmasi%20RSVP%20untuk%20undangan%20pernikahan." target="_blank" class="rsvp-whatsapp-button">
                        Konfirmasi via WhatsApp
                    </a>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- FOOTER -->
        <footer class="site-footer">
            <div class="footer-content">
                <div class="footer-names">{{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }}</div>
                <div class="footer-divider">
                    <span></span><span class="diamond">&#10022;</span><span></span>
                </div>
                <p class="footer-tagline">Kami mengundang Bapak/Ibu/Saudara/i untuk hadir<br>dan memberikan doa restu.
                </p>
                <p class="footer-date">30 &middot; 06 &middot; 2026</p>
                <p class="footer-copy">&copy; {{ date('Y') }} {{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }} Wedding. Made with &#10084;&#65039;</p>
            </div>
        </footer>

        <!-- BOTTOM NAVIGATION (TABLER ICONS) -->
        <nav class="bottom-nav" id="bottom-nav">
         
            <a href="#ayat" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M12 3l1.9 5.8H20l-4.9 3.6L17 18l-5-3.8L7 18l1.9-5.6L4 8.8h6.1z"/></svg>
                <span class="nav-label">Ayat</span>
            </a>
            <a href="#pengantin" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M19.5 12.572L12 20l-7.5-7.428A5 5 0 1 1 12 5.572a5 5 0 1 1 7.5 7z"/></svg>
                <span class="nav-label">Pengantin</span>
            </a>
            <a href="#lovestory" class="nav-item">
                <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="12" cy="12" r="3"/></svg>
                <span class="nav-label">Gallery</span>
            </a>
            <a href="#tanggal" class="nav-item">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 9h18M8 3v4M16 3v4"/></svg>
                <span class="nav-label">Tanggal</span>
            </a>
            <a href="#rsvp" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M3 7l9 6 9-6"/><rect x="3" y="5" width="18" height="14" rx="2"/></svg>
                <span class="nav-label">RSVP</span>
            </a>
        </nav>

    </div>

    <x-music-player :invitation="$invitation" />

    <script>
        // Countdown Timer
        var weddingDate = new Date('{{ \Carbon\Carbon::parse($invitation->wedding_date)->format("Y-m-d") }}T08:00:00');
        function updateCountdown() {
            var now = new Date();
            var diff = weddingDate - now;
            if (diff <= 0) {
                ['days','hours','minutes','seconds'].forEach(function(id){
                    document.getElementById(id).textContent = '00';
                });
                return;
            }
            document.getElementById('days').textContent    = String(Math.floor(diff / 86400000)).padStart(2,'0');
            document.getElementById('hours').textContent   = String(Math.floor((diff % 86400000) / 3600000)).padStart(2,'0');
            document.getElementById('minutes').textContent = String(Math.floor((diff % 3600000) / 60000)).padStart(2,'0');
            document.getElementById('seconds').textContent = String(Math.floor((diff % 60000) / 1000)).padStart(2,'0');
        }
        updateCountdown();
        setInterval(updateCountdown, 1000);

        // Open Invitation Logic
        document.getElementById('open-invitation').addEventListener('click', function(){
            document.getElementById('cover-wrapper').classList.add('hide-cover');
            document.body.classList.remove('locked');
            document.getElementById('bottom-nav').classList.add('active');
        });

        // Bottom Nav Smooth Scroll & Active Logic
        var navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(function(item){
            item.addEventListener('click', function(e){
                e.preventDefault();
                
                // Jika cover belum dibuka, buka covernya
                if (document.body.classList.contains('locked')) {
                    document.getElementById('cover-wrapper').classList.add('hide-cover');
                    document.body.classList.remove('locked');
                    document.getElementById('bottom-nav').classList.add('active');
                }

                var targetId = this.getAttribute('href').replace('#', '');
                var targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop,
                        behavior: 'smooth'
                    });
                }

                navItems.forEach(function(n){ n.classList.remove('active'); });
                item.classList.add('active');
            });
        });

        // Auto sync active nav on scroll
        var sections = document.querySelectorAll('#cover, #ayat, #pengantin, #lovestory, #tanggal, #rsvp');
        var observer = new IntersectionObserver(function(entries){
            entries.forEach(function(entry){
                if (entry.isIntersecting) {
                    var id = entry.target.id;
                    navItems.forEach(function(n){
                        if (n.getAttribute('href') === `#${id}`) {
                            n.classList.add('active');
                        } else {
                            n.classList.remove('active');
                        }
                    });
                }
            });
        }, { threshold: 0.5 });
        
        sections.forEach(function(sec){ observer.observe(sec); });

        // RSVP Functionality
        const invitationId = "{{ $invitation->id }}";

        function renderRsvpList(rsvps) {
            const list = document.getElementById('rsvpList');

            if (!rsvps || rsvps.length === 0) {
                list.innerHTML = `
                    <div class="rsvp-empty">
                        Belum ada ucapan 🥲<br>Jadilah yang pertama memberi doa 💖
                    </div>
                `;
                return;
            }

            list.innerHTML = rsvps.map(rsvp => `
                <div class="rsvp-list-item">
                    <img loading="lazy" src="{{ asset('tempelate/user_default.jpg') }}" alt="User" class="rsvp-avatar">
                    <div class="rsvp-item-content">
                        <p class="rsvp-item-name">${rsvp.name}</p>
                        <p class="rsvp-item-message">${rsvp.message || ''}</p>
                    </div>
                </div>
            `).join('');
        }

        function updateRsvpList() {
            fetch(`/invitation/${invitationId}/rsvps`)
                .then(res => res.json())
                .then(data => renderRsvpList(data))
                .catch(err => {
                    console.error(err);
                    document.getElementById('rsvpList').innerHTML = `
                        <div class="rsvp-error-msg">Gagal memuat data RSVP 😢</div>
                    `;
                });
        }

        const rsvpForm = document.getElementById('rsvpForm');
        const rsvpButton = document.getElementById('rsvpButton');
        const buttonText = document.getElementById('buttonText');

        if (rsvpForm) {
            rsvpForm.addEventListener('submit', function(e) {
                e.preventDefault();

                rsvpButton.disabled = true;
                buttonText.innerText = "Mengirim...";

                const formData = new FormData(rsvpForm);

                fetch("{{ route('rsvp.store', $invitation->id) }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': rsvpForm.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        rsvpForm.reset();
                        const msgEl = document.getElementById('rsvpMessage');
                        msgEl.innerText = data.message || "RSVP berhasil dikirim!";
                        msgEl.className = 'rsvp-feedback rsvp-success';
                        updateRsvpList();
                    } else {
                        const msgEl = document.getElementById('rsvpMessage');
                        msgEl.innerText = data.message || "Terjadi kesalahan.";
                        msgEl.className = 'rsvp-feedback rsvp-error';
                    }
                })
                .catch(error => {
                    console.error(error);
                    const msgEl = document.getElementById('rsvpMessage');
                    msgEl.innerText = "Terjadi kesalahan saat mengirim RSVP.";
                    msgEl.className = 'rsvp-feedback rsvp-error';
                })
                .finally(() => {
                    rsvpButton.disabled = false;
                    buttonText.innerText = "Kirim Konfirmasi";
                });
            });

            setInterval(updateRsvpList, 3000);
            updateRsvpList();
        }

    // Lazy load images (skip SVGs and cover images)
    document.addEventListener('DOMContentLoaded', function() {
        var images = document.querySelectorAll('img');
        var coverImg = document.querySelector('.cover-1 img');
        images.forEach(function(img) {
            if ((img !== coverImg) && (img.src && !img.src.includes('.svg'))) {
                img.loading = 'lazy';
            }
        });
    });

    // Auto resize textarea
    const rsvpTextarea = document.getElementById('rsvpMessageInput');
    if (rsvpTextarea) {
        rsvpTextarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 300) + 'px';
        });
    }

    @if(($invitation->enable_love_story ?? true) && !empty($invitation->love_story))
    @php
        $loveStories = is_array($invitation->love_story) ? $invitation->love_story : json_decode($invitation->love_story, true);
    @endphp
    @if(!empty($loveStories[0]['title']) || !empty($loveStories[0]['story']))
    <section class="py-20 px-6 bg-white text-center" id="lovestory">
        <h2 class="text-4xl font-serif text-gray-800 mb-4">Love Story</h2>
        <div class="max-w-2xl mx-auto space-y-12">
            @foreach($loveStories as $index => $story)
            <div class="flex flex-col md:flex-row gap-6 items-center {{ $index < count($loveStories) - 1 ? 'pb-12 border-b border-gray-200' : '' }}">
                @if(!empty($story['photo']))
                <img src="{{ storage_url($story['photo']) }}" alt="{{ $story['title'] ?? 'Story Photo' }}" loading="lazy" class="w-full md:w-32 h-32 object-cover rounded-lg flex-shrink-0">
                @endif
                <div class="text-left flex-1">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $story['title'] ?? '' }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $story['story'] ?? '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
    @endif

    @if($invitation->enable_gift == 1 && $invitation->gifts->count())
    <section class="py-20 px-6 bg-gray-50 text-center" id="gift">
        <h2 class="text-4xl font-serif text-gray-800 mb-4">Wedding Gift</h2>
        <div class="max-w-xl mx-auto space-y-6">
            @foreach($invitation->gifts as $gift)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $gift->bank }}</h3>
                <p class="text-2xl font-bold text-blue-800 mb-1">{{ $gift->number }}</p>
                <p class="text-sm text-gray-500 mb-3">A/N: {{ $gift->name }}</p>
                <button onclick="copyText('{{ $gift->number }}')" class="bg-blue-800 text-white px-4 py-2 rounded-full text-xs font-bold">Salin</button>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    @if(($invitation->enable_video ?? true) && !empty($invitation->video_link))
    @php
        preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $invitation->video_link, $ytVideoMatches);
        $youtubeVideoId = $ytVideoMatches['id'] ?? '';
    @endphp
    @if($youtubeVideoId)
    <section class="py-20 px-6 bg-white text-center" id="video">
        <h2 class="text-4xl font-serif text-gray-800 mb-4">Video Pernikahan</h2>
        <div class="max-w-2xl mx-auto">
            <div class="relative aspect-video rounded-xl overflow-hidden bg-black/10 cursor-pointer" data-fancybox="video" data-src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $youtubeVideoId }}&controls=1&modestbranding=1&rel=0">
                <img src="https://img.youtube.com/vi/{{ $youtubeVideoId }}/hqdefault.jpg" alt="Video Pernikahan" class="w-full h-full object-cover">
                <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                    <span class="material-symbols-outlined text-white text-5xl">play_circle</span>
                </div>
            </div>
        </div>
    </section>
    @else
    <section class="py-20 px-6 bg-white text-center" id="video">
        <h2 class="text-4xl font-serif text-gray-800 mb-4">Video Pernikahan</h2>
        <div class="max-w-2xl mx-auto">
            <video controls class="w-full rounded-xl">
                <source src="{{ storage_url($invitation->video_link) }}" type="video/mp4">
            </video>
        </div>
    </section>
    @endif
    @endif
</script>
</body>

</html>
