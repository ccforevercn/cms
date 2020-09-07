<!DOCTYPE html>
<html>
 <head>
  @include('pc.style')
 </head> 
 <body>
 @include('pc.header')
 @php
    $product = \App\CcForever\extend\ColumnsExtend::column(3, false, $public['configs']['zy_cms_substation_link']);
    $productMessage = \App\CcForever\extend\MessagesExtend::messages(3, true, 0, 4, 1, $public['configs']['zy_cms_substation_link']);
 @endphp
 @if(count($product))
  <section class="v2-product"> 
   <div class="v2-title"> 
    <h2 class="v2-title__h2 v2-inner v2-ac"><span>{{ $product['name'] }}</span> </h2>
   </div> 
   <div class="v2-inner v2-product__box">
       @if(count($productMessage))
    <ul class="v2-list v2-ac">
        @foreach($productMessage  as $message)
            <li class="col-lg-3 col-sm-6">
                <a href="{{ $message['url'] }}" title="{{ $message['name'] }}" target="_self">
                    <img src="{{ $message['image'] }}" title="{{ $message['name'] }}" alt="{{ $message['name'] }}" />
                    <h2 class="v2-product__box__h2 v2-to"><i>+</i>{{ $message['name'] }}</h2>
                </a>
            </li>
        @endforeach
    </ul>
       @endif
    <a href="{{ $product['url'] }}" title="{{ $product['name'] }}" class="v2-product__more"><span>SEE MORE</span></a>
   </div> 
  </section>
  @endif
 @php
     $news = \App\CcForever\extend\ColumnsExtend::column(4, false, $public['configs']['zy_cms_substation_link']);
     $newsMessageTop = \App\CcForever\extend\MessagesExtend::messages(4, true, 0, 1, 1, $public['configs']['zy_cms_substation_link']);
     $newsMessage = \App\CcForever\extend\MessagesExtend::messages(4, true, 1, 3, 1, $public['configs']['zy_cms_substation_link']);
 @endphp
 @if(count($news))
  <section class="v2-news"> 
   <div class="v2-title"> 
    <h2 class="v2-title__h2 v2-inner v2-ac"><span>{{ $news['name'] }}</span>
        <a href="{{ $news['url'] }}" title="{{ $news['name'] }}">MORE</a> </h2>
   </div> 
   <div class="v2-news__box v2-inner v2-ac">
       @foreach($newsMessageTop as $message)
           <div class="col-sm-6 v2-news__left">
               <a href="{{ $message['url'] }}" title="{{ $message['name'] }}" class="a-img" target="_self">
                   <img src="{{ $message['image'] }}" alt="{{ $message['name'] }}"/>
               </a>
               <a href="{{ $message['name'] }}" title="{{ $message['name'] }}" class="a-title v2-ac" target="_self">
                   <span class="v2-to"><p>{{ $message['time'] }}</p>{{ $message['name'] }}</span> </a>
               <p>{{ $message['description'] }}</p>
           </div>
       @endforeach
    <div class="col-sm-6 v2-news__right"> 
     <div class="v2-news__right__box">
         @foreach($newsMessage as $message)
             <a href="{{ $message['url'] }}" title="{{ $message['name'] }}" class="v2-news__right__a v2-ac" target="_self">
                 <i>0{{ $loop->iteration }}</i>
                 <span><h3 class="v2-to"><i>{{ $message['time'] }}</i>{{ $message['name'] }}</h3><p class="v2-lc"> {{ $message['description'] }}</p> </span>
             </a>
         @endforeach
     </div> 
    </div> 
   </div> 
  </section>
  @endif
 @php
  $about = \App\CcForever\extend\ColumnsExtend::column(2, false, $public['configs']['zy_cms_substation_link']);
  $aboutChildren = \App\CcForever\extend\ColumnsExtend::children(2, 2, $public['configs']['zy_cms_substation_link']);
 @endphp
 @if(count($about))
  <section class="v2-contact"> 
   <div class="v2-title"> 
    <h2 class="v2-title__h2 v2-inner v2-ac"> <span>{{ $about['name'] }}</span> </h2>
   </div> 
   <div class="v2-inner v2-ac v2-contact__make">{{ $about['name_alias'] }}</div>
   <div class="v2-inner v2-ac">
       @foreach($aboutChildren as $child)
           @if($loop->first)
               <div class="col-sm-8 col-xs-12 v2-ac v2-contact_right">
                   <h3 class="v2-to"><a href="{{ $child['url'] }}" title="{{ $child['name'] }}">MORE +</a>{{ $child['name'] }}</h3>
                   <div class="v2-contact--color">
                       <p>{{ $child['description'] }}</p>
                   </div>
               </div>
           @else
               <div class="col-sm-4 col-xs-12 v2-ac v2-contact_left">
                   <h3 class="v2-to">{{ $child['name'] }}</h3>
                   <div class="v2-contact--color">
                       <p><span style="color: rgb(99, 99, 99); font-family: 'Microsoft YaHei', 华文细黑, Helvetica, Arial, sans-serif; font-size: 12px; line-height: 22px;">{{ $child['description'] }}</span></p>
                   </div>
               </div>
           @endif
       @endforeach
    <div class="met_clear"></div> 
   </div> 
  </section>
  @endif
 @if(count($links))
  <section class="v2-link"> 
   <div class="v2-title"><h2 class="v2-title__h2 v2-inner v2-ac"><span>友情链接</span></h2></div>
   <dl class="v2-inner"> 
     <dd>
       <div class="tem_txt">
        @foreach($links as $link)
         @if($link['follow'])
          <a href="{{ $link['link'] }}" target="_blank" title="{{ $link['name'] }}">{{ $link['name'] }}</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         @else
          <a ref="nofollow" href="{{ $link['link'] }}" target="_blank" title="{{ $link['name'] }}"> {{ $link['name'] }}</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         @endif
        @endforeach
       </div>
     </dd>
   </dl>
  </section>
  @endif
 @include('pc.footer')
 </body>
</html>