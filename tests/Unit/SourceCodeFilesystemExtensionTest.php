<?php

namespace Phpactor\Extension\SourceCodeFilesystem\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phpactor\Container\PhpactorContainer;
use Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor\FilePathResolverExtension\FilePathResolverExtension;
use Phpactor\Filesystem\Domain\Filesystem;
use Phpactor\Filesystem\Domain\FilesystemRegistry;

class SourceCodeFilesystemExtensionTest extends TestCase
{
    /**
     * @dataProvider provideFilesystems
     */
    public function testFilesystems(string $filesystem)
    {
        $registry = $this->createRegistry($filesystem);
        $this->assertInstanceOf(Filesystem::class, $registry->get($filesystem));
    }

    public function provideFilesystems()
    {
        yield [ 'git' ];
        yield [ 'simple' ];
        yield [ 'composer' ];
    }

    public function createRegistry(): FilesystemRegistry
    {
        $container = PhpactorContainer::fromExtensions([
            SourceCodeFilesystemExtension::class,
            FilePathResolverExtension::class,
            ComposerAutoloaderExtension::class,
        ]);

        return $container->get(SourceCodeFilesystemExtension::SERVICE_REGISTRY);
    }

}
