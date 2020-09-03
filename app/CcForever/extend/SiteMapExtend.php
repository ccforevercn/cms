<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/3
 */

namespace App\CcForever\extend;

use App\Repositories\ColumnsRepository;
use App\Repositories\ConfigMessageRepository;
use App\Repositories\MessagesRepository;

/**
 * SiteMap
 *
 * Class SiteMapExtend
 * @package App\CcForever\extend
 */
class SiteMapExtend
{

    // 网站地图html文件名称
    private static $html = 'sitemap.html';

    // 网站地图xml文件名称
    private static $xml = 'sitemap.xml';

    // 网站地图txt文件名称
    private static $txt = 'sitemap.txt';

    /**
     * 缓存网站地图HTML
     *
     * @return bool
     */
    public static function html(): bool
    {
        // 实例化ColumnsRepository
        $columnsRepository = new ColumnsRepository();
        // 获取导航
        $navigation = $columnsRepository::navigation();
        // 网站名称 网站地址 网站LOGO 版权
        $configMessageRepository = new ConfigMessageRepository();
        $config = $configMessageRepository::batch(['webname', 'website', 'weblogopc', 'copyright']);
        $name = config('app.name'); // 网站名称
        $url = config('app.url'); // 网站地址
        $logo = ''; // 网站logo
        $copyright = ''; // 版权
        if(count($config)){
            foreach ($config as &$item){
                if($item['select'] === 'webname'){
                    $name = $item['value'];
                }
                if($item['select'] === 'website'){
                    $url = $item['value'];
                }
                if($item['select'] === 'weblogopc'){
                    $logo = $item['value'];
                }
                if($item['select'] === 'copyright'){
                    $copyright = $item['value'];
                }
            }
        }
        $copyright = htmlspecialchars_decode($copyright);
        $copyright = str_replace('&nbsp;', ' ', $copyright);
        $html = ''; // html
        $html .= '<html>';
        $html .= '<head>';
        $html .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        $html .= '<title>';
        $html .= $name;
        $html .= '</title>';
        $html .= '</head>';
        $html .= '<body>';
        $html .= '<div class="header">';
        $html .= '<div class="title">';
        $html .= '<h1><a href="'.$url.'" title="'.$name.'"><img src="'.$logo.'" alt="'.$name.'"/></a> </h1>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="center">';
        $html .= '<div class="title">';
        $html .= '<h2>网站地图</h2>';
        $html .= '<span class="more"><a href="'.$url.'" title="'.$name.'">返回首页</a></span>';
        foreach ($navigation as $value){
            $html .= '<div class="catalog">';
            $html .= '<h3><a href="'. $value['url'] .'">'. $value['name'] .'</a></h3>';
            $html .= '<ul class="children">';
            if(count($value['children'])){
                foreach ($value['children'] as $item){
                    $html .= '<li><a href="'.  $item['url'].'">'. $item['name'] .'</a></li>';
                }
            }
            $html .= '</ul>';
            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="footer">';
        $html .= '<p class="copyright">';
        $html .= $copyright;
        $html .= '</p>';
        $html .= '</div>';
        $html .= '</body>';
        $html .= '</html>';
        // 文件路径+文件名
        $path = public_path(DIRECTORY_SEPARATOR).self::$html;
        // 打开文件，并且删除之前的数据
        $file = @fopen($path, 'w+');
        if(!$file) return false;
        // 写入内容
        fwrite($file, $html);
        // 关闭文件
        fclose($file);
        return true;
    }

    /**
     * 缓存网站地址xml
     *
     * @return bool
     */
    public static function xml(): bool
    {
        // 实例化ConfigMessageRepository获取配置
        $configMessageRepository = new ConfigMessageRepository();
        // 内链和外链的优先级  页面内容更改频率
        $config = $configMessageRepository::batch(['website', 'priority', 'changefreq']);
        $priority = '0.6'; // 内链和外链的优先级
        $changefreq = 'monthly'; // 页面内容更改频率
        $url = config('app.url'); // 网站地址
        if(count($config)){
            foreach ($config as &$item){
                if($item['select'] === 'website'){
                    $url = $item['value'];
                }
                if($item['select'] === 'priority'){
                    $priority = $item['value'];
                }
                if($item['select'] === 'changefreq'){
                    $changefreq = $item['value'];
                }
            }
        }
        $xml = '';
        $xml .= '<?xml version="1.0" encoding="utf-8" ?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        // 实例化ColumnsRepository获取栏目
        $columnsRepository = new ColumnsRepository();
        // 获取页面栏目编号和页面
        $columns = $columnsRepository::pageColumnsIds(['id', 'page']);
        foreach ($columns as &$column){
            $xml .= '<url>';
            $xml .= '<loc>'. $url .'/'.$column['page'] . '/' .$column['id'].page_suffix_message().'</loc>';
            $xml .= '<lastmod>'.date("Y-m-d", time()).'</lastmod>';
            $xml .= '<changefreq>'.$changefreq.'</changefreq>';
            $xml .= '<priority>'.$priority.'</priority>';
            $xml .= '</url>';
        }
        // 信息
        $messagesRepository = new MessagesRepository();
        $messages = $messagesRepository::siteMapMessages();
        foreach ($messages as &$message){
            $xml .= '<url>';
            $xml .= '<loc>'. $url .'/'. $message['page'] . '/' .$message['id'].page_suffix_message().'</loc>';
            $xml .= '<lastmod>'.date("Y-m-d", time()).'</lastmod>';
            $xml .= '<changefreq>'.$changefreq.'</changefreq>';
            $xml .= '<priority>'.$priority.'</priority>';
            $xml .= '</url>';
        }
        $xml .='</urlset>';
        // 文件路径+文件名
        $path = public_path(DIRECTORY_SEPARATOR).self::$xml;
        // 打开文件，并且删除之前的数据
        $file = @fopen($path, 'w+');
        if(!$file) return false;
        // 写入内容
        fwrite($file, $xml);
        // 关闭文件
        fclose($file);
        return true;
    }

    /**
     * 缓存网站链接txt
     *
     * @return bool
     */
    public static function txt(): bool
    {

        // 实例化ConfigMessageRepository获取配置
        $configMessageRepository = new ConfigMessageRepository();
        // 网站地址
        $bool = $configMessageRepository::config('website');
        if($bool) { list($url) = $configMessageRepository::returnData(['']); }
        else { $url = config('app.url'); }
        // 网站地址不存在获取默认值
        if(!strlen($url)){  $url = config('app.url'); }
        // 实例化ColumnsRepository获取栏目
        $columnsRepository = new ColumnsRepository();
        // 获取页面栏目编号和页面
        $columns = $columnsRepository::pageColumnsIds(['id', 'page']);
        $txt = '';
        // 栏目
        foreach ($columns as &$column){
            $txt .= $url .'/'.$column['page'] . '/' .$column['id'].page_suffix_message()."\r\n";
        }
        // 信息
        $messagesRepository = new MessagesRepository();
        $messages = $messagesRepository::siteMapMessages();
        foreach ($messages as &$message){
            $txt .= $url .'/'.$message['page'] . '/' .$message['id'].page_suffix_message()."\r\n";
        }
        // 文件路径+文件名
        $path = public_path(DIRECTORY_SEPARATOR).self::$txt;
        // 打开文件，并且删除之前的数据
        $file = @fopen($path, 'w+');
        if(!$file) return false;
        // 写入内容
        fwrite($file, $txt);
        // 关闭文件
        fclose($file);
        return true;
    }
}