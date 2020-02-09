<?php

declare(strict_types=1);

namespace DiAnalyzer\Command;

use DiAnalyzer\Analyzer\ModuleAnalyzer;
use DiAnalyzer\Di\DiData;
use DiAnalyzer\Di\MetadataFinder;
use DiAnalyzer\Di\MetadataLoader;
use DiAnalyzer\Writer\CsvWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Analyze compiled DI metadata
 */
class AnalyzeCommand extends Command
{
    /**
     * @var MetadataFinder
     */
    private $metadataFinder;

    /**
     * @var MetadataLoader
     */
    private $metadataLoader;

    /**
     * @var ModuleAnalyzer
     */
    private $moduleAnalyzer;

    /**
     * @var CsvWriter
     */
    private $csvWriter;

    /**
     * AnalyzeCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->metadataFinder = new MetadataFinder();
        $this->metadataLoader = new MetadataLoader();
        $this->moduleAnalyzer = new ModuleAnalyzer();
        $this->csvWriter = new CsvWriter();
    }

    /**
     *
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('analyze');
        $this->setDescription('Analyze Magento Compiled Metadata');

        $this->addArgument(
            'metadata-dir',
            InputArgument::REQUIRED,
            'Path to directory with metadata (e.g. generated/metadata)'
        );

        // todo: validate input for area names

        $this->addOption(
            'areas',
            'a',
            InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
            'Areas to analyze (e.g. global, frontend, adminhtml, crontab, webapi_soap, webapi_rest)',
            []
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $metadataDir = $input->getArgument('metadata-dir');
        $areas = $input->getOption('areas');

        $output->writeln('Analyzing DI metadata from ' . $metadataDir . ' directory...');

        /** @var DiData[] $metadataFiles */
        $metadataFiles = [];

        foreach ($this->metadataFinder->find($metadataDir, $areas) as $file) {
            $metadataFiles[] = $this->metadataLoader->load($file);
        }

        $moduleReport = $this->moduleAnalyzer->analyze($metadataFiles);

        $this->csvWriter->save('di-analyzer.report.csv', $moduleReport);

        return 0;
    }
}