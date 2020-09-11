<footer class="footer">
    <div class="container">
        <div class="clearfix">
            <div class="footer-col footer-col-copy">
                <ul class="footer-nav hidden-xs">
                    @foreach($navigation as &$nav)
                        @if($loop->first)
                            <li id="menu-item-109589" class="menu-item current-menu-item current_page_item menu-item-109589"><a href="{{ $nav['url'] }}" title="{{ $nav['name'] }}" aria-current="page">{{ $nav['name'] }}</a></li>
                        @else
                            <li class="menu-item menu-item-373"><a href="{{ $nav['url'] }}" title="{{ $nav['name'] }}">{{ $nav['name'] }}</a></li>
                        @endif
                    @endforeach
                </ul>
                <div class="copyright">
                    <p>@php echo $configs['zy_cms_copyright'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$configs['zy_cms_record_number']; @endphp</p>
                </div>
            </div>
            <div class="footer-col footer-col-sns"><div class="footer-sns"></div></div>
        </div>
    </div>
</footer>
<div class="action" style="top:50%;">
    <div class="a-box contact">
        <div class="contact-wrap">
            <h3 class="contact-title">联系我们</h3>
            <p>在线咨询：
                <a href="http://wpa.qq.com/msgrd?v=3&uin={{ $configs['zy_cms_service_qq'] }}&site=qq&menu=yes" target="_blank" rel="noopener">
                    <img class="alignnone" src="asset/index/images/button_111.gif" alt="{{ $configs['zy_cms_title'] }}" width="79" height="25" border="0" />
                </a>
            </p>
            <p>工作日：9:30-18:30，节假日休息</p>
        </div>
    </div>
    <div class="a-box wechat"><div class="wechat-wrap"><img src="{{ $configs['zy_cms_service_code'] }}" alt="{{ $configs['zy_cms_title'] }}"></div></div>
    <div class="a-box gotop" id="j-top" style="display: none;"></div>
</div>
<style>
    .footer{padding-bottom: 20px;}
</style>
<script type='text/javascript'>
    var _wpcom_js = {
        "slide_speed": "4000",
        "video_height": "482",
        "TCaptcha": {"appid": ""},
        "errors": { "require": "", "email": "", "pls_enter": "", "password": "", "passcheck": "", "phone": "", "sms_code": "", "captcha_verify": "", "captcha_fail": "", "nonce": "", "req_error": "" }
    };
</script>
<script type="text/javascript" src="/asset/index/js/main.js"></script>
<script type="text/javascript" src="/asset/index/js/wp-embed.js"></script>
@php echo $configs['zy_cms_pc_bottom_code']; @endphp