<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/14
 */

namespace App\CcForever\extend;

use App\Repositories\ConfigMessageRepository;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

/**
 * 阿里巴巴短信
 *
 * Class SMSAliBaBaExtend
 * @package App\CcForever\extend
 */
class SMSAliBaBaExtend
{
    //accessKeyId
    private static $accessKeyId;

    //accessSecret
    private static $accessSecret;

    //服务器地址
    private static $regionId;

    //模版签名
    private static $signName;

    //模版编号
    private static $template;

    //接收短信手机号
    private static $phone;

    public function __construct()
    {
        // 实例化ConfigMessageRepository
        $configMessageRepository = new ConfigMessageRepository();
        // 获取配置
        $configs = $configMessageRepository::batch(['smsaccesskeyid', 'smsaccesssecret', 'smsregionid', 'smssignname', 'smstemplate', 'smsphone']);
        foreach ($configs as &$config){
            switch ($config['select']){
                case 'smsaccesskeyid':
                    self::$accessKeyId = $config['value'];
                    break;
                case 'smsaccesssecret':
                    self::$accessSecret = $config['value'];
                    break;
                case 'smsregionid':
                    self::$regionId = $config['value'];
                    break;
                case 'smssignname':
                    self::$signName = $config['value'];
                    break;
                case 'smstemplate':
                    self::$template = $config['value'];
                    break;
                case 'smsphone':
                    self::$phone = $config['value'];
                    break;
                default:;
            }
        }
    }

    /**
     * 发送短信
     *
     * @param string $content
     * @throws ClientException
     */
    public static function send(string $content):void
    {
        $customer = $content;
        AlibabaCloud::accessKeyClient(self::$accessKeyId, self::$accessSecret)->regionId(self::$regionId)->asDefaultClient();
        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => self::$regionId,
                        'PhoneNumbers' => self::$phone,
                        'SignName' => self::$signName,
                        'TemplateCode' => self::$template,
                        'TemplateParam' => json_encode(compact('customer')),
                    ],
                ])
                ->request();
            dump($result);
        } catch (ClientException $e) {
            dump($e->getErrorMessage() . PHP_EOL);
        } catch (ServerException $e) {
            dump($e->getErrorMessage() . PHP_EOL);
        }
    }
}