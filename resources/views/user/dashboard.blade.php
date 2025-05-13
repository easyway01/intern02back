<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .carousel-item {
            transition: transform 0.6s ease-in-out !important;
        }
        .carousel-item img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }
    </style>
</head>

<x-app-layout>
    <!-- Carousel 1 -->
    <div id="carouselExample1" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExample1" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carouselExample1" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carouselExample1" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner w-100">
            <div class="carousel-item active">
                <img src="{{ asset('images/01.png') }}" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/01.png') }}" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/01.png') }}" alt="Slide 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample1" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample1" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <!-- Carousel 2 -->
    <div id="carouselExample2" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExample2" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carouselExample2" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carouselExample2" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner w-100">
            <div class="carousel-item active">
                <img src="{{ asset('images/back01.jpeg') }}" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/back1.png') }}" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/back01.jpeg') }}" alt="Slide 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample2" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample2" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</x-app-layout>
