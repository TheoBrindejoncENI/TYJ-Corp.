<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'maker.auto_command.make_subscriber' shared service.

$this->services['maker.auto_command.make_subscriber'] = $instance = new \Symfony\Bundle\MakerBundle\Command\MakerCommand(new \Symfony\Bundle\MakerBundle\Maker\MakeSubscriber(new \Symfony\Bundle\MakerBundle\EventRegistry(${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->getDebug_EventDispatcherService()) && false ?: '_'})), ${($_ = isset($this->services['maker.file_manager']) ? $this->services['maker.file_manager'] : $this->load('getMaker_FileManagerService.php')) && false ?: '_'}, ${($_ = isset($this->services['maker.generator']) ? $this->services['maker.generator'] : $this->load('getMaker_GeneratorService.php')) && false ?: '_'});

$instance->setName('make:subscriber');

return $instance;
