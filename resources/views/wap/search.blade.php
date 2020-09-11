<!DOCTYPE html>
<html lang="zh-CN">
<head>
  @include('index.default.style')
</head>
<body class="archive category category-tuiguang category-53 el-boxed">
@include('index.default.header')
<div id="wrap">
  <div class="container wrap">
    <div class="main">
      <div class="sec-panel sec-panel-default">
        <div class="sec-panel-head">
          <h1><span>{{ $search }}</span></h1>
        </div>
        <ul class="post-loop post-loop-default cols-0 clearfix">
          @foreach($article as $value)
            <li class="item">
              <div class="item-img">
                <a class="item-img-inner" href="{{ $value['url'] }}" title="{{ $value['name'] }}">
                  <img class="j-lazy" src="{{ $value['litpic'] }}" width="480" height="300" alt="{{ $value['name'] }}">
                </a>
                <a class="item-category" href="{{ $value['url'] }}" title="{{ $value['name'] }}">{{ $value['name'] }}</a>
              </div>
              <div class="item-content">
                <h2 class="item-title">
                  <a href="{{ $value['url'] }}" title="{{ $value['name'] }}">{{ $value['name'] }}</a>
                </h2>
                <div class="item-excerpt">
                  <p>&nbsp;&nbsp;&nbsp;&nbsp;{{ getStrCnStr($value['description'], 0, 88) }}...</p>
                </div>
                <div class="item-meta">
                  <span class="item-meta-li date">{{ tranTime($value['updatetime']) }}</span>
                  <span class="item-meta-li views" title="{{ $value['name'] }}">
                    <i class="fa fa-eye"></i>{{ $value['click'] }}</span>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    @include('index.default.right')
 </div>
</div>
@include('index.default.footer')
</body>
</html>