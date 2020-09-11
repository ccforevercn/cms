<header class="header">
    <div class="container clearfix">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar icon-bar-1"></span>
                <span class="icon-bar icon-bar-2"></span>
                <span class="icon-bar icon-bar-3"></span>
            </button>
            <h1 class="logo">
                <a href="{{ $configs['zy_cms_website'] }}" title="{{ $configs['zy_cms_name'] }}">
                    <img src="{{ $configs['zy_cms_pc_logo_top'] }}" alt="{{ $configs['zy_cms_name'] }}">
                </a>
            </h1>
        </div>
        <div class="collapse navbar-collapse">
            <nav class="navbar-left primary-menu">
                <ul class="nav navbar-nav wpcom-adv-menu">
                    @foreach($navigation as &$nav)
                        @if($nav['id'] == $navigationId)
                            @if(count($nav['children']))
                                <li class="menu-item dropdown active">
                                    <a href="{{ $nav['url'] }}" title="{{ $nav['name'] }}">{{ $nav['name'] }}</a>
                                    <ul class="dropdown-menu menu-item-wrap menu-item-col-5">
                                        @foreach($nav['children'] as &$child)
                                            <li class='menu-item'>
                                                <a href="{{ $child['url'] }}" title="{{ $child['name'] }}">{{ $child['name'] }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="menu-item">
                                    <a href="{{ $nav['url'] }}" title="{{ $nav['name'] }}">{{ $nav['name'] }}</a>
                                </li>
                            @endif
                        @else
                            @if(count($nav['children']))
                                <li class="menu-item dropdown">
                                    <a href="{{ $nav['url'] }}" title="{{ $nav['name'] }}">{{ $nav['name'] }}</a>
                                    <ul class="dropdown-menu menu-item-wrap menu-item-col-5">
                                        @foreach($nav['children'] as &$child)
                                            <li class='menu-item'>
                                                <a href="{{ $child['url'] }}" title="{{ $child['name'] }}">{{ $child['name'] }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="menu-item">
                                    <a href="{{ $nav['url'] }}" title="{{ $nav['name'] }}">{{ $nav['name'] }}</a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</header>