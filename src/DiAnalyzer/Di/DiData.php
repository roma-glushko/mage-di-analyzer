<?php

declare(strict_types=1);

namespace DiAnalyzer\Di;

use Symfony\Component\Console\Command\Command;

/**
 * DI Data Model
 */
class DiData extends Command
{
    /**
     * @var string
     */
    private $area;

    /**
     * @var int
     */
    private $size;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @var array
     */
    private $preferences;

    /**
     * @var array
     */
    private $instanceTypes;

    /**
     * @return string
     */
    public function getArea(): string
    {
        return $this->area;
    }

    /**
     * @param string $area
     */
    public function setArea(string $area): void
    {
        $this->area = $area;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * @return array
     */
    public function getPreferences(): array
    {
        return $this->preferences;
    }

    /**
     * @param array $preferences
     */
    public function setPreferences(array $preferences): void
    {
        $this->preferences = $preferences;
    }

    /**
     * @return array
     */
    public function getInstanceTypes(): array
    {
        return $this->instanceTypes;
    }

    /**
     * @param array $instanceTypes
     */
    public function setInstanceTypes(array $instanceTypes): void
    {
        $this->instanceTypes = $instanceTypes;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }
}
