<ul class="layui-fixbar">
    <li class="layui-icon qr_code">&#xe63b;<img class="qr_code_pic" src="{{ $configs['cc_cms_service_code'] }}" alt="微信二维码"></li>
    <li class="layui-icon layui-fixbar-top" id="to_top">&#xe604;</li>
</ul>
<div class="layui-footer footer">
    <div class="main index_main">
        <p>@php echo $configs['cc_cms_copyright']@endphp</p>
        <p><a href="/sitemap.xml">网站地图</a></p>
        <p class="beian">@php echo $configs['cc_cms_record_number']@endphp</p>
    </div>
</div>
<script type="text/javascript">
    layui.use(['form','element'], function(){
        var $ = layui.jquery;
        //左边导航点击显示
        $('.left_nav_btn').click(function(){
            $('.left_nav_mask').show();
            $('.left_nav').addClass('left_nav_show');
        });
        //左边导航点击消失
        $('.left_nav_mask').click(function(){
            $('.left_nav').removeClass('left_nav_show');
            $('.left_nav_mask').hide();
        });

        //搜索框特效
        $('.header .head_search .search_input').focus(function(){
            $('.header .head_search').addClass('focus');
            $(this).attr('placeholder','输入关键词搜索');
        });
        $('.header .head_search .close').click(function(){
            $('.header .head_search').removeClass('focus');
            $('.header .head_search .search_input').attr('placeholder','搜索');
        });
        //回到顶部
        $("#to_top").click(function() {
            $("html,body").animate({scrollTop:0}, 200);
        });
        $(document).scroll(function(){
            var	scroll_top = $(document).scrollTop();
            if(scroll_top > 500){
                $("#to_top").show();
            }else{
                $("#to_top").hide();
            }
        });
    });
</script>
@php echo $configs['cc_cms_pc_bottom_code'].ws_script($configs['cc_cms_service_ws_url']); @endphp