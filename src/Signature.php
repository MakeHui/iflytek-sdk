<?php

namespace makehui\iflytek;

trait Signature
{
    protected $config = [];

    /**
     * 获取签名
     * @param $ts
     * @return false|string
     */
    public function signa($ts) {
        $baseString = md5($this->config['app_id'] . $ts);
        $signa = hash_hmac('sha1', $baseString, $this->config['secret_key'], true);
        return base64_encode($signa);
    }

}