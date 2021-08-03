<?php

namespace makehui\iflytek\services;

use makehui\iflytek\errors\LfasrError;
use makehui\iflytek\errors\LfasrTaskError;
use makehui\iflytek\exceptions\LfasrException;
use makehui\iflytek\params\lfasr\MergeParams;
use makehui\iflytek\params\lfasr\PrepareParams;
use makehui\iflytek\params\lfasr\ResultParams;
use makehui\iflytek\params\lfasr\UploadParams;
use makehui\iflytek\params\Params;
use makehui\iflytek\params\ParamsInterface;
use makehui\iflytek\Request;
use makehui\iflytek\Signature;

/**
 * https://www.xfyun.cn/doc/asr/lfasr/API.html
 *
 * Class LfasrService
 * @package makehui\iflytek\services
 */
class LfasrService
{
    private const DEFAULT_SLICE_LEN = 10 * 1024 * 1024;

    protected $config = [];

    private $baseUri = 'https://raasr.xfyun.cn/api/';

    use Signature;
    use Request;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 预处理接口
     * https://www.xfyun.cn/doc/asr/lfasr/API.html#_1%E3%80%81%E9%A2%84%E5%A4%84%E7%90%86%E6%8E%A5%E5%8F%A3
     *
     * @param ParamsInterface|array $params
     * @param string $filePath 如果设置了该参数, 并且 $params 是数组类型
     *                         $fileLen, $fileName, $sliceNum 这几个参数可不设置
     * @return string|null
     * @throws LfasrException
     */
    public function prepare($params, string $filePath = '') {
        if (!($params instanceof ParamsInterface)) {
            $sliceLen = $this->config['slice_len'] ?? self::DEFAULT_SLICE_LEN;
            $ts = time();
            if ($filePath) {
                $params = array_merge($params, $this->filePathParse($filePath, $sliceLen));
            }

            $params = array_merge($params, [
                'ts' => $ts,
                'app_id' => $this->config['app_id'],
                'signa' => $this->signa($ts)]);
            $params = new PrepareParams($params);
        }

        return $this->request('prepare', $params);
    }


    /**
     * 文件分片上传接口
     * https://www.xfyun.cn/doc/asr/lfasr/API.html#_2%E3%80%81%E6%96%87%E4%BB%B6%E5%88%86%E7%89%87%E4%B8%8A%E4%BC%A0%E6%8E%A5%E5%8F%A3
     *
     * @param ParamsInterface|array $params
     * @param string $filePath 如果设置了该参数, 并且 $params 是数组类型
     *                         自动分片上传
     * @throws LfasrException
     */
    public function upload($params, string $filePath = '')
    {
        if ($params instanceof ParamsInterface) {
            $this->request('upload', $params, ['Content-Type' => 'multipart/form-data']);
            return;
        }

        $sliceLen = $this->config['slice_len'] ?? self::DEFAULT_SLICE_LEN;
        $sliceIndex = 0;
        $file = fopen($filePath, 'rb');

        while (!feof($file)) {
            $sliceIndex += 1;
            $sliceId = Params::indexToSliceId($sliceIndex);
            $uploadParams = [];
            $uploadParams['slice_id'] = $sliceId;
            $uploadParams['task_id'] = $params['task_id'];
            $uploadParams['content'] = fread($file, $sliceLen);
            $uploadParams = $this->paramsParse($uploadParams);
            $uploadParams = new UploadParams($uploadParams);
            $this->request('upload', $uploadParams, ['Content-Type' => 'multipart/form-data']);
        }
    }

    /**
     * 合并文件接口
     * https://www.xfyun.cn/doc/asr/lfasr/API.html#_3%E3%80%81%E5%90%88%E5%B9%B6%E6%96%87%E4%BB%B6%E6%8E%A5%E5%8F%A3
     *
     * @param ParamsInterface|array $params
     * @throws LfasrException
     */
    public function merge($params) {
        if (!($params instanceof ParamsInterface)) {
            $params = $this->paramsParse($params);
            $params = new MergeParams($params);
        }
        $this->request('merge', $params);
    }

    /**
     * 查询处理进度接口
     * https://www.xfyun.cn/doc/asr/lfasr/API.html#_4%E3%80%81%E6%9F%A5%E8%AF%A2%E5%A4%84%E7%90%86%E8%BF%9B%E5%BA%A6%E6%8E%A5%E5%8F%A3
     *
     * @param ParamsInterface|array $params
     * @return array|null
     * @throws LfasrException
     */
    public function getProgress($params) {
        if (!($params instanceof ParamsInterface)) {
            $params = $this->paramsParse($params);
            $params = new MergeParams($params);
        }
        $result = $this->request('getProgress', $params);
        return json_decode($result, true);
    }

    /**
     * 获取结果接口
     * https://www.xfyun.cn/doc/asr/lfasr/API.html#_5%E3%80%81%E8%8E%B7%E5%8F%96%E7%BB%93%E6%9E%9C%E6%8E%A5%E5%8F%A3
     *
     * @param ParamsInterface|array $params
     * @return array|null
     * @throws LfasrException
     */
    public function getResult($params) {
        if (!($params instanceof ParamsInterface)) {
            $params = $this->paramsParse($params);
            $params = new ResultParams($params);
        }
        $result = $this->request('getResult', $params);
        return json_decode($result, true);
    }

    /**
     * 上传音频文件, 胶水api, 使用默认配置
     * 预处理, 文件分片上传, 合并文件
     *
     * @param $filePath
     * @return string
     * @throws LfasrException
     */
    public function comboUpload($filePath)
    {
        $result = $this->prepare([], $filePath);
        $this->upload(['task_id' => $result], $filePath);
        $this->merge(['task_id' => $result]);
        return $result;
    }

    /**
     * 查询结果, 胶水api
     * 定时查看结果是否完成
     *
     * @param $taskId
     * @return array|null
     * @throws LfasrException
     */
    public function comboResult($taskId)
    {
        $result = $this->getProgress(['task_id' => $taskId]);

        if ($result['status'] != LfasrTaskError::CODE_9) {
            throw new LfasrException($result['desc'], $result['status']);
        }

        return $this->getResult(['task_id' => $taskId]);
    }

    /**
     * 一个接口完成所有操作, 胶水api, 使用默认配置
     * 注意: 不建议使用该接口, 可能会超时
     *
     * @param $filePath
     * @return array
     * @throws LfasrException
     */
    public function comboApi($filePath)
    {
        $taskId = $this->comboUpload($filePath);
        $result = null;
        while (!$result) {
            try {
                $result = $this->comboResult($taskId);
            } catch (LfasrException $e) {
                if ($e->getCode() !== LfasrError::CODE_26605) {
                    throw $e;
                }
            }
            sleep(5);
        }
        return $result;
    }

    /**
     * @param $api
     * @param ParamsInterface|array $params
     * @param array $headers
     * @return string|null
     * @throws LfasrException
     */
    protected function request($api, $params, array $headers = [])
    {
        $uri = $this->baseUri . $api;
        $response = $this->post($uri, $params->toArray(), $headers);
        $result = json_decode($response['response'], true);
        if ($result['err_no'] !== LfasrError::CODE_0) {
            throw new LfasrException($result['failed'], $result['err_no']);
        }

        return $result['data'];
    }

    /**
     * @param $filePath
     * @param float|int $sliceLen
     * @return array
     */
    protected function filePathParse($filePath, $sliceLen = self::DEFAULT_SLICE_LEN)
    {
        $params = [];
        $params['file_len'] = filesize($filePath);
        $params['file_name'] = basename($filePath);
        $params['slice_num'] = (int) ceil($params['file_len'] / $sliceLen);

        return $params;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function paramsParse($params = [])
    {
        $ts = time();
        return array_merge($params, [
            'ts' => $ts,
            'app_id' => $this->config['app_id'],
            'signa' => $this->signa($ts)
        ]);
    }

}