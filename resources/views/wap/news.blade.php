<!DOCTYPE html>
<html lang="zh-CN">
<head>
  @include('pc.style')
</head>
<body class="archive category category-tuiguang category-53 el-boxed">
@include('pc.header')
<div id="wrap">
  <div class="container wrap">
    <div class="main">
      <div class="sec-panel sec-panel-default">
        <div class="sec-panel-head"><h1><span>{{ $columnTop['name'] }}</span></h1></div>
        <ul class="post-loop post-loop-default cols-0 clearfix">
          @foreach($messages as &$message)
            <li class="item">
              <div class="item-img">
                <a class="item-img-inner" href="{{ $message['url'] }}" title="{{ $message['name'] }}">
                  <img class="j-lazy" src="{{ $message['image'] }}" width="480" height="300" alt="{{ $message['name'] }}">
                </a>
                <a class="item-category" href="{{ $message['url'] }}" title="{{ $message['name'] }}">{{ $message['name'] }}</a>
              </div>
              <div class="item-content">
                <h2 class="item-title"><a href="{{ $message['url'] }}" title="{{ $message['name'] }}">{{ $message['name'] }}</a></h2>
                <div class="item-excerpt"><p>&nbsp;&nbsp;&nbsp;&nbsp;{{ get_str_cn_str($message['description'], 0, 88, true, '...') }}</p></div>
                <div class="item-meta">
                  <span class="item-meta-li date">{{ $message['time'] }}</span>
                  <span class="item-meta-li views" title="{{ $message['name'] }}"><i class="fa fa-eye"></i>{{ $message['click'] }}</span>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
        <div class="pagination clearfix">
          @php echo \App\CcForever\extend\ColumnsExtend::page($column['unique'], $page, 3, '', '', '', '', '', $configs['zy_cms_substation_link'], true, true, true); @endphp
        </div>
      </div>
    </div>
    @include('pc.right')
 </div>
</div>
@include('pc.footer')
</body>
</html>