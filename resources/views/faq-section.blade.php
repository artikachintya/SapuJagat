<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button {{ $expanded ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
            data-bs-target="#{{ $target }}" aria-expanded="{{ $expanded ? 'true' : 'false' }}"
            aria-controls="{{ $target }}">
            {{ $title }}
        </button>
    </h2>
    <div id="{{ $target }}" class="accordion-collapse collapse {{ $expanded ? 'show' : '' }}"
        data-bs-parent="#{{ $parent }}">
        <div class="accordion-body">
            {{ $content }}
        </div>
    </div>
</div>
