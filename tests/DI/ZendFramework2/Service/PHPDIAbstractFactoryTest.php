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
        $this->serviceManager->setService('phpdifoo', 'bar');

        self::assertTrue($this->serviceManager->has('phpdifoo'));
        self::assertEquals('bar', $this->serviceManager->get('phpdifoo'));
    }

    public function testGetInPHPDI()
    {
        $this->phpdi->set('phpdifoo', 'bar');

        self::assertTrue($this->serviceManager->has('phpdifoo'));
        self::assertEquals('bar', $this->serviceManager->get('phpdifoo'));
    }

    public function testHasUndefinedEntry()
    {
        self::assertFalse($this->serviceManager->has('phpdifoo'));
    }

    /**
     * @expectedException \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetUndefinedEntry()
    {
        $this->serviceManager->get('phpdifoo');
    }
}
