<?php
namespace Tpg\ExtjsBundle\Tests\Command\Mongo;

include_once(__DIR__ . '/../../app/AppKernel.php');

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Tpg\ExtjsBundle\Command\GenerateRestControllerCommand;

class GenerateRestControllerCommandTest extends \PHPUnit_Framework_TestCase {
    public function testGenerateController() {
        @unlink(__DIR__.'/../../Fixtures/Test/TestBundle/Resources/config/routing.rest.yml');
        @unlink(__DIR__.'/../../Fixtures/Test/TestBundle/Controller/OrderController.php');
        $kernel = new \AppKernel('test', true);
        $app = new Application($kernel);
        $app->add(new GenerateRestControllerCommand());
        $kernel->boot();
        $command = $app->find('generate:rest:controller');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            '--controller' => 'TestTestBundle:Order',
            '--entity' => 'TestTestBundle:Order'
        ), array('interactive'=>false));
        $kernel->shutdown();
        $this->assertTrue(class_exists("\\Test\\TestBundle\\Controller\\OrderController"));
        $this->assertFileExists(__DIR__.'/../../Fixtures/Test/TestBundle/Resources/config/routing.rest.yml');
        @unlink(__DIR__.'/../../Fixtures/Test/TestBundle/Resources/config/routing.rest.yml');
        @unlink(__DIR__.'/../../Fixtures/Test/TestBundle/Controller/OrderController.php');
    }
}