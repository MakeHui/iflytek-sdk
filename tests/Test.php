<?php

namespace tests;

use makehui\iflytek\exceptions\LfasrException;
use makehui\iflytek\services\LfasrService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

class Test extends TestCase
{
    private $config;

    private $filePath;

    /**
     * @var LfasrService
     */
    private $sdk;

    private $taskId;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $env = Yaml::parseFile('../.env.yaml');
        $this->config = $env['config'];
        $this->filePath = $env['file_path'];
        $this->sdk = new LfasrService($this->config);
    }

    public function testComboUpload()
    {
        $this->taskId = $this->sdk->comboUpload($this->filePath);
        $this->assertTrue(!!$this->taskId);
    }

    public function testComboResult()
    {
        try {
            $result = $this->sdk->comboResult($this->taskId);
        } catch (LfasrException $e) {
            var_export($e);
        }
        $this->assertTrue(!!count($result));
    }
}