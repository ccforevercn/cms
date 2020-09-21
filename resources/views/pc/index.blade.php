<!DOCTYPE html>
<html lang="en">
<head>
    @include('pc.style')
</head>
<body>
@include('pc.header')
@if(count($banners))
<div class="banner">
<div class="main index_main">
    @foreach($banners as &$banner)
        @if($loop->first)
            <img class="banner_pic" src="{{ $banner['image'] }}" alt="{{ $banner['name'] }}">
        @endif
    @endforeach
</div>
</div>
@endif
<div class="fill_1"></div>
<div class="main index_main">
    <ul class="index-learn">
        <li>
            <fieldset class="layui-elem-field layui-field-title">
                <legend>学无止境</legend>
                <p>学习，探索，研究，从不了解到了解，从无知到掌握，到灵活运用，在不断的学习中加深认识。由浅入深，由表及里。</p>
            </fieldset>
        </li>
        <li>
            <fieldset class="layui-elem-field layui-field-title">
                <legend>业精于勤</legend>
                <p>“业精于勤荒于嬉”，精深的业技靠的是勤学、刻苦努力，靠的是争分夺秒的勤学苦练才会有精深的技术。得在认真，失在随便。</p>
            </fieldset>
        </li>
        <li>
            <fieldset class="layui-elem-field layui-field-title">
                <legend>工匠精神</legend>
                <p>精益求精，注重细节，追求完美和极致，不惜花费时间精力，孜孜不倦，反复改进产品，把99%提高到99.99%。</p>
            </fieldset>
        </li>
    </ul>
</div>
@if(count($banners))
    <div class="main index_main lzcms_banner">
        @foreach($banners as &$banner)
            @if($loop->last)
                <a href="{{ $banner['link'] }}" title="{{ $banner['name'] }}"><img src="{{ $banner['image'] }}" alt="{{ $banner['name'] }}"></a>
            @endif
        @endforeach
    </div>
@endif
<div class="main index_main">
    @php
        $messages = \App\CcForever\extend\MessagesExtend::messages(3, true, 0, 6, 3, $configs['cc_cms_substation_link']);
    @endphp
    <div class="page_left">
        <ul class="page_left_list">
            @foreach($messages as &$message)
                @if(strlen($message['image']))
                        <li>
                            <a href="{{ $message['url'] }}" title="{{ $message['name'] }}" class="pic">
                                <img class="lazy" src="{{ $message['image'] }}" alt="{{ $message['name'] }}">
                            </a>
                            <h2 class="title"><a href="{{ $message['url'] }}" title="{{ $message['name'] }}"><span class="top">推荐</span>{{ $message['name'] }}</a></h2>
                            <div class="date_hits">
                                <span>{{ $message['time'] }}</span>
                                <span><a href="javascript:void(0);">{{ $message['cname'] }}</a></span>
                                <span class="hits"><i class="layui-icon" title="点击量">&#xe62c;</i> {{ $message['click'] }} ℃</span>
                            </div>
                            <div class="desc">{{ get_str_cn_str($message['description'], 0, 66, true, '...') }}</div>
                        </li>
                @else
                        <li class="no_pic">
                            <h2 class="title"><a href="{{ $message['url'] }}" title="{{ $message['name'] }}"><span class="top">推荐</span>{{ $message['name'] }}</a></h2>
                            <div class="date_hits">
                                <span>{{ $message['time'] }}</span>
                                <span><a href="javascript:void(0);">{{ $message['cname'] }}</a></span>
                                <span class="hits"><i class="layui-icon" title="点击量">&#xe62c;</i> {{ $message['click'] }} ℃</span>
                            </div>
                            <div class="desc">{{ get_str_cn_str($message['description'], 0, 66, true, '...') }}</div>
                        </li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="page_right">
        <div class="about_stationmaster_container">
            <h3>博主信息</h3>
            <ol class="page_right_list trans_3">
                <li>姓名：{{ $configs['cc_cms_service_name'] }}</li>
                <li>职业：{{ $configs['cc_cms_service_name'] }}</li>
                <li>座右铭：{{ $configs['cc_cms_service_name'] }}</li>
                <li>QQ群：{{ $configs['cc_cms_service_name'] }}</li>
            </ol>
        </div>
        @php
            $messages = \App\CcForever\extend\MessagesExtend::messages(4, true, 0, 6, 1, $configs['cc_cms_substation_link']);
        @endphp
        <div class="new_list">
            <h3>最新文章</h3>
            <ol class="page_right_list trans_3">
                @foreach($messages as &$message)
                    <li>
                        <a href="{{ $message['url'] }}" title="{{ $message['name'] }}">{{ $message['name'] }}</a>
                        <span class="hits"> {{ $message['click'] }} ℃ </span>
                    </li>
                @endforeach
            </ol>
        </div>
        @php
            $messages = \App\CcForever\extend\MessagesExtend::messages(4, true, 0, 6, 2, $configs['cc_cms_substation_link']);
        @endphp
        <div class="hot_list">
            <h3>最近热文</h3>
            <ol class="page_right_list trans_3">
                @foreach($messages as &$message)
                    <li>
                        <a href="{{ $message['url'] }}" title="{{ $message['name'] }}">{{ $message['name'] }}</a>
                        <span class="hits"> {{ $message['click'] }} ℃ </span>
                    </li>
                @endforeach
            </ol>
        </div>
        @if(count($links))
            <h3>友情连接</h3>
            <div class="links trans_3">
                @foreach($links as &$link)
                    <a href="{{ $link['link'] }}" title="{{ $link['name'] }}" target="_blank">{{ $link['name'] }}</a>
                @endforeach
            </div>
        @endif
    </div>
    <div class="clear"></div>
</div>
@include('pc.footer')
</body>
</html>