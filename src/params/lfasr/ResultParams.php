<?php

namespace makehui\iflytek\params\lfasr;


use makehui\iflytek\params\Params;
use makehui\iflytek\params\ParamsInterface;

/**
 * https://www.xfyun.cn/doc/asr/lfasr/API.html#%E5%8F%82%E6%95%B0%E8%AF%B4%E6%98%8E-5
 *
 * Class ResultParams
 * @package makehui\iflytek\params\lfasr
 */
class ResultParams extends Params implements ParamsInterface
{
    /**
     * 任务ID（预处理接口返回值）
     *
     * @var string
     */
    public $taskId;

    public function toArray()
    {
        $array = parent::toArray();
        return array_merge($array, [
            'task_id' => (string) $this->taskId,
        ]);
    }
}