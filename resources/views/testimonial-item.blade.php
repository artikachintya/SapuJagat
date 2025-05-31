<!-- testimonial-item.html -->
<div class="carousel-item {{ $active }}">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="row">
                <div class="col-lg-4 d-flex justify-content-center">
                    <img src="{{ $image_url }}"
                        class="rounded-circle shadow-1 mb-4 mb-lg-0"
                        alt="{{ $name }} avatar" width="150" height="150" />
                </div>
                <div class="col-9 col-md-9 col-lg-7 col-xl-8 text-center text-lg-start mx-auto mx-lg-0">
                    <h4 class="mb-4 fs-3 fw-semibold">{{ $name }}</h4>
                    <p class="mb-0 pb-3 fs-5">
                        {{ $testimonial_text }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
