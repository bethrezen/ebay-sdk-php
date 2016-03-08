<?php
/**
 * The contents of this file was generated using the WSDLs as provided by eBay.
 *
 * DO NOT EDIT THIS FILE!
 */

namespace DTS\eBaySDK\Test\Finding\Types;

use DTS\eBaySDK\Finding\Types\FindItemsByImageResponse;

class FindItemsByImageResponseTest extends \PHPUnit_Framework_TestCase
{
    private $obj;

    protected function setUp()
    {
        $this->obj = new FindItemsByImageResponse();
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Finding\Types\FindItemsByImageResponse', $this->obj);
    }

    public function testExtendsBaseFindingServiceResponse()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Finding\Types\BaseFindingServiceResponse', $this->obj);
    }
}