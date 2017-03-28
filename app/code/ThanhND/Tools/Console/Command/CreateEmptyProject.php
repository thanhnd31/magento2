<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 3/20/17
 * Time: 5:45 PM
 */

namespace ThanhND\Tools\Console\Command;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class CreateEmptyProject extends Command
{
    protected function configure()
    {
        $this->setName('cproject')
//            ->setDescription('Create new empty project');
            ->setDescription('Create new empty project')
            ->setDefinition([
                new InputOption(
                    'namespace',
                    null,
                    InputOption::VALUE_REQUIRED,
                    'Must input namespace'
                ),
                new InputOption(
                    'module',
                    null,
                    InputOption::VALUE_REQUIRED,
                    'Must input module name'
                )
            ]);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $namespace = $input->getOption('namespace');
        $module = $input->getOption('module');
        if(!$namespace || !$module)
        {
            throw new \InvalidArgumentException('Missing options --namespace or --module. Create new module need your namespace and your module name');
        }
        //mkdir();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $dir = $objectManager->get('\Magento\Framework\App\Filesystem\DirectoryList');
        $base = $dir->getPath('base');
        $moduleDir = $base.'/app/code/'.$namespace.'/'.$module;

        //Make module
        mkdir($moduleDir,0754,true);
        $content='<?php
use \Magento\Framework\Component\ComponentRegistrar;
ComponentRegistrar::register(ComponentRegistrar::MODULE,"';
        $content.= $namespace.'_'.$module.'",__DIR__);?>';
        $fp = fopen($moduleDir."/registration.php","wb");
        fwrite($fp,$content);
        fclose($fp);

        // Make etc
        mkdir($moduleDir.'/etc',0754,true);
        $content='<?xml version="1.0" encoding="UTF-8" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="';
        $content.= $namespace.'_'.$module.'" setup_version="1.0.0"/>
</config>';
        $fp = fopen($moduleDir."/etc/module.xml","wb");
        fwrite($fp,$content);
        fclose($fp);

        $output->writeln('Create module success.');
    }
}