<?php
/**
 * Short description for UpTest.php
 *
 * @package UpTest
 * @author n3xtchen <echenwen@gmail.com>
 * @version 0.1
 * @copyright (C) 2014 n3xtchen <echenwen@gmail.com>
 * @license GPL V2
 */
namespace Jawbone\Tests;

use Symfony\Component\Yaml\Parser;

use Jawbone\Up;

class UpTest extends \PHPUnit_Framework_TestCase
{
    public $config;
    public $jawbone_up;

    public function __construct() {

        $path = __DIR__.'/Fixtures';
        $yml  = new Parser();
        $this->config = $yml->parse(file_get_contents($path.'/JawboneOpts.yml'));

        $this->jawbone_up = new Up($this->config);
    }

    public function testConstruct() 
    {
        $this->assertEquals($this->jawbone_up->client_id, $this->config['client_id']);
    }

    public function testCurl() 
    {
        $info = $this->jawbone_up->curl('users/@me/');
        $this->assertEquals(array_keys($info), ['meta', 'data']);
    }

    public function testArr2Qs()
    {
        $arr = ['a' => 1, 'b' => 2];
        $this->assertEquals($this->jawbone_up->arr2Qs($arr), 'a=1&b=2');
    }

    public function testPost()
    {
        $mood_content = [                    
            'title' => 'Test Api!',          
            'sub_type' => 3,                 
            'share' => 1                     
        ];

        $moods = $this->jawbone_up->post('mood', $mood_content);
        return $moods['data'];
    }

    /**
     * @depends testPost
     */
    public function testGet($mood)
    {
        $xid   = $mood['xid'];
        $title = $mood['title'];

        $moods = $this->jawbone_up->get('mood');
        $this->assertEquals($moods['data']['xid'], $xid);

        $moods = $this->jawbone_up->get('mood', $xid);
        $this->assertEquals($moods['data']['title'], $title);

        return $xid;
    }

    /**
     * @depends testGet
     */
    public function testDelete($xid)
    {
        $del_message = $this->jawbone_up->delete('mood', $xid);
        $this->assertEquals($del_message['meta']['message'], 'OK');
    }
}
