<!DOCTYPE html>
<html lang="zh-CN">
<head>
    @include('pc.style')
</head>
<body class="post-template-default single single-post postid-13805 single-format-standard el-boxed">
@include('pc.header')
<div id="wrap">
    <div class="wrap container">
        <div class="main main-full">
            <ol class="breadcrumb entry-breadcrumb">
                <li class="home" property="itemListElement" typeof="ListItem"><i class="fa fa-map-marker"></i><meta property="position" content="1"></li>
                <li property="itemListElement" typeof="ListItem">@php echo $crumbs; @endphp<meta property="position" content="2"></li>
            </ol>
            <article id="post-13805" class="post-13805 post type-post status-publish format-standard hentry category-tuijian">
                <div class="entry">
                    <div class="entry-head"><h1 class="entry-title">{{ $columnTop['name'] }}</h1></div>
                    <div class="entry-content clearfix">@php echo htmlspecialchars_decode($column['content']) @endphp </div>
                    @php
                        $messages = \App\CcForever\extend\MessagesExtend::messages(3, true, 0, 10, 2, $configs['zy_cms_substation_link']);
                    @endphp
                    @if(count($messages))
                        <div class="entry-footer">
                            <h3 class="entry-related-title">相关推荐</h3>
                            <ul class="entry-related clearfix">
                                @foreach($messages as &$message)
                                    <li><a href="{{ $message['url'] }}" title="{{ $message['name'] }}">{{ $message['name'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </article>
        </div>
    </div>
</div>
@include('pc.footer')
</body>
</html>