<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        /* ====== 导航栏样式 ====== */
        .navbar {
            height: 70px;
            /* 初始高度 */
            padding: 20px 30px;
            /* 上下左右的内边距 */
            position: fixed;
            /* 固定在顶部 */
            top: 0;
            width: 100%;
            z-index: 1000;
            /* 确保在其他内容之上 */
            background-color: rgba(0, 0, 0, 0.7) !important;
            /* 半透明黑色 */
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        .navbar .nav-link,
        .navbar .navbar-brand,
        .navbar .dropdown-item {
            color: white !important;
        }

        .nav-link.active {
            color: orange !important;
            font-weight: bold;
            border-bottom: 3px solid orange;
            /* 可选：增加底部边框以突出显示 */
        }

        /* 导航项间距 */
        .navbar-nav {
            gap: 10px;
            /* 适用于 Bootstrap 4 及以上版本 */
        }


        /* 导航项的左右间距 */
        .nav-item {
            margin: 0 10px;
        }


        /* 分隔符样式 */

        .navbar-nav .separator {
            padding: 0 5px;
            /* | 两侧的间距 */
            color: gray;
            font-weight: bold;
        }

        .menu-overlay {
            display: none;
            position: fixed;
            top: 0px;
            right: 0;
            width: 50vw;
            height: 100vh;
            background: black;
            z-index: 1050;
            flex-direction: column;
            /* 垂直排列菜单项 */
            align-items: center;
            /* 水平居中 */
            justify-content: flex-start;
            /* 上对齐 */
            padding: 50px 20px;
        }

        /* 控制菜单项的排列 */
        .menu-overlay .navbar-nav {
            padding-left: 0;
            /* 不要左侧的内边距 */
            margin-top: 20px;
            /* 为菜单项添加顶部间距 */
        }

        /* 调整菜单项间距 */
        .menu-overlay .nav-item {
            margin: 10px 0;
            /* 增加上下间距 */
        }

        /* 调整导航项的样式 */
        .menu-overlay .nav-link {
            color: white !important;
            font-size: 2rem;
            /* 增大字体 */
            padding: 10px 15px;
            /* 增大点击区域 */
            display: block;
            text-align: left;
            /* 文本左对齐 */
        }

        /* ====== 关闭按钮 (✖) 样式 ====== */
        .close-menu {
            position: absolute;
            top: 20px;
            right: 40px;
            font-size: 2rem;
            color: white;
            background: none;
            border: none;
            cursor: pointer;
            z-index: 10002;
        }


        /* ====== 移动端适配 (小屏幕) ====== */
        @media (max-width: 992px) {
            .navbar-toggler {
                border: none !important;
                box-shadow: none !important;
                outline: none !important;
                background-color: transparent !important;
                padding: 10px;
                border-radius: 8px;
            }

            .navbar-toggler:focus,
            .navbar-toggler:active,
            .navbar-toggler:hover {
                border: none !important;
                box-shadow: none !important;
                outline: none !important;
                background-color: transparent !important;
            }

            /* 汉堡菜单图标变白色 */
            .navbar-toggler-icon {
                width: 50px;
                /* 调整图标宽度 */
                height: 40px;
                /* 调整图标高度 */
                background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='white' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E") !important;
                position: relative;
                top: -20px;
                /* 调整垂直位置 */
                left: 10px;
                /* 调整水平位置 */
            }

            .navbar {
                background-color: black !important;
                /* 小屏幕时背景变为纯黑 */
            }
        }

        /* ====== 用户下拉菜单 (默认隐藏) ====== */
        .dropdown-menu {
            display: none;
            /* 默认隐藏 */
            position: absolute;
            background: black;
            /* 黑色背景 */
            border: none;
            padding-left: 20px;
        }

        /* 下拉菜单项 */
        .dropdown-item {
            color: white;
        }

        /* ====== 分隔线样式 ====== */
        .menu-divider {
            width: 100%;
            border: 0;
            border-top: 2px solid white;
            /* 细白色分割线 */
            margin: 40px auto 20px auto;
            /* 上方间距 */
        }
        .navbar-nav .nav-item {
            margin: 0 5px; /* 默认 Bootstrap 是 10px 左右，这里减半 */
        }

    </style>
    <title>Responsive Navbar</title>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">

        <!-- 小屏幕菜单按钮 -->
        <div class="d-flex w-100 justify-content-end d-lg-none">
            <button class="navbar-toggler" type="button" onclick="openMenu()">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>


        <!-- 菜单栏 -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <!-- resources/views/components/nav-items.blade.php -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('showProduct') ? 'active' : '' }}" href="{{ route('showProduct') }}">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('addProduct') ? 'active' : '' }}" href="{{ url('/addProduct') }}">Add</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('calendar') ? 'active' : '' }}" href="{{ url('/calendar') }}">Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('task-list') ? 'active' : '' }}" href="{{ url('/task-list') }}">Task-list</a>
                </li>
            </ul>


            @guest
            <ul class="navbar-nav ml-auto d-flex align-items-center">
                <li class="nav-item pr-0"><a class="nav-link p-0" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item d-flex align-items-center px-0 mx-0"><span class="nav-link px-0">|</span></li>
                <li class="nav-item pl-0"><a class="nav-link p-0" href="{{ route('register') }}">Register</a></li>
            </ul>

            @endguest
            @auth
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- 不可点击的用户名 -->
                        <span class="dropdown-item text-muted d-flex justify-content-between align-items-center" style="pointer-events: none; opacity: 0.9;">
                            {{ Auth::user()->name }}
                            <span class="ml-2">▼</span>
                        </span>

                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>

            @endauth
        </div>
    </nav>

    <!-- 黑色菜单遮罩层 -->
    <div class="menu-overlay" id="menuOverlay">

        <!-- 分割线 -->
        <hr class="menu-divider">

        <button class="close-menu" onclick="closeMenu()">&#10005;</button>

        <!-- 菜单项 -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" href="{{route('dashboard')}}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'showProduct' ? 'active' : '' }}" href="{{route('showProduct')}}">Product</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('addProduct') ? 'active' : '' }}" href="{{ url('/addProduct') }}">Add</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('calendar') ? 'active' : '' }}" href="{{ url('/calendar') }}">Calendar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('task-list') ? 'active' : '' }}" href="{{ url('/task-list') }}">Task-list</a>
            </li>
        </ul>


        @guest
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
        </ul>
        @endguest

        @auth
        <ul class="navbar-nav">
            <!-- Profile Dropdown -->
            <li class="nav-item dropdown">
                <a id="profileDropdown" class="nav-link dropdown-toggle" href="#" role="button">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu" id="profileDropdownMenu">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        @endauth
    </div>

    <!-- JavaScript -->
    <script>
        function openMenu() {
            console.log("Menu is opening");
            const overlay = document.getElementById("menuOverlay");
            overlay.style.display = "flex";
            document.querySelector(".navbar-toggler").style.display = "none";
            setTimeout(() => {
                document.addEventListener("click", handleOutsideClick);
            }, 100);
        }

        function closeMenu() {
            console.log("Menu is closing");
            const overlay = document.getElementById("menuOverlay");
            overlay.style.display = "none";
            if (window.innerWidth <= 992) {
                document.querySelector(".navbar-toggler").style.display = "block";
            }
            document.removeEventListener("click", handleOutsideClick);
        }

        function handleOutsideClick(event) {
            const overlay = document.getElementById("menuOverlay");
            if (!overlay.contains(event.target)) {
                closeMenu();
            }
        }

        // 处理 Profile 下拉菜单
        document.addEventListener("DOMContentLoaded", function() {
            let profileDropdown = document.getElementById("profileDropdown");
            let dropdownMenu = document.getElementById("profileDropdownMenu");

            profileDropdown.addEventListener("click", function(event) {
                event.preventDefault();
                event.stopPropagation();
                dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
            });

            document.addEventListener("click", function(event) {
                if (!profileDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.style.display = "none";
                }
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>