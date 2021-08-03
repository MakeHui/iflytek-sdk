<?php

namespace makehui\iflytek\params\lfasr;


use makehui\iflytek\params\Params;
use makehui\iflytek\params\ParamsInterface;

/**
 * https://www.xfyun.cn/doc/asr/lfasr/API.html#%E5%8F%82%E6%95%B0%E8%AF%B4%E6%98%8E-2
 *
 * Class UploadParams
 * @package makehui\iflytek\params\lfasr
 */
class UploadParams extends Params implements ParamsInterface
{
    /**
     * 任务ID（预处理接口返回值）
     *
     * @var string
     */
    public $taskId;

    /**
     * 分片序号
     * aaaaaaaaaa，aaaaaaaaab
     *
     * @var string
     */
    public $sliceId;

    /**
     * 分片文件内容
     * 字节数组
     * @var mixed
     */
    public $content;

    public function toArray()
    {
        $array = parent::toArray();
        $dest = tempnam(sys_get_temp_dir(), uniqid());
        file_put_contents($dest, $this->content);
        $file = curl_file_create($dest);
        return array_merge($array, [
            'task_id' => (string) $this->taskId,
            'slice_id' => (string) $this->sliceId,
            'content' => $file,
        ]);
    }
}