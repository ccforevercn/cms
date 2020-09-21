<!DOCTYPE html>
<html lang="en">
<head>
    @include('pc.style')
</head>
<body>
@include('pc.header')
<div class="main breadcrumb_nav trans_3"><span class="layui-breadcrumb" lay-separator="—">@php echo $crumbs; @endphp</span></div>
<div class="main">
    <div class="page_left">
        <div class="detail_container trans_3">
            <h1>{{ $columnTop['name'] }}</h1>
            <div class="line"></div>
            <div class="content">@php echo htmlspecialchars_decode($column['content']) @endphp</div>
            <div class="prev_next"></div>
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
@include('pc.footer')
</body>
</html>