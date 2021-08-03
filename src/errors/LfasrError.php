<?php

namespace makehui\iflytek\errors;

class LfasrError
{
    const MSG_0 = '成功';
    const CODE_0 = 0;

    const MSG_26000 = '转写内部通用错误';
    const CODE_26000 = 26000;

    const MSG_26100 = '转写配置文件错误';
    const CODE_26100 = 26100;

    const MSG_26101 = '转写配置文件app_id/secret_key为空';
    const CODE_26101 = 26101;

    const MSG_26102 = '转写配置文件lfasr_host错误';
    const CODE_26102 = 26102;

    const MSG_26103 = '转写配置文件file_piece_size错误';
    const CODE_26103 = 26103;

    const MSG_26104 = '转写配置文件file_piece_size建议设置10M-30M之间';
    const CODE_26104 = 26104;

    const MSG_26105 = '转写配置文件store_path错误，或目录不可读写';
    const CODE_26105 = 26105;

    const MSG_26201 = '转写参数上传文件不能为空或文件不存在';
    const CODE_26201 = 26201;

    const MSG_26202 = '转写参数类型不能为空';
    const CODE_26202 = 26202;

    const MSG_26203 = '转写参数客户端生成签名错误';
    const CODE_26203 = 26203;

    const MSG_26301 = '转写断点续传持久化文件读写错误';
    const CODE_26301 = 26301;

    const MSG_26302 = '转写断点续传文件夹读写错误';
    const CODE_26302 = 26302;

    const MSG_26303 = '转写恢复断点续传流程错误,请见日志';
    const CODE_26303 = 26303;

    const MSG_26401 = '转写上传文件路径错误';
    const CODE_26401 = 26401;

    const MSG_26402 = '转写上传文件类型不支持错误';
    const CODE_26402 = 26402;

    const MSG_26403 = '转写本地文件上传超过限定大小500M';
    const CODE_26403 = 26403;

    const MSG_26404 = '转写上传文件读取错误';
    const CODE_26404 = 26404;

    const MSG_26500 = 'HTTP请求失败';
    const CODE_26500 = 26500;

    const MSG_26501 = '转写获取版本号接口错误';
    const CODE_26501 = 26501;

    const MSG_26502 = '转写预处理接口错误';
    const CODE_26502 = 26502;

    const MSG_26503 = '转写上传文件接口错误';
    const CODE_26503 = 26503;

    const MSG_26504 = '转写合并文件接口错误';
    const CODE_26504 = 26504;

    const MSG_26505 = '转写获取进度接口错误';
    const CODE_26505 = 26505;

    const MSG_26506 = '转写获取结果接口错误';
    const CODE_26506 = 26506;

    const MSG_26600 = '转写业务通用错误';
    const CODE_26600 = 26600;

    const MSG_26601 = '非法应用信息';
    const CODE_26601 = 26601;

    const MSG_26602 = '任务ID不存在';
    const CODE_26602 = 26602;

    const MSG_26603 = '接口访问频率受限（默认1秒内不得超过20次）';
    const CODE_26603 = 26603;

    const MSG_26604 = '获取结果次数超过限制，最多100次';
    const CODE_26604 = 26604;

    const MSG_26605 = '任务正在处理中，请稍后重试';
    const CODE_26605 = 26605;

    const MSG_26606 = '空音频，请检查';
    const CODE_26606 = 26606;

    const MSG_26610 = '请求参数错误';
    const CODE_26610 = 26610;

    const MSG_26621 = '预处理文件大小受限（500M）';
    const CODE_26621 = 26621;

    const MSG_26622 = '预处理音频时长受限（5小时）';
    const CODE_26622 = 26622;

    const MSG_26623 = '预处理音频格式受限';
    const CODE_26623 = 26623;

    const MSG_26625 = '预处理服务时长不足。您剩余的可用服务时长不足，请移步产品页http://www.xfyun.cn/services/lfasr 进行购买或者免费领取';
    const CODE_26625 = 26625;

    const MSG_26631 = '音频文件大小受限（500M）';
    const CODE_26631 = 26631;

    const MSG_26632 = '音频时长受限（5小时）';
    const CODE_26632 = 26632;

    const MSG_26633 = '音频服务时长不足。您剩余的可用服务时长不足，请移步产品页http://www.xfyun.cn/services/lfasr 进行购买或者免费领';
    const CODE_26633 = 26633;

    const MSG_26634 = '文件下载失败';
    const CODE_26634 = 26634;

    const MSG_26635 = '文件长度校验失败';
    const CODE_26635 = 26635;

    const MSG_26640 = '文件上传失败';
    const CODE_26640 = 26640;

    const MSG_26641 = '上传分片超过限制';
    const CODE_26641 = 26641;

    const MSG_26642 = '分片合并失败';
    const CODE_26642 = 26642;

    const MSG_26643 = '计算音频时长失败,请检查您的音频是否加密或者损坏';
    const CODE_26643 = 26643;

    const MSG_26650 = '音频格式转换失败,请检查您的音频是否加密或者损坏';
    const CODE_26650 = 26650;

    const MSG_26660 = '计费计量失败';
    const CODE_26660 = 26660;

    const MSG_26670 = '转写结果集解析失败';
    const CODE_26670 = 26670;

    const MSG_26680 = '引擎处理阶段错误';
    const CODE_26680 = 26680;

    const MSG_26607 = '转写语种未授权或已过有效期';
    const CODE_26607 = 26607;
}