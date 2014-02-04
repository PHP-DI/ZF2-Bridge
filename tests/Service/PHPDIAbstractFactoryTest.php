<?php
/**
 * PHP-DI
 *
 * @link      http://php-di.org/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Test\DI\ZendFramework2\Service;

use DI\Container;
use DI\ContainerBuilder;
use DI\ZendFramework2\Service\PHPDIAbstractFactory;
use Zend\ServiceManager\ServiceManager;

/**
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class PHPDIAbstractFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    private $phpdi;

    /**
     * @var ServiceManager
     */
    private $serviceManager;

    public function setUp()
    {
        $this->phpdi = ContainerBuilder::buildDevContainer();

        $this->serviceManager = new ServiceManager();
        $this->serviceManager->setService(PHPDIAbstractFactory::CONTAINER_NAME, $this->phpdi);
        $this->serviceManager->addAbstractFactory(new PHPDIAbstractFactory());
    }

    public function testGetInServiceManager()
    {
        $this->serviceManager->setService('foo', 'bar');

        $this->assertTrue($this->serviceManager->has('foo'));
        $this->assertEquals('bar', $this->serviceManager->get('foo'));
    }

    public function testGetInPHPDI()
    {
        $this->phpdi->set('foo', 'bar');

        $this->assertTrue($this->serviceManager->has('foo'));
        $this->assertEquals('bar', $this->serviceManager->get('foo'));
    }

    public function testHasUndefinedEntry()
    {
        $this->assertFalse($this->serviceManager->has('foo'));
    }

    /**
     * @expectedException \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetUndefinedEntry()
    {
        $this->serviceManager->get('foo');
    }
}
