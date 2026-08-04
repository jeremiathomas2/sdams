@php
    $photoUrl = $entity->photo_url ?? $entity->profile_photo_url ?? null;
    $initials = $entity->initials ?? '?';
    $size = $size ?? 34;
    $fontSize = $fontSize ?? ($size >= 60 ? '1.4rem' : ($size >= 44 ? '1rem' : '0.78rem'));
@endphp
@if($photoUrl)
    <img src="{{ $photoUrl }}" alt="{{ $initials }}" width="{{ $size }}" height="{{ $size }}"
         style="width:{{ $size }}px;height:{{ $size }}px;border-radius:50%;object-fit:cover;flex-shrink:0;{{ $extraStyle ?? '' }}"
         class="avatar-img {{ $class ?? '' }}">
@else
    <div class="member-avatar" style="width:{{ $size }}px;height:{{ $size }}px;font-size:{{ $fontSize }};{{ $extraStyle ?? '' }}">
        {{ $initials }}
    </div>
@endif
