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
    <section class="met_module2"> 
     <h1 class="met_title">{{ $message['name'] }}</h1>
     <div class="met_infos"> 
      <span class="met_time">{{ $message['time'] }}</span>
      <span class="met_source"><a href="#" title="#">#</a></span> 
      <span class="met_hits">已读 <span class="met_Clicks">{{ $message['click'] }}</span></span>
     </div> 
     <div class="met_editor">
      <div>
       <p>@php echo htmlspecialchars_decode($message['content']); @endphp</p>
       <div id="metinfo_additional"></div>
      </div>
      <div class="met_clear"></div>
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
    </section> 
   </div> 
  </article> 
  <div class="met_clear"></div>
 @include('pc.footer')
 </body>
</html>