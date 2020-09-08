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
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed sidebar-v2__button btn" data-toggle="collapse" data-target="#sidebar-v2__list2" aria-expanded="false" data-parent="#sidebar-v2__accordion"> <span class="glyphicon glyphicon-menu-hamburger"></span> </button>
                    <h1 class="dropdown-toggle sidebar-v2__h1 btn " data-toggle="collapse" data-target="#sidebar-v2__list3" data-parent="#sidebar-v2__accordion"> <button type="button" disabled="disabled"></button> <span>搜索页</span> </h1>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="met_clear"></div>
<article class="sidebar-v2__article">
    <div class="met_article">
        <div class="product-v2">
            <ul class="product-v2__list list-unstyled"></ul>
            <div class="met_clear"></div>
        </div>
    </div>
</article>
<div class="met_clear"></div>
@include('pc.footer')
</body>
</html>