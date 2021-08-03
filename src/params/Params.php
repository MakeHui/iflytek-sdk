<?php


namespace makehui\iflytek\params;


class Params implements ParamsInterface
{

    /**
     * 讯飞开放平台应用ID
     * @var string
     */
    public $appId;

    /**
     * 加密数字签名（基于HMACSHA1算法，可参考实时转写生成方式或页面下方demo）
     * @var string
     */
    public $signa;

    /**
     * 当前时间戳，从1970年1月1日0点0分0秒开始到现在的秒数
     * @var string
     */
    public $ts;

    public function __construct($params)
    {
        foreach ($params as $key => $param) {
            $key = $this->parseName($key, 1, false);
            if (property_exists($this, $key)) {
                $this->{$key} = $param;
            }
        }
        $this->ts = $params['ts'] ?? time();
    }

    /**
     * 字符串命名风格转换
     * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
     * @param string  $name 字符串
     * @param integer $type 转换类型
     * @param bool    $ucfirst 首字母是否大写（驼峰规则）
     * @return string
     */
    protected function parseName($name, $type = 0, $ucfirst = true)
    {
        if ($type) {
            $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name);

            return $ucfirst ? ucfirst($name) : lcfirst($name);
        } else {
            return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
        }
    }

    public static function indexToSliceId($index)
    {
        $k = '0123456789abcdefghijklmnop';
        $v = 'abcdefghijklmnopqrstuvwxyz';
        $base = base_convert($index - 1, 10, 26);
        $ch = '';

        for ($i = strlen($base); $i < 10; ++$i) {
            $ch .= 'a';
        }
        foreach(str_split($base) as $value) {
            $ch .= $v[strpos($k, $value)];
        }

        return $ch;
    }

    public static function indexFromSliceId($sliceId)
    {
        $k = '0123456789abcdefghijklmnop';
        $v = 'abcdefghijklmnopqrstuvwxyz';
        $ch = ltrim($sliceId, 'a');
        $base = '';

        if ($ch) {
            foreach(str_split($ch) as $value) {
                $base .= $k[strpos($v, $value)];
            }
            $base = (int) base_convert($base, 26, 10);
        } else {
            $base = 0;
        }

        return $base + 1;
    }

    public function toArray()
    {
        return [
            'app_id' => (string) $this->appId,
            'signa' => (string) $this->signa,
            'ts' => (string) $this->ts,
        ];
    }

}