<div class="layui-header header trans_3">
    <div class="main index_main">
        <a class="logo" href="{{ $configs['cc_cms_website'] }}" title="{{ $configs['cc_cms_name'] }}">
            <img src="{{ $configs['cc_cms_pc_logo_top'] }}" alt="{{ $configs['cc_cms_name'] }}">
        </a>
        <ul class="layui-nav" lay-filter="top_nav">
            @foreach($navigation as &$nav)
                <li class="layui-nav-item home"><a href="{{ $nav['url'] }}" title="{{ $nav['name'] }}">{{ $nav['name'] }}</a>
                    @if(count($nav['children']))
                        @foreach($nav['children'] as &$child)
                            <dl class="layui-nav-child">
                                <dd><a href="{{ $child['url'] }}" title="{{ $child['name'] }}">{{ $child['name'] }}</a></dd>
                            </dl>
                        @endforeach
                    @endif
                </li>
            @endforeach
        </ul>
        <div class="title">{{ $configs['cc_cms_name'] }}</div>
        <form action="/search.html" mothod="get" class="head_search trans_3 layui-form">
            <div class="layui-form-item trans_3">
                <span class="close trans_3"><i class="layui-icon">&#x1006;</i> </span>
                <input type="text" name="search" placeholder="搜索" autocomplete="off" class="search_input trans_3">
                <button class="layui-btn" lay-submit="" style="display: none;"></button>
            </div>
        </form>
    </div>
</div>
<div class="header_back"></div>
<div class="layui-side layui-bg-black left_nav trans_2">
    <div class="layui-side-scroll">
        <ul class="layui-nav layui-nav-tree"  lay-filter="left_nav">
            @foreach($navigation as &$nav)
                <li class="layui-nav-item home">
                    @if(count($nav['children']))
                        <a href="javascript:void(0);">{{ $nav['name'] }}</a>
                        @foreach($nav['children'] as &$child)
                            <dl class="layui-nav-child">
                                <dd><a href="{{ $child['url'] }}" title="{{ $child['name'] }}">{{ $child['name'] }}</a></dd>
                            </dl>
                        @endforeach
                    @else
                        <a href="{{ $nav['url'] }}" title="{{ $nav['name'] }}">{{ $nav['name'] }}</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="left_nav_mask"></div>
<div class="left_nav_btn"><i class="layui-icon">&#xe602;</i></div>

