<!DOCTYPE html>
<html lang="en">
<head>
    @include('wap.style')
</head>
<body>
@include('wap.header')
<div class="main breadcrumb_nav trans_3"><span class="layui-breadcrumb" lay-separator="—">@php echo $crumbs; @endphp</span></div>
<div class="main">
    <div class="page_left">
        <ul class="page_left_list">
            @foreach($messages as &$message)
                @if(strlen($message['image']))
                    <li>
                        <a href="{{ $message['url'] }}" title="{{ $message['name'] }}" class="pic">
                            <img class="lazy" src="{{ $message['image'] }}" alt="{{ $message['name'] }}">
                        </a>
                        <h2 class="title"><a href="{{ $message['url'] }}" title="{{ $message['name'] }}"><span class="top">热门</span></a></h2>
                        <div class="date_hits">
                            <span>{{ $message['time'] }}</span>
                            <span><a href="javascript:void(0);">{{ $message['cname'] }}</a></span>
                            <span class="hits"><i class="layui-icon" title="点击量">&#xe62c;</i> {{ $message['click'] }} ℃</span>
                        </div>
                        <div class="desc">{{ get_str_cn_str($message['description'], 0, 66, true, '...') }}</div>
                    </li>
                @else
                    <li class="no_pic">
                        <h2 class="title"><a href="{{ $message['url'] }}" title="{{ $message['name'] }}"><span class="top">热门</span></a></h2>
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
        <div id="page">
            @php echo \App\CcForever\extend\ColumnsExtend::page($column['unique'], $page, 3, '', '', '', '', '', $configs['cc_cms_substation_link'], true, true, true); @endphp
        </div>
    </div>
    <div class="page_right">
        <div class="second_categorys_container">
            <h3>栏目导航</h3>
            <ol class="seond_category trans_3">
                @foreach($children as &$child)
                    @if($column['unique'] === $child['unique'])
                        <li class="selected">
                            <a href="{{ $child['url'] }}" class="layui-btn layui-btn-primary trans_1">{{ $child['name'] }}</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ $child['url'] }}" class="layui-btn layui-btn-primary trans_1">{{ $child['name'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </div>
        @php
            $messages = \App\CcForever\extend\MessagesExtend::messages(3, true, 0, 8, 2, $configs['cc_cms_substation_link']);
        @endphp
        <div class="recommend_list">
            <h3>推荐文章</h3>
            <ol class="page_right_list trans_3">
                @foreach($messages as &$message)
                    <li><a href="{{ $message['url'] }}" title="{{ $message['name'] }}">{{ $message['name'] }}</a><span class="hits"> {{ $message['click'] }} ℃ </span></li>
                @endforeach
            </ol>
        </div>
        @php
            $messages = \App\CcForever\extend\MessagesExtend::messages(3, true, 0, 8, 3, $configs['cc_cms_substation_link']);
        @endphp
        <div class="hot_list">
            <h3>最近热文</h3>
            <ol class="page_right_list trans_3">
                @foreach($messages as &$message)
                    <li><a href="{{ $message['url'] }}" title="{{ $message['name'] }}">{{ $message['name'] }}</a><span class="hits"> {{ $message['click'] }} ℃ </span></li>
                @endforeach
            </ol>
        </div>
        <div class="mobile_qrcode_container">
            <h3>手机扫码访问</h3>
            <div class="mobile_qrcode wechat_qrcode trans_3">
                <style type="text/css">
                    #qrcode{width:100%;height: 100%;}
                    #qrcode img{width:100%;height: 100%;}
                </style>
                <div id="qrcode">
                    <img alt="Scan me!" src="{{ $configs['cc_cms_service_code'] }}" style="display: block;">
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
@include('wap.footer')
</body>
</html>