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
       <h1 class="dropdown-toggle sidebar-v2__h1 btn " data-toggle="collapse" data-target="#sidebar-v2__list3" data-parent="#sidebar-v2__accordion"> <button type="button" disabled="disabled"></button> <span>联系我们 </span> </h1> 
      </div> 
      <div class="panel"> 
       <div class="collapse navbar-collapse" id="sidebar-v2__list2"> 
        <ul class="nav navbar-nav navbar-right" id="collapseTwo"> 
         <li class="on"><a href="index.html">二级栏目:</a></li> 
         <li><a href="/m342/?Col12/">人才招聘</a></li> 
         <li><a href="/m342/?Col4/">在线留言</a></li> 
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
    <div class="met_editor met_module1"> 
     <p>襄阳市古典家具责任有限公司&nbsp;</p>
     <p>&middot; 手机：1888888888&nbsp;</p>
     <p>&middot; 电话：0710-88888888&nbsp;</p>
     <p>&middot; 传真：0710-88888888&nbsp;</p>
     <p>&middot; 邮箱：253819801@qq.com&nbsp;</p>
     <p>&middot; 地址：中国襄阳市某某区某某开发区&nbsp;</p>
     <p>&middot; 邮编：441100</p> 
     <div class="clear"></div> 
    </div> 
   </div> 
  </article> 
  <div class="met_clear"></div>
 @include('pc.footer')
 </body>
</html>