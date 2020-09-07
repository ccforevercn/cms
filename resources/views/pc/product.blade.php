<!DOCTYPE html>
<html>
 <head>
  @include('pc.style')
 </head>
 <body>
 @include('pc.header')
  <section class="sidebar-v2__section"> 
   <div class="section__head"> 
    <div class="navbar sidebar-v2"> 
     <div class="container-fluid" id="sidebar-v2__accordion"> 
      <div class="navbar-header   "> 
       <button type="button" class="navbar-toggle collapsed sidebar-v2__button btn" data-toggle="collapse" data-target="#sidebar-v2__list2" aria-expanded="false" data-parent="#sidebar-v2__accordion"> <span class="glyphicon glyphicon-menu-hamburger"></span> </button> 
       <h1 class="dropdown-toggle sidebar-v2__h1 btn " data-toggle="collapse" data-target="#sidebar-v2__list3" data-parent="#sidebar-v2__accordion"> <button type="button" disabled="disabled"></button> <span>{{ $columnTop['name'] }} </span> </h1>
      </div>
      @if(isset($children) && is_array($children) && count($children))
       <div class="panel">
        <div class="collapse navbar-collapse" id="sidebar-v2__list2">
         <ul class="nav navbar-nav navbar-right" id="collapseTwo">
          <li class="on"><a href="{{ $column['url'] }}" title="{{ $column['name'] }}">二级栏目:</a></li>
          @foreach($children as $child)
           @if($child['unique'] === $column['unique'])
            <li class="on"><a href="{{ $child['url'] }}" title="{{ $child['name'] }}">{{ $child['name'] }}</a></li>
           @else
            <li><a href="{{ $child['url'] }}" title="{{ $child['name'] }}">{{ $child['name'] }}</a></li>
           @endif
          @endforeach
         </ul>
        </div>
       </div>
      @endif
     </div> 
    </div> 
   </div> 
  </section> 
  <div class="met_clear"></div> 
  <article class="sidebar-v2__article"> 
   <div class="met_article"> 
    <div class="product-v2"> 
     <ul class="product-v2__list list-unstyled">
         @foreach($messages as $message)
             <li class="col-lg-3 col-md-4 col-sm-6 v2-mtb15">
                 <a href="{{ $message['url'] }}" title="{{ $message['name'] }}" target="_self">
                     <img src="{{ $message['image'] }}" />
                 </a>
                 <div class="product-v2__list__box v2-ac product-v2__dg">
                     <h2>{{ $message['name'] }}</h2>
                     <ol class="list-unstyled v2-ac v2-mt15">
                         <li class="col-xs-4"><em>作者</em><span>{{ $message['writer'] }}</span></li>
                         <li class="col-xs-4"><em>点击量</em><span>{{ $message['click'] }}</span></li>
                         <li class="col-xs-4"><em>时间</em><span>{{ $message['time'] }}</span></li>
                     </ol>
                     <p class="v2-mt15 v2-lc"><i>●</i>{{ get_str_cn_str($message['description'], 0, 20, true, '...') }}</p>
                     <a href="{{ $message['url'] }}" title="{{ $message['name'] }}" class="v2-mt15" target="_self">查看详情<i class="glyphicon glyphicon-menu-right"></i></a>
                 </div>
             </li>
         @endforeach
     </ul> 
     <div class="met_clear"></div> 
     <div class="met_pager">
         @php echo \App\CcForever\extend\ColumnsExtend::page($column['unique'], $page, 3, '', '', '', '', '', $public['configs']['zy_cms_substation_link'], true, true, true); @endphp
     </div>
    </div> 
   </div> 
  </article> 
  <div class="met_clear"></div>
 @include('pc.footer')
 </body>
</html>