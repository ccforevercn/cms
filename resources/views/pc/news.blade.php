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
       <h1 class="dropdown-toggle sidebar-v2__h1 btn " data-toggle="collapse" data-target="#sidebar-v2__list3" data-parent="#sidebar-v2__accordion"> <button type="button" disabled="disabled"></button> <span>新闻动态 </span> </h1> 
      </div> 
      <div class="panel"> 
       <div class="collapse navbar-collapse" id="sidebar-v2__list2"> 
        <ul class="nav navbar-nav navbar-right" id="collapseTwo"> 
         <li class="on"><a href="index.html">二级栏目:</a></li> 
        </ul> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
  </section> 
  <div class="met_clear"></div> 
  <article class="sidebar-v2__article"> 
   <div class="met_article"> 
    <div class="met_module2_list"> 
     <ul> 
      <li class="list_1"> <h2><a href="news_detail.html?25.html" title="装修收尾工程包括哪些项目你敢说了解吗?" target="_self"><i class="fa fa-caret-right"></i>装修收尾工程包括哪些项目你敢说了解吗?</a></h2> <span class="time">2016-02-24</span> </li> 
      <li class="list_1"> <h2><a href="news_detail.html?24.html" title="装修公司黑幕！预算报价陷阱你中枪了没？" target="_self"><i class="fa fa-caret-right"></i>装修公司黑幕！预算报价陷阱你中枪了没？</a></h2> <span class="time">2016-02-24</span> </li> 
      <li class="list_1"> <h2><a href="news_detail.html?23.html" title="低碳建筑首选天然石材 环保健康受欢迎" target="_self"><i class="fa fa-caret-right"></i>低碳建筑首选天然石材 环保健康受欢迎</a></h2> <span class="time">2016-01-20</span> </li> 
      <li class="list_1"> <h2><a href="news_detail.html?22.html" title="将文化融入设计 以设计推动创新" target="_self"><i class="fa fa-caret-right"></i>将文化融入设计 以设计推动创新</a></h2> <span class="time">2016-01-20</span> </li> 
      <li class="list_1"> <h2><a href="news_detail.html?1.html" title="卫生间装修省钱5大绝招!" target="_self"><i class="fa fa-caret-right"></i>卫生间装修省钱5大绝招!</a></h2> <span class="time">2013-09-02</span> </li> 
     </ul> 
     <div class="met_pager">
       第一页&nbsp;上一页&nbsp;下一页&nbsp;尾页&nbsp;8条/页&nbsp;共1页/5条&nbsp;当前第1页&nbsp; 
     </div> 
    </div> 
   </div> 
  </article> 
  <div class="met_clear"></div>
 @include('pc.footer')
 </body>
</html>