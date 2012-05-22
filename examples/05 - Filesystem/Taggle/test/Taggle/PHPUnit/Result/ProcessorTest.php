<?php

namespace Taggle\PHPUnit\Result;

require_once 'Taggle/Store.php';
require_once 'Taggle/Document/Processor.php';
require_once 'Taggle/PHPUnit/Result/Processor.php';
require_once 'vfsStream/vfsStream.php';

use Mockery;
use vfsStream;
use vfsStreamWrapper;

class ProcessorTest extends \PHPUnit_Framework_TestCase {

    private $store;
    private $processor;
    
    function setUp() {
        parent::setUp();
        vfsStream::setup('processorTest');
        $this->store = Mockery::mock('\Taggle\Store');
        $this->processor = new Processor($this->store);
    }
    
    function tearDown() {
        Mockery::close();
        parent::tearDown();
    }
    
    function testProcess_empty() {
        vfsStream::newFile('result.json')->at(vfsStreamWrapper::getRoot());
        $url = vfsStream::url('processorTest/result.json');
        $this->store
            ->shouldReceive('batchSave')
            ->with(array())
            ->once()
            ->andReturn(array());
        $this->assertEmpty($this->processor->process($url));
    }
    
    function testProcess_file() {
        $content = '{"event":"suiteStart","suite":"Taggle\/PHPUnit\/Result\/","tests":2}';
        $content2 = '{"event":"suiteStart","suite":"Taggle\\\PHPUnit\\\Result\\\ProcessorTest","tests":2}';
        $content3 = '{"event":"testStart","suite":"Taggle\\\PHPUnit\\\Result\\\ProcessorTest","test":"Taggle\\\PHPUnit\\\Result\\\ProcessorTest::testProcess_empty"}';
        $content4 = '{"event":"test","suite":"Taggle\\\PHPUnit\\\Result\\\ProcessorTest","test":"Taggle\\\PHPUnit\\\Result\\\ProcessorTest::testProcess_empty","status":"pass","time":0.0097179412841797,"trace":[],"message":""}';
        $content5 = '{"event":"testStart","suite":"Taggle\\\PHPUnit\\\Result\\\ProcessorTest","test":"Taggle\\\PHPUnit\\\Result\\\ProcessorTest::testProcess_file"}';
        $content6 = '{"event":"test","suite":"Taggle\\\PHPUnit\\\Result\\\ProcessorTest","test":"Taggle\\\PHPUnit\\\Result\\\ProcessorTest::testProcess_file","status":"pass","time":0.0060300827026367,"trace":[],"message":""}';

        $document = json_decode($content);
        $document->taggle_type = 'phpunit_result';
        $document->ref_id = '12345';
        $document2 = json_decode($content2);
        $document2->taggle_type = 'phpunit_result';
        $document2->ref_id = '12345';
        $document3 = json_decode($content3);
        $document3->taggle_type = 'phpunit_result';
        $document3->ref_id = '12345';
        $document4 = json_decode($content4);
        $document4->taggle_type = 'phpunit_result';
        $document4->ref_id = '12345';
        $document5 = json_decode($content5);
        $document5->taggle_type = 'phpunit_result';
        $document5->ref_id = '12345';
        $document6 = json_decode($content6);
        $document6->taggle_type = 'phpunit_result';
        $document6->ref_id = '12345';
        vfsStream::newFile('result.json')
            ->withContent($content . $content2 . $content3 . $content4 . $content5 . $content6)
            ->at(vfsStreamWrapper::getRoot());
        $url = vfsStream::url('processorTest/result.json');
        $this->store
            ->shouldReceive('batchSave')
            ->with(array($document, $document2, $document3, $document4, $document5, $document6))
            ->once()
            ->andReturn(array('24680', '24681'));
        $this->assertEquals(array('24680', '24681'), $this->processor->process($url, '12345'));
    }
}