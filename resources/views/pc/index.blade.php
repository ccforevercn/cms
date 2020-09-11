<!DOCTYPE html>
<html lang="zh-CN">
<head>
    @include('pc.style')
</head>
<body class="home blog el-boxed">
@include('pc.header')
<div id="wrap">
    <div class="wrap container">
        <div class="main">
            <div class="slider-wrap clearfix">
                <div class="main-slider wpcom-slider swiper-container pull-left">
                    <ul class="swiper-wrapper">
                        @foreach($banners as &$banner)
                            <li class="swiper-slide">
                                <a href="{{ $banner['link'] }}" title="{{ $banner['name'] }}"><img src="{{ $banner['image'] }}" alt="{{ $banner['name'] }}"></a>
                                <h3 class="slide-title"><a href="{{ $banner['link'] }}" title="{{ $banner['name'] }}"></a></h3>
                            </li>
                        @endforeach
                    </ul>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev swiper-button-white"></div>
                    <div class="swiper-button-next swiper-button-white"></div>
                </div>
            </div>
            <div class="sec-panel topic-recommend">
                <div class="sec-panel-head">
                    <h2><span></span><small></small><a href="javascript:;" class="more">全部专题</a></h2>
                </div>
                <div class="sec-panel-body">
                    <ul class="list topic-list">
                        <li class="topic">
                            <a class="topic-wrap" href="javascript:;">
                                <div class="cover-container">
                                    <img class="j-lazy" src="" title="名称">
                                </div>
                                <span>名称</span>
                            </a>
                        </li>
                        <li class="topic">
                            <a class="topic-wrap" href="javascript:;">
                                <div class="cover-container">
                                    <img class="j-lazy" src="" title="名称">
                                </div>
                                <span>名称</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="sec-panel main-list">
                @php
                    $appointed = \App\CcForever\extend\ColumnsExtend::appointed([3, 4], $configs['zy_cms_substation_link']);
                    $messages = \App\CcForever\extend\MessagesExtend::messages(4, true, 0, 8, 3, $configs['zy_cms_substation_link']);
                @endphp
                <div class="sec-panel-head">
                    <ul class="list tabs j-newslist">
                        <li class="tab active"><a data-id="0" href="javascript:;">最新文章</a></li>
                        @foreach($appointed as &$column)
                            <li class="tab"><a href="javascript:;">{{ $column['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <ul class="post-loop post-loop-default tab-wrap clearfix active">
                    @foreach($messages as &$message)
                        <li class="item">
                            <div class="item-img">
                                <a class="item-img-inner" href="{{ $message['url'] }}" title="{{ $message['name'] }}">
                                    <img class="j-lazy" src="{{ $message['image'] }}" width="480" height="300" alt="{{ $message['name'] }}">
                                </a>
                                <a class="item-category" href="{{ $message['url'] }}" title="{{ $message['name'] }}">分享</a>
                            </div>
                            <div class="item-content">
                                <h2 class="item-title"><a href="{{ $message['url'] }}" title="{{ $message['name'] }}">{{ $message['name'] }}</a></h2>
                                <div class="item-excerpt"><p>&nbsp;{{ get_str_cn_str($value['description'], 0, 30, true, '...') }}</p></div>
                                <div class="item-meta">
                                    <span class="item-meta-li date">{{ $message['time'] }}</span>
                                    <span class="item-meta-li views" title="{{ $message['name'] }}"><i class="fa fa-eye"></i>{{ $message['click'] }}</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @foreach($appointed as $column)
                    @php
                        $messages = \App\CcForever\extend\MessagesExtend::messages($column['unique'], true, 0, 8, 1, $configs['zy_cms_substation_link']);
                    @endphp
                @if(count($messages))
                    <ul class="post-loop post-loop-default tab-wrap clearfix">
                        @foreach($messages as &$message)
                            <li class="item">
                                <div class="item-img">
                                    <a class="item-img-inner" href="{{ $message['url'] }}" title="{{ $message['name'] }}">
                                        <img class="j-lazy" src="{{ $message['image'] }}"width="480" height="300" alt="{{ $message['name'] }}">
                                    </a>
                                    <a class="item-category" href="{{ $message['url'] }}" title="{{ $message['name'] }}">分享</a>
                                </div>
                                <div class="item-content">
                                    <h2 class="item-title"><a href="{{ $message['url'] }}" title="{{ $message['name'] }}">{{ $message['name'] }}</a></h2>
                                    <div class="item-excerpt"><p>&nbsp;{{ get_str_cn_str($message['description'], 0, 30, true, '...') }}</p></div>
                                    <div class="item-meta">
                                        <span class="item-meta-li date">{{ $message['time'] }}</span>
                                        <span class="item-meta-li views" title="{{ $message['name'] }}"><i class="fa fa-eye"></i>{{ $message['click'] }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @endif
                @endforeach
            </div>
        </div>
        @include('pc.right')
    </div>
    @if(count($links))
        <div class="container hidden-xs j-partner">
            <div class="sec-panel">
                <div class="sec-panel-head">
                    <h2><span>友情链接</span></h2>
                </div>
                <div class="sec-panel-body">
                    <div class="list list-links">
                        @foreach($links as &$link)
                            <a href="{{ $link['link'] }}" title="{{ $link['name'] }}" target="_blank">{{ $link['name'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@include('pc.footer')
</body>
</html>