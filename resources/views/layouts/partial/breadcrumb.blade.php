@php
    $breadcrumbs = get_breadcrumbs();
@endphp

@if(!empty($breadcrumbs) && count($breadcrumbs) > 1)
    <div class="ev-breadcrumb-wrapper mb-4">
        <nav aria-label="Breadcrumb">
            <ol class="breadcrumb ev-breadcrumb align-items-center">
                @foreach($breadcrumbs as $crumb)
                    @if($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">
                            @if(!empty($crumb['icon']))
                                <i class="bi {{ $crumb['icon'] }} me-1"></i>
                            @endif
                            {{ $crumb['label'] }}
                        </li>
                    @else
                        <li class="breadcrumb-item">
                            @if(!empty($crumb['icon']))
                                <i class="bi {{ $crumb['icon'] }} me-1"></i>
                            @endif
                            @php
                                $crumbUrl = null;
                                try {
                                    $crumbUrl = !empty($crumb['route']) ? route($crumb['route']) : null;
                                } catch (\Throwable $e) {
                                    $crumbUrl = null;
                                }
                            @endphp
                            @if(!empty($crumb['url']))
                                <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                            @elseif(!empty($crumbUrl))
                                <a href="{{ $crumbUrl }}">{{ $crumb['label'] }}</a>
                            @else
                                <span>{{ $crumb['label'] }}</span>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
@endif