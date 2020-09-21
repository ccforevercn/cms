<!DOCTYPE html>
<html lang="en">
<head>
    @include('wap.style')
</head>
<body>
@include('wap.header')
<div class="main breadcrumb_nav trans_3"><span id="search"></span></div>
<div class="main">
    <div class="page_left">
        <ul class="page_left_list" id="search-list"></ul>
    </div>
    <div class="page_right">
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