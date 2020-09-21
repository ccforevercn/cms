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
        <div class="detail_container trans_3">
            <h1>{{ $message['name'] }}</h1>
            <div class="date_hits"><span><i>发布时间：</i>{{ $message['time'] }}</span><span><i>热度：</i> {{ $message['click'] }}℃</span></div>
            <div class="content">@php echo htmlspecialchars_decode($message['content']); @endphp</div>
            @if(count($message['tags']))
                @foreach($message['tags'] as &$tag)
                    <div class="keywords"><p>{{ $tag }}</p></div>
                @endforeach
            @endif
            <div class="prev_next">
                @if(count($message['pre']))
                <div class="prev">上一篇：<a href="{{ $message['pre']['url'] }}" title="{{ $message['pre']['name'] }}">{{ $message['pre']['name'] }}</a></div>
                @endif
                    @if(count($message['next']))
                <div class="next">下一篇：<a href="{{ $message['next']['url'] }}" title="{{ $message['next']['name'] }}">{{ $message['next']['name'] }}</a></div>
                    @endif
                <div class="clear"></div>
            </div>
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
            $messages = \App\CcForever\extend\MessagesExtend::messages($column['unique'], false, 0, 8, 3, $configs['cc_cms_substation_link']);
        @endphp
        <div class="hot_list">
            <h3>相关文章</h3>
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