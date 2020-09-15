<!DOCTYPE html>
<html lang="zh-CN">
<head>
    @include('wap.style')
</head>
<body class="post-template-default single single-post postid-185570 single-format-standard el-boxed">
@include('wap.header')
<div id="wrap">
    <div class="wrap container">
        <div class="main">
            <ol class="breadcrumb entry-breadcrumb">
                <li class="home" property="itemListElement" typeof="ListItem"><i class="fa fa-map-marker"></i><meta property="position" content="1"></li>
                <li property="itemListElement" typeof="ListItem">@php echo $crumbs; @endphp<meta property="position" content="2"></li>
            </ol>
            <article id="post-185570" class="post-185570 post type-post status-publish format-standard hentry category-tuiguang category-yunying tag-871 tag-3713 special-tuiguang">
                <div class="entry">
                    <div class="entry-head">
                        <h1 class="entry-title">{{ $message['name'] }}</h1>
                        <div class="entry-info">
                            作者：{{ $message['writer'] }}<a class="nickname"></a>
                            <span class="dot">•</span>
                            <span>更新时间：{{ $message['time'] }}</span>
                            <span class="dot">•</span>
                            <span>阅读 {{ $message['click'] }}</span>
                        </div>
                    </div>
                    <div class="entry-content clearfix">@php echo htmlspecialchars_decode($message['content']); @endphp</div>
                    <div class="entry-footer">
                        @if(count($message['tags']))
                            <div class="entry-tag">
                                @foreach($message['tags'] as &$tag)
                                    <a href='{{ $message['url'] }}' title="{{ $tag }}">{{ $tag }}</a>
                                @endforeach
                            </div>
                        @endif
                        <div class="entry-page">
                            @if(count($message['pre']))
                                <div class="entry-page-prev j-lazy" style="background-image: url('/asset/index/images/lazy.png');">
                                    <a href="{{ $message['pre']['url'] }}" title="{{ $message['pre']['name'] }}"><span>{{ $message['pre']['name'] }}</span></a>
                                    <div class="entry-page-info">
                                        <span class="pull-left">&laquo; 上一篇</span>
                                    </div>
                                </div>
                            @endif
                            @if(count($message['next']))
                                <div class="entry-page-next j-lazy" style="background-image: url('/asset/index/images/lazy.png');">
                                    <a href="{{ $message['next']['url'] }}" title="{{ $message['next']['name'] }}"><span>{{ $message['next']['name'] }}</span></a>
                                    <div class="entry-page-info">
                                        <span class="pull-right">下一篇  &raquo;</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @php
                            $messages = \App\CcForever\extend\MessagesExtend::messages(3, true, 0, 8, 2, $configs['zy_cms_substation_link']);
                        @endphp
                        @if($messages)
                            <h3 class="entry-related-title">相关推荐</h3>
                            <ul class="entry-related clearfix">
                                @foreach($messages as &$message)
                                    <li><a href="{{ $message['url'] }}" title="{{ $message['name'] }}">{{ $message['name'] }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </article>
        </div>
        @include('wap.right')
    </div>
</div>
@include('wap.footer')
</body>
</html>