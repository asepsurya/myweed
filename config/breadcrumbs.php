<?php

return [
    'dashboard' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
    ],
    'dashboard.user' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Pasangan Saya', 'icon' => null],
    ],
    'invitation.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Pasangan Saya', 'icon' => 'bi-heart'],
    ],
    'invitation.create' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Pasangan Saya', 'icon' => 'bi-heart', 'route' => 'invitation.index'],
        ['label' => 'Buat Undangan', 'icon' => null],
    ],
    'invitation.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Pasangan Saya', 'icon' => 'bi-heart', 'route' => 'invitation.index'],
        ['label' => 'Edit Undangan', 'icon' => null],
    ],
    'invitation.detail' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Pasangan Saya', 'icon' => 'bi-heart', 'route' => 'invitation.index'],
        ['label' => 'Detail Undangan', 'icon' => null],
    ],
    'weeding-plan.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Rencana Pernikahan', 'icon' => 'bi-calendar-check'],
    ],
    'weeding-plan.create' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Rencana Pernikahan', 'icon' => 'bi-calendar-check', 'route' => 'weeding-plan.index'],
        ['label' => 'Tambah Tugas', 'icon' => null],
    ],
    'weeding-plan.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Rencana Pernikahan', 'icon' => 'bi-calendar-check', 'route' => 'weeding-plan.index'],
        ['label' => 'Edit Tugas', 'icon' => null],
    ],
    'budget.dashboard' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Anggaran', 'icon' => 'bi-calculator'],
    ],
    'budget.category.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Anggaran', 'icon' => 'bi-calculator', 'route' => 'budget.dashboard'],
        ['label' => 'Kategori', 'icon' => null],
    ],
    'budget.category.create' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Anggaran', 'icon' => 'bi-calculator', 'route' => 'budget.dashboard'],
        ['label' => 'Kategori', 'icon' => 'bi-tag', 'route' => 'budget.category.index'],
        ['label' => 'Tambah Kategori', 'icon' => null],
    ],
    'budget.category.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Anggaran', 'icon' => 'bi-calculator', 'route' => 'budget.dashboard'],
        ['label' => 'Kategori', 'icon' => 'bi-tag', 'route' => 'budget.category.index'],
        ['label' => 'Edit Kategori', 'icon' => null],
    ],
    'budget.expense.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Anggaran', 'icon' => 'bi-calculator', 'route' => 'budget.dashboard'],
        ['label' => 'Pengeluaran', 'icon' => null],
    ],
    'budget.expense.create' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Anggaran', 'icon' => 'bi-calculator', 'route' => 'budget.dashboard'],
        ['label' => 'Pengeluaran', 'icon' => 'bi-receipt', 'route' => 'budget.expense.index'],
        ['label' => 'Tambah Pengeluaran', 'icon' => null],
    ],
    'budget.expense.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Anggaran', 'icon' => 'bi-calculator', 'route' => 'budget.dashboard'],
        ['label' => 'Pengeluaran', 'icon' => 'bi-receipt', 'route' => 'budget.expense.index'],
        ['label' => 'Edit Pengeluaran', 'icon' => null],
    ],
    'budget.payment.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Anggaran', 'icon' => 'bi-calculator', 'route' => 'budget.dashboard'],
        ['label' => 'Pembayaran Vendor', 'icon' => null],
    ],
    'budget.payment.create' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Anggaran', 'icon' => 'bi-calculator', 'route' => 'budget.dashboard'],
        ['label' => 'Pembayaran Vendor', 'icon' => 'bi-calendar-check', 'route' => 'budget.payment.index'],
        ['label' => 'Tambah Pembayaran', 'icon' => null],
    ],
    'budget.payment.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Anggaran', 'icon' => 'bi-calculator', 'route' => 'budget.dashboard'],
        ['label' => 'Pembayaran Vendor', 'icon' => 'bi-calendar-check', 'route' => 'budget.payment.index'],
        ['label' => 'Edit Pembayaran', 'icon' => null],
    ],
    'savings.dashboard' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Tabungan', 'icon' => 'bi-piggy-bank'],
    ],
    'savings.goal.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Tabungan', 'icon' => 'bi-piggy-bank', 'route' => 'savings.dashboard'],
        ['label' => 'Target Tabungan', 'icon' => null],
    ],
    'savings.goal.create' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Tabungan', 'icon' => 'bi-piggy-bank', 'route' => 'savings.dashboard'],
        ['label' => 'Target Tabungan', 'icon' => 'bi-bullseye', 'route' => 'savings.goal.index'],
        ['label' => 'Tambah Target', 'icon' => null],
    ],
    'savings.goal.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Tabungan', 'icon' => 'bi-piggy-bank', 'route' => 'savings.dashboard'],
        ['label' => 'Target Tabungan', 'icon' => 'bi-bullseye', 'route' => 'savings.goal.index'],
        ['label' => 'Edit Target', 'icon' => null],
    ],
    'savings.contribution.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Tabungan', 'icon' => 'bi-piggy-bank', 'route' => 'savings.dashboard'],
        ['label' => 'Ledger Setoran', 'icon' => null],
    ],
    'savings.contribution.create' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Tabungan', 'icon' => 'bi-piggy-bank', 'route' => 'savings.dashboard'],
        ['label' => 'Ledger Setoran', 'icon' => 'bi-journal-text', 'route' => 'savings.contribution.index'],
        ['label' => 'Tambah Setoran', 'icon' => null],
    ],
    'savings.contribution.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Tabungan', 'icon' => 'bi-piggy-bank', 'route' => 'savings.dashboard'],
        ['label' => 'Ledger Setoran', 'icon' => 'bi-journal-text', 'route' => 'savings.contribution.index'],
        ['label' => 'Edit Setoran', 'icon' => null],
    ],
    'savings.automation.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Tabungan', 'icon' => 'bi-piggy-bank', 'route' => 'savings.dashboard'],
        ['label' => 'Otomatisasi', 'icon' => null],
    ],
    'savings.projection' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Tabungan', 'icon' => 'bi-piggy-bank', 'route' => 'savings.dashboard'],
        ['label' => 'Proyeksi', 'icon' => null],
    ],
    'rsvp.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Ucapan & Doa', 'icon' => 'bi-clipboard-check'],
    ],
    'documentation.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Dokumentasi', 'icon' => 'bi-book'],
    ],
    'tema.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Tema & Tampilan', 'icon' => 'bi-palette'],
    ],
    'financial-overview.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Perencanaan & Keuangan', 'icon' => 'bi-folder', 'route' => null],
        ['label' => 'Ikhtisar Keuangan', 'icon' => 'bi-bar-chart-line'],
    ],
    'rsvp.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Ucapan & Doa', 'icon' => 'bi-clipboard-check'],
    ],
    'music.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Musik Undangan', 'icon' => 'bi-music-note-list'],
    ],
    'music.create' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Musik Undangan', 'icon' => 'bi-music-note-list', 'route' => 'music.index'],
        ['label' => 'Tambah Musik', 'icon' => null],
    ],
    'music.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Musik Undangan', 'icon' => 'bi-music-note-list', 'route' => 'music.index'],
        ['label' => 'Edit Musik', 'icon' => null],
    ],
    'subscription-plans.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
        ['label' => 'Paket & Harga', 'icon' => 'bi-tags'],
    ],
    'subscription-plans.create' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
        ['label' => 'Paket & Harga', 'icon' => 'bi-tags', 'route' => 'subscription-plans.index'],
        ['label' => 'Tambah Paket', 'icon' => null],
    ],
    'subscription-plans.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
        ['label' => 'Paket & Harga', 'icon' => 'bi-tags', 'route' => 'subscription-plans.index'],
        ['label' => 'Edit Paket', 'icon' => null],
    ],
    'coupons.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
        ['label' => 'Kupon Promo', 'icon' => 'bi-ticket-perforated'],
    ],
    'coupons.create' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
        ['label' => 'Kupon Promo', 'icon' => 'bi-ticket-perforated', 'route' => 'coupons.index'],
        ['label' => 'Tambah Kupon', 'icon' => null],
    ],
    'coupons.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
        ['label' => 'Kupon Promo', 'icon' => 'bi-ticket-perforated', 'route' => 'coupons.index'],
        ['label' => 'Edit Kupon', 'icon' => null],
    ],
    'promotions.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
        ['label' => 'Promosi', 'icon' => 'bi-megaphone'],
    ],
    'promotions.create' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
        ['label' => 'Promosi', 'icon' => 'bi-megaphone', 'route' => 'promotions.index'],
        ['label' => 'Tambah Promosi', 'icon' => null],
    ],
    'promotions.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
        ['label' => 'Promosi', 'icon' => 'bi-megaphone', 'route' => 'promotions.index'],
        ['label' => 'Edit Promosi', 'icon' => null],
    ],
    'user.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
        ['label' => 'Daftar Pengguna', 'icon' => 'bi-people'],
    ],
    'settings.env' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
        ['label' => 'Pengaturan .env', 'icon' => 'bi-sliders'],
    ],
    'template-creator.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Template Creator', 'icon' => 'bi-stars'],
    ],
    'template-creator.create' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Template Creator', 'icon' => 'bi-stars', 'route' => 'template-creator.index'],
        ['label' => 'Buat Template', 'icon' => null],
    ],
    'template-creator.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Template Creator', 'icon' => 'bi-stars', 'route' => 'template-creator.index'],
        ['label' => 'Edit Template', 'icon' => null],
    ],
    'tempelate.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Tema & Tampilan', 'icon' => 'bi-palette'],
    ],
    'categories.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Kategori', 'icon' => 'bi-tag'],
    ],
    'gift.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Hadiah', 'icon' => 'bi-gift'],
    ],
    'payments.index' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard'],
        ['label' => 'Pembayaran', 'icon' => 'bi-credit-card'],
    ],
    'profile.edit' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Profil', 'icon' => 'bi-person'],
    ],
    'payment.success' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Pembayaran Berhasil', 'icon' => 'bi-check-circle'],
    ],
    'payment.pending' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Pembayaran Pending', 'icon' => 'bi-clock'],
    ],
    'payment.failed' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-door', 'route' => 'dashboard.user'],
        ['label' => 'Pembayaran Gagal', 'icon' => 'bi-x-circle'],
    ],
];
