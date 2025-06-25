<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .carousel-item {
            transition: transform 0.6s ease-in-out !important;/* 轮播平滑过渡效果，在0.6秒内滑动进出。 */
            position: relative;/* 将轮播项目相对于其正常位置进行定位 */
        }

        .carousel-item img {
            width: 100%;/* 图片占据全部宽度。 */
            height: 100vh;/* 将图片的高度设置为视口高度的 */
            object-fit: cover;/* 确保图片覆盖整个轮播项目区域而不失真。 */
        }

        /* 默认轮播按钮 */
        .carousel-control-prev,
        .carousel-control-next {
            display: none !important; /* 隐藏 Bootstrap 自带按钮 */
        }

        /* 默认大屏幕：保留 Bootstrap 原本 padding */
        .container-custom {
            padding-left: 10rem;
            padding-right: 10rem;
        }
        
        /* 小于等于 768px 的屏幕：缩小 padding */
        @media (max-width: 768px) {
            .carousel-item img {
                height: 500px;
            }
            .container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .container-custom {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .narrow-on-mobile {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .text-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                padding: 10px;
                width: 100%;
                background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent);
                color: white;
                font-size: 0.85rem;
            }
            
            .row.flex-nowrap.overflow-auto {
                flex-wrap: wrap !important;
                overflow: visible !important;
            }
            
            /* 每个卡片都占满整行 */
            .col-3, .col-md-3, .col-md-6 {
                flex: 0 0 80% !important;
                width: 200px !important;
            }
            
            /* 卡片高度适当缩小 */
            .update-card {
                height: 190px;
            }
            
            .text-overlay h3 {
                font-size: 1.2rem;
            }
            
            .text-overlay p {
                font-size: 0.9rem;
            }
        }

        .game-update {
            margin-bottom: 30px;
            text-align: center;
        }
        
        .img-1 {
            width: 260px;
            height: 280px;
            overflow: hidden;
            border-radius: 10px;
            position: relative;
        }
        
        .img-1 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 10px;
        }
        
        .img-2 {
            width: 530px;
            height: 280px;
            overflow: hidden;
            border-radius: 10px;
            position: relative;
        }
        
        .img-2 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 10px;
        }
        
        .text-overlay h3,
        .text-overlay p {
            margin: 0;
        }

        .game-update h3 {
            margin-top: 10px;
            font-size: 1.5rem;
            color: white;
        }

        .game-update p {
            font-size: 1rem;
            color: white;
        }

        .more-button {
            position: absolute;
            bottom: 20px;
            left: 20px;
            z-index: 1060;
            pointer-events: auto;
            color: white;
            background-color: rgba(0, 0, 0, 0.7);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        /* 自定义左、右箭头按钮样式 */
        .custom-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%) scale(1.1);
            transition: all 0.3s ease;
            z-index: 2; /* ✅ 降低 z-index，避免覆盖顶部 Navbar 等 */
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            color: white;
            font-size: 24px;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            line-height: 1;
            pointer-events: auto;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .carousel:hover .custom-arrow {
            opacity: 1;
        }
        
        .carousel {
            position: relative; /* ✅ 确保箭头相对于这个定位 */
            overflow: hidden;   /* ✅ 保证不跑出去 */
        }


        .custom-arrow:hover {
            background-color: rgba(255, 255, 255, 0.8);
            color: black;
        }

        .custom-arrow.left {
            left: 20px;
        }

        .custom-arrow.right {
            right: 20px;
        }

        .update-card {
            height: 100%;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }
        
        .update-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .text-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            color: white;
        }
        
        .small-card {
            height: 280px;
        }
        
        .large-card {
            height: 280px;
        }
        
        .row.flex-nowrap.overflow-auto {
            scroll-behavior: smooth;
        }

    </style>
</head>

<x-app-layout>
    <!-- Carousel -->
    <div id="carouselExample1" class="carousel slide carousel-fade mb-4 position-relative" data-bs-ride="carousel" data-bs-interval="2000">

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExample1" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carouselExample1" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carouselExample1" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner w-100">
            <div class="carousel-item active position-relative">
                <img src="{{ asset('images/back01.jpeg') }}" alt="Slide 1">
                <a href="{{ route('productDetail', ['id' => 1]) }}" class="more-button">More</a>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/ll2.jpg') }}" alt="Slide 2">
                <a href="{{ route('productDetail', ['id' => 2]) }}" class="more-button">More</a>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/ll3.jpg') }}" alt="Slide 3">
                <a href="{{ route('productDetail', ['id' => 3]) }}" class="more-button">More</a>
            </div>
        </div>

        <!-- 自定义左右箭头按钮 -->
        <button class="custom-arrow left" onclick="goToPrevSlide()" aria-label="Previous slide">&#60;</button>
        <button class="custom-arrow right" onclick="goToNextSlide()" aria-label="Next slide">&#62;</button>
        
    </div>

    {{-- Latest Updates --}}
    <div class="container-fluid">
        <div class="container-custom py-4">
            <h2 class="mb-4">Latest Updates</h2>
            <div class="row g-3">
                @foreach (range(1,4) as $id)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('productDetail', ['id' => $id]) }}" class="text-decoration-none text-white d-block">
                            <div class="update-card">
                                <img src="{{ asset('images/ll3.jpg') }}" alt="Update {{ $id }}">
                                <div class="text-overlay">
                                    <h3>{{ $id }}</h3>
                                    <p>Update {{ $id }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    const carousel = document.querySelector('#carouselExample1');
    const carouselInstance = new bootstrap.Carousel(carousel);

    function goToPrevSlide() {
        carouselInstance.prev();
    }

    function goToNextSlide() {
        carouselInstance.next();
    }

    document.querySelectorAll('.more-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            window.location.href = this.getAttribute('href');
        });
    });
</script>
