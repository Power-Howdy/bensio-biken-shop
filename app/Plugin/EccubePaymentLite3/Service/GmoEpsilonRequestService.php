<?php

namespace Plugin\EccubePaymentLite3\Service;

use Eccube\Application;
use Guzzle\Http\Exception\CurlException;
use Guzzle\Service\Client;
use Guzzle\Http\Exception\BadResponseException;


class GmoEpsilonRequestService
{
    /** @var Application */
    public $app;

    public $const;

    /**
     * GmoEpsilonUrlService constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];
    }

    /**
     * リクエストを送信
     *
     * @param string $url
     * @param array $arrParameter
     * @return array|false|int|null
     */
    function sendData($url, $arrParameter, $version = null)
    {
        //パラメータの文字コードをUTF8⇒EUCJPに変換
        // mb_convert_variables("EUC-JP", "UTF-8", $arrParameter);
        //CGIバージョンが1の場合は、パラメータの文字コードをUTF8⇒EUCJPに変換
        if (isset($arrParameter['version']) && $arrParameter['version'] === '1') {
            mb_convert_variables('SJIS-win', 'UTF-8', $arrParameter);
        }

        $arrVal = array();

        // POSTデータを送信し、応答情報を取得する
        $client = new Client();

        try {
            $request = $client->post($url, array(), $arrParameter);
            $response = $request->send();
        } catch (CurlException $e) {
            $this->app['monolog.gmoepsilon']->addInfo('CurlException. url='.$url.' parameter='.print_r($arrParameter,true));
            return $e->getErrorNo();
        } catch (BadResponseException $e) {
            $this->app['monolog.gmoepsilon']->addInfo('BadResponseException. url='.$url.' parameter='.print_r($arrParameter,true));
            return false;
        } catch (\Exception $e) {
            $this->app['monolog.gmoepsilon']->addInfo('Exception. url='.$url.' parameter='.print_r($arrParameter,true));
            return false;
        }

        $response = $response->getBody(true);

        if (is_null($response)) {
            // $msg = 'レスポンスデータエラー: レスポンスがありません。';
            return false;
        }

        // Shift-JISをUNICODEに変換する
        $response = str_replace("x-sjis-cp932", "UTF-8", $response);

        // XMLパーサを生成する。
        $parser = xml_parser_create('utf-8');

        // 空白文字は読み飛ばしてXMLを読み取る
        xml_parser_set_option($parser,XML_OPTION_TARGET_ENCODING,"UTF-8");
        xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);

        // 配列にXMLのデータを格納する
        $err = xml_parse_into_struct($parser,$response,$arrVal,$idx);

        // 開放する
        xml_parser_free($parser);

        return $arrVal;

    }

    /**
     * XMLのタグを指定し、要素を取得
     *
     * @param array $arrVal
     * @param string $tag
     * @param string $att
     *
     * @return string
     */
    public function getXMLValue($arrVal, $tag, $att)
    {
        $ret = '';
        foreach ((array) $arrVal as $array) {
            if ($tag == $array['tag']) {
                if (!is_array($array['attributes'])) {
                    continue;
                }
                foreach ($array['attributes'] as $key => $val) {
                    if ($key == $att) {
                        $ret = mb_convert_encoding(urldecode($val), 'UTF-8', 'SJIS');
                        break;
                    }
                }
            }
        }

        return $ret;
    }
}
