<?php
use DTS\eBaySDK\Credentials\Credentials;
use DTS\eBaySDK\Mocks\Service;
use DTS\eBaySDK\Mocks\ComplexClass;
use DTS\eBaySDK\Mocks\HttpClient;
use DTS\eBaySDK\Mocks\Logger;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testProductionUrlIsUsed()
    {
        // By default sandbox will be false.
        $h = new HttpClient();
        $s = new Service([], $h);
        $s->foo(new ComplexClass());

        $this->assertEquals('http://production.com', $h->url);
    }

    public function testSandboxUrlIsUsed()
    {
        $h = new HttpClient();
        $s = new Service([
            'sandbox' => true
        ], $h);
        $s->foo(new ComplexClass());

        $this->assertEquals('http://sandbox.com', $h->url);
    }

    public function testHttpHeadersAreCreated()
    {
        $h = new HttpClient();
        $s = new Service([], $h);
        $r = new ComplexClass();
        $s->foo($r);

        $this->assertEquals(array(
            'fooHdr' => 'foo',
            'Content-Type' => 'text/xml',
            'Content-Length' => strlen($r->toRequestXml())
        ), $h->headers);
    }

    public function testXmlIsCreated()
    {
        $h = new HttpClient();
        $s = new Service([], $h);
        $r = new ComplexClass();
        $s->foo($r);

        $this->assertEquals($r->toRequestXml(), $h->body);
    }

    public function testResponseIsReturned()
    {
        $s = new Service([], new HttpClient());
        $r = $s->foo(new ComplexClass());

        $this->assertInstanceOf('\DTS\eBaySDK\Mocks\ComplexClass', $r);
    }

    public function testLogging()
    {
        // TODO Add debug configuration
        if(0) {
        // If no logger has been assigned there should be no debug messages.
        $this->assertEquals(null, $this->service->logger());
        $this->service->foo($this->request);
        $this->assertEquals(0, count($this->logger->debugMessages));

        // Even if the configuration is set to log debugging.
        $this->assertEquals(null, $this->service->logger());
        $this->service->config('debug', true);
        $this->service->foo($this->request);
        $this->assertEquals(0, count($this->logger->debugMessages));

        // Now check that debugging information is logged.
        $this->service->logger($this->logger);
        $this->service->config('debug', true);
        $this->service->foo($this->request);

        $debugRequest = $this->logger->debugMessages[0];
        $this->assertEquals('Request', $debugRequest['message']);
        $this->assertEquals('http://production.com', $debugRequest['context']['url']);
        $this->assertEquals('foo', $debugRequest['context']['name']);
        $this->assertEquals(array(
            'fooHdr' => 'foo',
            'Content-Type' => 'text/xml',
            'Content-Length' => strlen($this->request->toRequestXml())
        ), $debugRequest['context']['headers']);
        $this->assertEquals($this->request->toRequestXml(), $debugRequest['context']['body']);

        $debugResponse = $this->logger->debugMessages[1];
        $this->assertEquals('Response', $debugResponse['message']);
        $this->assertEquals(file_get_contents(__DIR__.'/../Mocks/Response.xml'), $debugResponse['context']['body']);
        }
    }

    public function testHttpClient()
    {
        // TODO - Rename to httpHandler
        if(0) {
        $this->assertInstanceOf('\DTS\eBaySDK\Interfaces\HttpClientInterface', $this->service1->httpClient());
        $this->assertInstanceOf('\DTS\eBaySDK\HttpClient\HttpClient', $this->service1->httpClient());

        $this->assertInstanceOf('\DTS\eBaySDK\Interfaces\HttpClientInterface', $this->service2->httpClient());
        $this->assertInstanceOf('\DTS\eBaySDK\HttpClient\HttpClient', $this->service2->httpClient());

        $this->assertInstanceOf('\DTS\eBaySDK\Interfaces\HttpClientInterface', $this->service3->httpClient());
        $this->assertInstanceOf('\DTS\eBaySDK\Mocks\HttpClient', $this->service3->httpClient());
        }
    }

    public function testCredentialsInstanceCanBePassed()
    {
        $s = new Service([
            'credentials' => new Credentials('111', '222', '333', '444')
        ]);

        $c = $s->getCredentials();
        $this->assertEquals('111', $c->getAppId());
        $this->assertEquals('222', $c->getCertId());
        $this->assertEquals('333', $c->getDevId());
        $this->assertEquals('444', $c->getAuthToken());
    }

    public function testCredentialsCanBeHardCoded()
    {
        $s = new Service([
            'credentials' => [
                'appId' => '111',
                'authToken' => '222',
                'certId' => '333',
                'devId' => '444'
            ]
        ]);

        $c = $s->getCredentials();
        $this->assertEquals('111', $c->getAppId());
        $this->assertEquals('222', $c->getAuthToken());
        $this->assertEquals('333', $c->getCertId());
        $this->assertEquals('444', $c->getDevId());
    }

    public function testCredentialsCanBeProvided()
    {
        $s = new Service([
            'credentials' => function () {
                return new Credentials('111', '222', '333', '444');
            }
        ]);

        $c = $s->getCredentials();
        $this->assertEquals('111', $c->getAppId());
        $this->assertEquals('222', $c->getCertId());
        $this->assertEquals('333', $c->getDevId());
        $this->assertEquals('444', $c->getAuthToken());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Cannot locate credentials
     */
    public function testCredentialsProviderThrowsIfCantProvide()
    {
        $s = new Service([
            'credentials' => function () {
                return new \InvalidArgumentException('Cannot locate credentials');
            }
        ]);
    }
}

