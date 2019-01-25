<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2019/1/25
 * Time: 下午6:10
 */

namespace Sms;


class Sms
{
    // fixme 必填：是否启用https
    protected $security = false;

    protected $accessKeyId;

    protected $accessKeySecret;

    public function __construct($accessKeyId, $accessKeySecret)
    {
        $this->accessKeyId     = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
    }

    /**
     * 发送短信
     */
    public function SendSms($PhoneNumbers, $SignName, $TemplateCode, $code) {
        $params = array();

        $params["PhoneNumbers"] = $PhoneNumbers;

        $params["SignName"] = $SignName;

        $params["TemplateCode"] = $TemplateCode;

        $params['TemplateParam'] = array('code' => $code);

//        $params['OutId'] = "12345";
//        $params['SmsUpExtendCode'] = "1234567";

        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $this->accessKeyId,
            $this->accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            )),
            $this->security
        );

        return $content;
    }

    /**
     * 短信发送记录查询
     */
    public function QuerySendDetails($PhoneNumbers, $SendDate, $PageSize=10, $CurrentPage=1, $BizId) {
        $params = array();

        $params["PhoneNumber"] = $PhoneNumbers;

        $params["SendDate"] = $SendDate;

        $params["PageSize"] = $PageSize;

        $params["CurrentPage"] = 1;

        $params["BizId"] = $BizId;

        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $this->accessKeyId,
            $this->accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "QuerySendDetails",
                "Version" => "2017-05-25",
            )),
            $this->security
        );

        return $content;
    }

    /**
     * 批量发送短信
     */
    public function SendBatchSms(array $PhoneNumbers, $SignNames, $TemplateCode, $TemplateParamJson) {
        $params = array();

        $params["PhoneNumberJson"] = $PhoneNumbers;

        $params["SignNameJson"] = $SignNames;

        $params["TemplateCode"] = $TemplateCode;

        // 友情提示:如果JSON中需要带换行符,请参照标准的JSON协议对换行符的要求,比如短信内容中包含\r\n的情况在JSON中需要表示成\\r\\n,否则会导致JSON在服务端解析失败
        $params["TemplateParamJson"] = $TemplateParamJson;

        // $params["SmsUpExtendCodeJson"] = json_encode(array("90997","90998"));


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        $params["TemplateParamJson"]  = json_encode($params["TemplateParamJson"], JSON_UNESCAPED_UNICODE);
        $params["SignNameJson"] = json_encode($params["SignNameJson"], JSON_UNESCAPED_UNICODE);
        $params["PhoneNumberJson"] = json_encode($params["PhoneNumberJson"], JSON_UNESCAPED_UNICODE);

        if(!empty($params["SmsUpExtendCodeJson"]) && is_array($params["SmsUpExtendCodeJson"])) {
            $params["SmsUpExtendCodeJson"] = json_encode($params["SmsUpExtendCodeJson"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $this->accessKeyId,
            $this->accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendBatchSms",
                "Version" => "2017-05-25",
            )),
            $this->security
        );

        return $content;
    }
}