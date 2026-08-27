@php
    $map = [
        'draft'     => ['label' => 'Draft',        'class' => 'bg-secondary'],
        'published' => ['label' => 'Terbit',       'class' => 'bg-success'],
        'expired'   => ['label' => 'Kedaluwarsa',  'class' => 'bg-warning text-dark'],
        'trash'     => ['label' => 'Sampah',       'class' => 'bg-danger'],
    ];

    $config = $map[$status] ?? ['label' => ucfirst($status), 'class' => 'bg-light text-dark'];
@endphp

<span class="badge {{ $config['class'] }}">{{ $config['label'] }}</span>
