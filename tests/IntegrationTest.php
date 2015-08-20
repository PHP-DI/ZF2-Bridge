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
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

/**
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class IntegrationTest extends \PHPUnit_Framework_TestCase
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

        $config = array(
            'modules' => array(
                'DI\ZendFramework2',
            ),
            'module_listener_options' => array(),
        );

        $this->serviceManager = new ServiceManager(new ServiceManagerConfig());
        $this->serviceManager->setService(PHPDIAbstractFactory::CONTAINER_NAME, $this->phpdi);
        $this->serviceManager->setService('ApplicationConfig', $config);

        $moduleManager = $this->serviceManager->get('ModuleManager');
        $moduleManager->loadModules();
    }

    public function testGetInServiceManager()
    {
        $this->serviceManager->setService('phpdifoo', 'bar');

        $this->assertTrue($this->serviceManager->has('phpdifoo'));
        $this->assertEquals('bar', $this->serviceManager->get('phpdifoo'));
    }

    public function testGetInPHPDI()
    {
        $this->phpdi->set('phpdifoo', 'bar');

        $this->assertTrue($this->serviceManager->has('phpdifoo'));
        $this->assertEquals('bar', $this->serviceManager->get('phpdifoo'));
    }

    public function testHasUndefinedEntry()
    {
        $this->assertFalse($this->serviceManager->has('phpdifoo'));
    }

    /**
     * @expectedException \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetUndefinedEntry()
    {
        $this->serviceManager->get('phpdifoo');
    }
}
