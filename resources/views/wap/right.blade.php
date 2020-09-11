<aside class="sidebar">
    <div id="search-7" class="widget widget_search">
        <h3 class="widget-title">搜索干货</h3>
        <form class="search-form" action="/search.html" method="get">
            <input type="text" class="keyword" name="search" placeholder="输入关键词搜索..." value="">
            <input type="submit" class="submit" value="&#xf002;">
        </form>
    </div>
    @php
$messagesHot = \App\CcForever\extend\MessagesExtend::messages(3, true, 0, 8, 2, $configs['zy_cms_substation_link']);
    @endphp
    @if(count($messagesHot))
        <div id="wpcom-post-thumb-8" class="widget widget_post_thumb">
            <h3 class="widget-title">推荐文章</h3>
            <ul>
                @foreach($messagesHot as &$message)
                    <li class="item">
                        <div class="item-img">
                            <a class="item-img-inner" href="{{ $message['name'] }}" title="{{ $message['name'] }}">
                                <img class="j-lazy" src="{{ $message['image'] }}" width="480" height="300" alt="{{ $message['name'] }}">
                            </a>
                        </div>
                        <div class="item-content">
                            <p class="item-title"><a href="{{ $message['url'] }}" title="{{ $message['name'] }}">{{ $message['name'] }}</a></p>
                            <p class="item-date">{{ $message['time'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @php
        $messagesIndex = \App\CcForever\extend\MessagesExtend::messages(3, true, 0, 8, 1, $configs['zy_cms_substation_link']);
    @endphp
    @if(count($messagesIndex))
        <div id="wpcom-post-thumb-3" class="widget widget_post_thumb">
            <h3 class="widget-title">经典文章</h3>
            <ul>
                @foreach($messagesIndex as &$message)
                    <li class="item">
                        <div class="item-img">
                            <a class="item-img-inner" href="{{ $message['name'] }}" title="{{ $message['name'] }}">
                                <img class="j-lazy" src="{{ $message['image'] }}" width="480" height="300" alt="{{ $message['name'] }}">
                            </a>
                        </div>
                        <div class="item-content">
                            <p class="item-title"><a href="{{ $message['url'] }}" title="{{ $message['name'] }}">{{ $message['name'] }}</a></p>
                            <p class="item-date">{{ $message['time'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(strlen($configs['zy_cms_heat_word']))
        <div id="tag_cloud-3" class="widget widget_tag_cloud">
            <h3 class="widget-title">热门标签</h3>
            <div class="tagcloud">
                @php
                    $heatWords = explode('|', $configs['zy_cms_heat_word']);
                @endphp
                @foreach($heatWords as $heatWord)
                    @php echo $heatWord; @endphp
                @endforeach
            </div>
        </div>
    @endif
    <div id="wpcom-image-ad-5" class="widget widget_image_ad">
        <a href="javascript:;"><img class="j-lazy" src="{{ $configs['zy_cms_pc_bottom_logo'] }}"/></a>
    </div>
</aside>