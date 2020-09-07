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
    <div id="showproduct"> 
     <div class="pshow v2-ac showproduct-v2__main">
      @if(is_array($message['images']) && count($message['images']))
      <div class="col-sm-6 showproduct-v2__left"> 
       <div class="met_box"> 
        <div class="met_imgshowbox showproduct-v2"> 
         <div class="my-simple-gallery slides tab-content">
             @foreach($message['images'] as $image)
                 <figure class="tab-pane fade  in active " id="pro_{{ $loop->iteration }}">
                     <a href="{{ $image }}"><img src="{{ $image }}" alt="{{ $message['name'] }}" /></a>
                     <figcaption>{{ $message['name'] }}</figcaption>
                 </figure>
             @endforeach
         </div> 
        </div> 
        <ul class="nav nav-pills showproduct-v2__list" role="tablist">
            @foreach($message['images'] as $image)
                @if($loop->first)
                    <li class="active">
                        <a href="#pro_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                            <img src="{{ $image }}" alt="{{ $message['name'] }}" width="70" height="70" />
                        </a>
                    </li>
                @else
                    <li>
                        <a href="#pro_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                            <img src="{{ $image }}" alt="{{ $message['name'] }}" width="70" height="70" />
                        </a>
                    </li>
                @endif
            @endforeach
        </ul> 
       </div> 
      </div>
     @endif
      <div class="col-sm-6 showproduct-v2__right"> 
       <div class="showproduct-v2__para"> 
        <h1 class="showproduct-v2__para__h1">{{ $message['name'] }}</h1>
        <ul class="v2-list showproduct-v2__para__ul"> 
         <li><span>作者</span>{{ $message['writer'] }}</li>
         <li><span>时间</span>{{ $message['time'] }}</li>
         <li><span>点击量</span>{{ $message['click'] }}</li>
        </ul> 
        <p class="desc">{{ $message['description'] }}</p>
       </div> 
      </div> 
     </div> 
     <div class="met_clear"></div> 
     <ol class="met_nav v2-ac showproduct-v2__nav"> 
      <li class="met_now"><a href="#mettab1">详细信息</a></li> 
     </ol> 
     <div class="met_nav_contbox"> 
      <div class="met_editor ">
       <div>
        <p>@php echo htmlspecialchars_decode($message['content']); @endphp</p>
        <div id="metinfo_additional"></div>
       </div>
       <div class="met_clear"></div>
      </div> 
     </div> 
     <div class="met_tools">
      <ul class="met_page">
          @if(count($message['pre']))
              <li class="met_page_preinfo">
                  <span>上一条</span>
                  <a href="{{ $message['pre']['url'] }}" title="{{ $message['pre']['name'] }}">{{ $message['pre']['name'] }}</a>
              </li>
          @else
              <li class="met_page_next"><span>上一条</span><a href="#">无上一篇</a></li>
          @endif
          @if(count($message['next']))
              <li class="met_page_next">
                  <span>下一条</span>
                  <a href="{{ $message['next']['url'] }}" title="{{ $message['next']['name'] }}">{{ $message['next']['name'] }}</a>
              </li>
          @else
              <li class="met_page_next"><span>下一条</span><a href="#">无下一篇</a></li>
          @endif
      </ul> 
     </div> 
    </div> 
   </div> 
  </article> 
  <div class="met_clear"></div>
 @include('pc.footer')
 </body>
</html>