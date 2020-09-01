<footer class="v2_footer">
    <section class="v2-inner v2-ac">
        <div class="v2_footer_nav col-sm-6">
            @foreach($public['navigation'] as $navigation)
                @if($navigation['id'])
                    <a href="{{ $navigation['url'] }}" title="{{ $navigation['name'] }}">{{ $navigation['name'] }}</a>
                @endif
            @endforeach
        </div>
        <div class="v2_footer_text col-sm-6 v2-ac">
            <p>@php echo $public['configs']['zy_cms_copyright'].$public['configs']['zy_cms_record_number'] @endphp</p>
            <p>电话：{{ $public['configs']['zy_cms_phone'] }} {{ $public['configs']['zy_cms_tel'] }} QQ:{{ $public['configs']['zy_cms_qq'] }} Email:{{ $public['configs']['zy_cms_email'] }}</p>
            <div id="metinfo_91mb_Powered"></div>
            <p></p>
        </div>
        <div class="met_clear"></div>
    </section>
</footer>
<script src="/resources/js/jquery.min.js"></script>
<script src="/resources/js/bootstrap.min.js"></script>
@php echo $public['configs']['zy_cms_pc_bottom'] @endphp