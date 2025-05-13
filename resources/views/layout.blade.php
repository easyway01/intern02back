<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        .navbar {
            height: 100px; /* 您可以根据需要更改高度，例如 60px、100px */
            padding: 20px 30px; /* 上下左右的内边距 */
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: lightgrey !important; 
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        .scrolled {
            height: 100px; /* 滚动后变小 */
            background-color: rgba(0, 0, 0, 0.7) !important; /* 半透明黑色 */
        }
        
        .scrolled .dropdown-item.active {
            color: orange !important;
            background-color: transparent !important;
        }
        
        .scrolled .nav-link,
        .nav-link.active {
            color: white !important;
            font-weight: bold;
        }
        
        .navbar-nav {
            gap: 20px; /* 适用于 Bootstrap 4 及以上版本 */
        }
        
        /* 导航项的左右间距 */
        .nav-item {
            margin: 0 20px;
        }
        
        /* 分隔符样式 */
        .navbar-nav .separator {
            padding: 0 5px; /* | 两侧的间距 */
            color: gray;
            font-weight: bold;
        }
        
        .nav-link.active {
            color: orange !important;
            font-weight: bold;
            border-bottom: 3px solid orange;
        }


        .scrolled .navbar-brand {
            height: 45px; /* 滚动后缩小 */
            color: white !important; /* 文字变白 */
        }

        /* ====== 分隔线样式 ====== */
        .menu-divider {
            width: 100%;
            border: 0;
            border-top: 1px solid rgba(255, 255, 255, 0.5); /* 细白色分割线 */
            margin: 10px auto 10px auto; /* 上方间距 */
        }

        .fullscreen-menu {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            padding-left: 50px;
            width: 100%;
            height: 100%;
            background-color: black;
            z-index: 1100;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            padding-top: 30px;
            box-sizing: border-box;
        }

        .fullscreen-menu a {
            color: white;
            font-size: 2rem;
            margin: 20px 0;
            text-decoration: none;
            text-align: left; /* 文字靠左 */
        }

        .fullscreen-menu.show {
            display: flex;
        }

        .user-dropdown {
            position: relative;
        }
        
        .username {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 10px;
            display: inline-block;
        }
        
        .user-dropdown-menu {
            display: none;
            flex-direction: column;
            position: relative;
            margin-top: 10px;
        }
        
        .user-dropdown-menu a {
            color: white;
            font-size: 1.2rem;
            text-decoration: none;
            margin: 5px 0;
        }
        
        .user-dropdown.open .user-dropdown-menu {
            display: flex;
        }

        /* 关闭按钮 (✖) */
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

    </style>
    <title>Navbar 自动添加</title>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand" href="dashboard" style="color: black;">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        </a>
        
        <button class="navbar-toggler" type="button" id="menu-button">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- full screen -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- 左侧菜单项 -->
            <ul class="navbar-nav mr-auto">
                <!-- Home -->
                 <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="/dashboard">Home</a>
                </li>
                <!-- Product -->
                 <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('showProduct') ? 'active' : '' }}" href="{{ route('showProduct') }}">Product</a>
                </li>
                <!-- Add -->
                 <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('addProduct') ? 'active' : '' }}" href="{{ route('addProduct') }}">Add</a>
                </li>
            </ul>
             <!-- 右侧内容 -->
            <ul class="navbar-nav ml-auto d-flex align-items-center">
                @guest
                <!-- Login -->
                <li class="nav-item pr-0">
                    <a class="nav-link p-0" href="{{ route('login') }}">Login</a>
                </li>

                <li class="nav-item d-flex align-items-center px-0 mx-0">
                    <span class="nav-link px-0">|</span>
                </li>
                
                <!-- Register -->
                <li class="nav-item pl-0">
                    <a class="nav-link p-0" href="{{ route('register') }}">Register</a>
                </li>
                
                @endguest
                @auth

                <!-- 搜索框 -->
                <li class="nav-item">
                    <!-- 搜索表单 -->
                    <form class="form-inline position-relative" method="GET" action="{{ route('searchProduct') }}">
    <input class="form-control mr-2" type="text" name="query" id="search-box" placeholder="Search Product" autocomplete="off">
    <button class="btn my-2 my-sm-0" type="submit" style="background-color: black; color: white;">Search</button>
    <!-- 自动补全结果 -->
    <div id="suggestions" class="list-group position-absolute w-100" style="z-index:999; top:100%; left:0;"></div>
</form>

                </li>

                <!-- 用户下拉菜单 -->
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        </form>
                    </div>
                </li>
                @endauth
            </ul>
        </div>
    </nav>
    
    <!-- 移动视图下显示/缩小 -->
    <div class="fullscreen-menu" id="fullscreen-menu">
        <!-- Logo放最上方 -->

        <button id="close-menu" class="close-menu">&#10005;</button>
        <li class="nav-item">
                    <!-- 搜索表单 -->
                    <form class="form-inline position-relative" method="GET" action="{{ route('searchProduct') }}">
    <input class="form-control mr-2" type="text" name="query" id="search-box" placeholder="Search Product" autocomplete="off">
    <button class="btn my-2 my-sm-0" type="submit" style="background-color: black; color: white;">Search</button>
    <!-- 自动补全结果 -->
    <div id="suggestions" class="list-group position-absolute w-100" style="z-index:999; top:100%; left:0;"></div>
</form>

                </li>
        <hr class="menu-divider">
        
        <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">Home</a>
        <a href="{{ route('showProduct') }}" class="{{ request()->routeIs('showProduct') ? 'active' : '' }}">Product</a>
        <a href="{{ route('addProduct') }}" class="{{ request()->routeIs('addProduct') ? 'active' : '' }}">Add</a>
        <a href="{{ route('calendar') }}" class="{{ request()->routeIs('calendar') ? 'active' : '' }}">calendar</a>
        
        <div class="user-dropdown mt-4">
            <span class="username" id="userDropdownToggle">{{ Auth::user()->name }} ▾</span>
            <div class="user-dropdown-menu" id="userDropdownMenu">
                <a href="{{ route('profile.edit') }}">Profile</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
                </a>
            </div>
        </div>
        
    </div>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
<script>
    // 监听窗口大小变化，若变大则自动关闭菜单，并隐藏 menu icon
    window.addEventListener("scroll", function () {
        let navbar = document.querySelector(".navbar");
        let activeLink = document.querySelector(".nav-link.active");
        
        if (window.scrollY > 50) {  
            navbar.classList.add("scrolled");  
        } else {  
            navbar.classList.remove("scrolled");  
        }
        
        if (activeLink) {
            activeLink.style.color = "orange"; // 确保 active 链接仍然是橙色
            }
    });
    
    $(document).ready(function() {
        console.log("Document is ready");
            
        // 滚动时更改导航栏样式
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) { 
                $('.navbar').addClass('scrolled');
            } else {
                $('.navbar').removeClass('scrolled');
            }
        });
            
        // 打开菜单
        $('#menu-button').on('click', function() {
            console.log("Menu button clicked");
            $('#fullscreen-menu').toggleClass('show');
        });

        // 关闭菜单
        $('#fullscreen-menu a, .close-menu').on('click', function() {
            $('#fullscreen-menu').removeClass('show');
        });
        
        // 搜索框自动补全
        $("#search-box").keyup(function() {
            let query = $(this).val();
            if (query.length > 1) {
                $.ajax({
                    url: "{{ route('products.autocomplete') }}",
                    type: "GET",
                    data: { query: query },
                    success: function(data) {
                        let suggestions = $("#suggestions");
                        suggestions.empty();
                        data.forEach(function(item) {
                            suggestions.append(`<a href="/product/${item.id}" class="list-group-item list-group-item-action">${item.name}</a>`);
                        });
                    }
                });
                } else {
                    $("#suggestions").empty();
                }
        });
    });
    // 移动版搜索自动补全
$("#mobile-search-box").keyup(function() {
    let query = $(this).val();
    if (query.length > 1) {
        $.ajax({
            url: "{{ route('products.autocomplete') }}",
            type: "GET",
            data: { query: query },
            success: function(data) {
                let suggestions = $("#mobile-suggestions");
                suggestions.empty();
                data.forEach(function(item) {
                    suggestions.append(`<a href="/product/${item.id}" class="list-group-item list-group-item-action">${item.name}</a>`);
                });
            }
        });
    } else {
        $("#mobile-suggestions").empty();
    }
});

    
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('userDropdownToggle');
        const dropdown = document.querySelector('.user-dropdown');

        toggle.addEventListener('click', () => {
            dropdown.classList.toggle('open');
        });
    });
</script>
@auth

@endauth
    
    <div class="container-fluid">  
      @yield('content')
    </div>

  </body>
</html>
