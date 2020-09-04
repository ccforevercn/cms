<header class="v2-ac">
    <div class="head-v2__top v2-ac">
        <h1 class="pull-left">
            <a href="{{ $public['configs']['zy_cms_website'] }}" title="{{ $public['configs']['zy_cms_name'] }}">
                <img src="{{ $public['configs']['zy_cms_pc_logo_top'] }}" alt="{{ $public['configs']['zy_cms_name'] }}" style="margin:15px 0 0 50px;"/>
            </a>
        </h1>
        <ul class="head-v2__right pull-right v2-list">
            <li class="pull-left head-v2__li1 hidden-xs">
                <span class="search-v2 glyphicon glyphicon-search"></span>
                <form id="form1" name="form1" method="get" action="/m342/Search.asp" target="_self">
                    <span class="navsearch_input"> <input type="text" name="SearchStr" value="搜索你想了解的内容..." size="20" /> </span>
                    <input type="submit" name="Submit" value=" " class="searchgo" />
                </form> </li>
            <li class="pull-left btn head-v2__li3 navbar-toggle collapsed" data-toggle="collapse" data-target="#nav_v2__list">
                <span class="glyphicon glyphicon-menu-hamburger"></span>
            </li>
        </ul>
    </div>
    <nav class="nav-v2">
        <ul class="nav nav-justified collapse navbar-collapse" id="nav_v2__list">
            <li class="active visible-xs-block search-home-v2"> <span class="search-icon-v2 glyphicon glyphicon-search"></span>
                <form id="form1" name="form1" method="get" action="/m342/Search.asp" target="_self">
                    <span class="navsearch_input pull-left v2-ac"> <input type="text" name="SearchStr" value="搜索你想了解的内容..." size="20" /> </span>
                    <input type="submit" name="Submit" value=" " class="searchgo" />
                </form> </li>


            @foreach($public['navigation'] as $navigation)
                @if($navigation['id'] == $navigationId)
                    @if(count($navigation['children']))
                        <li class="dropdown   nav-v2__list2  navdown">
                            <a href="{{ $navigation['url'] }}" title="{{ $navigation['name'] }}" role="button" data-hover="dropdown">{{ $navigation['name'] }}</a>
                            <ul class="dropdown-menu  nav-v2__list2__ul " role="menu">
                                @foreach($navigation['children'] as $child)
                                    <li><a href="{{ $child['url'] }}" title="{{ $child['name'] }}">{{ $child['name'] }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="active home-v2  navdown "><a href="{{ $navigation['url'] }}" title="{{ $navigation['name'] }}">{{ $navigation['name'] }}</a></li>
                    @endif
                @else
                    @if(count($navigation['children']))
                        <li class="dropdown   nav-v2__list2 ">
                            <a href="{{ $navigation['url'] }}" title="{{ $navigation['name'] }}" role="button" data-hover="dropdown">{{ $navigation['name'] }}</a>
                            <ul class="dropdown-menu  nav-v2__list2__ul " role="menu">
                                @foreach($navigation['children'] as $child)
                                    <li><a href="{{ $child['url'] }}" title="{{ $child['name'] }}">{{ $child['name'] }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="active home-v2"><a href="{{ $navigation['url'] }}" title="{{ $navigation['name'] }}">{{ $navigation['name'] }}</a></li>
                    @endif
                @endif
            @endforeach
        </ul>
    </nav>
</header>
<div class="v2_banner">
    <div id="slidershow" class="carousel slide">
        <ol class="carousel-indicators">
            @foreach($public['banners'] as $banner)
                @if($loop->first)
                    <li class="active" data-target="#slidershow" data-slide-to="{{ $loop->index }}"></li>
                @else
                    <li class="" data-target="#slidershow" data-slide-to="{{ $loop->index }}"></li>
                @endif
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($public['banners'] as $banner)
                @if($loop->first)
                    <div class="item active">
                        <a href="{{ $banner['link'] }}" title="{{ $banner['name'] }}"><img src="{{ $banner['image'] }}" alt="{{ $banner['name'] }}" width="100%" /></a>
                    </div>
                @else
                    <div class="item">
                        <a href="{{ $banner['link'] }}" title="{{ $banner['name'] }}"><img src="{{ $banner['image'] }}" alt="{{ $banner['name'] }}" width="100%" /></a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>