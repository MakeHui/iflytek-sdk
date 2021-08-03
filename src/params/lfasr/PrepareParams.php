<?php


namespace makehui\iflytek\params\lfasr;

use makehui\iflytek\params\Params;
use makehui\iflytek\params\ParamsInterface;

/**
 * https://www.xfyun.cn/doc/asr/lfasr/API.html#%E5%8F%82%E6%95%B0%E8%AF%B4%E6%98%8E
 *
 * Class PrepareParams
 * @package makehui\iflytek\lfasr
 */
class PrepareParams extends Params implements ParamsInterface
{
    /**
     * 文件大小（单位：字节）
     * @var string
     */
    public $fileLen;

    /**
     * 文件名称（带后缀）
     * @var string
     */
    public $fileName;

    /**
     * 文件分片数目（建议分片大小为10M，若文件<10M，则slice_num=1）
     * 10 * 1024 * 1024
     * @var int
     */
    public $sliceNum;

    /**
     * 转写类型，默认 0
     * 0: (标准版，格式: wav,flac,opus,mp3,m4a)
     * 2: (电话版，已取消)
     * @var string
     */
    public $lfasrType = '0';

    /**
     * 转写结果是否包含分词信息
     * false或true， 默认false
     * @var string
     */
    public $hasParticiple = 'true';

    /**
     * 转写结果中最大的候选词个数
     * 默认：0，最大不超过5
     * @var string
     */
    public $maxAlternatives = '0';

    /**
     * 发音人个数，可选值：0-10，0表示盲分
     * 注：发音人分离目前还是测试效果达不到商用标准，如测试无法满足您的需求，请慎用该功能。
     * 默认：2（适用通话时两个人对话的场景）
     * @var string
     */
    public $speakerNumber = '0';

    /**
     * 转写结果中是否包含发音人分离信息
     * false或true，默认为false
     * @var string
     */
    public $hasSeperate = 'true';

    /**
     * 支持参数如下
     * 1: 通用角色分离
     * 该字段只有在开通了角色分离功能的前提下才会生效，正确传入该参数后角色分离效果会有所提升。 如果该字段不传，默认采用 1 类型
     * @var string
     */
    public $roleType = '1';

    /**
     * 语种
     * cn:中英文&中文（默认）
     * en:英文（英文不支持热词）
     * 其他小语种：可到控制台-语音转写-方言/语种处添加试用或购买，添加后会显示该小语种参数值。若未授权，使用将会报错26607。
     * @var string
     */
    public $language = 'cn';

    /**
     * 垂直领域个性化参数:
     * 法院: court
     * 教育: edu
     * 金融: finance
     * 医疗: medical
     * 科技: tech
     * 体育: sport
     * 政府: gov
     * 游戏: game
     * 电商: ecom
     * 汽车: car
     *
     * 设置示例:prepareParam.put("pd", "edu")
     * pd为非必须设置参数，不设置参数默认为通用
     *
     * @var string
     */
    public $pd;

    public function toArray()
    {
        $array = parent::toArray();
        $array = array_merge($array, [
            'file_len' => (string) $this->fileLen,
            'file_name' => (string) $this->fileName,
            'slice_num' => (int) $this->sliceNum,
            'lfasr_type' => (string) $this->lfasrType,
            'has_participle' => (string) $this->hasParticiple,
            'max_alternatives' => (string) $this->maxAlternatives,
            'speaker_number' => (string) $this->speakerNumber,
            'has_seperate' => (string) $this->hasSeperate,
            'role_type' => (string) $this->roleType,
            'language' => (string) $this->language,
        ]);

        if (isset($this->pd)) {
            $array['pd'] = (string) $this->pd;
        }

        return $array;
    }

}