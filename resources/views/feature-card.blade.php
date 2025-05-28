
<div class="col">
    <div class="feature-card text-center">
        <div class="card-header" >
            <i class="{{ $icon }}"></i><br>
            <button class="feature-button my-md-5 my-2" style="white-space: nowrap;" onclick="toggleDesc(this)">{{ $title }}</button>
            <div class="chevron mb-2"><i class="fa-solid fa-circle-chevron-down"></i></div>
        </div>
        <div class="feature-desc collapse accordion-transition">
            {{ $description }}
        </div>
    </div>
</div>
