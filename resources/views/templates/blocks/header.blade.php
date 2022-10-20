<header>
    <?php
        if(isset($_SESSION['user_session']) && !empty($_SESSION['user_session'])) {
            $login_user = $_SESSION['user_session']; 
        }
    ?>

    <div class="container">
        <div class="content">
            <a href="/" class="logo">
                ITJob
            </a>
            <div class="login_container">
                <div class="header_items">
                    <div class="wrap">
                        <div class="header-item">
                            <a href="/">Вакансии</a>
                        </div>
                        
                        @if (Auth::check())
                            @if(Auth::user()->user_group == 1)
                                <div class="header-item">
                                    <a href="/admin">Администрирование</a>
                                </div>
                            @endif
                            <div class="header-item">
                                <a href="/post">Разместить</a>
                            </div>
                            <div class="header-item name">
                                <a href="/cabinet">
                                    {{-- {{stristr(Auth::user()->name, ' ', true)}}  --}}
                                    {{Auth::user()->name}}
                                </a>
                            </div>
                            <a href="/logout">Выйти</a>  
                        @else
                            <div class="header-item">
                                <a href="/register">Регистрация</a>
                            </div>
                            <a href="/login">Войти</a>  
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>    
</header>