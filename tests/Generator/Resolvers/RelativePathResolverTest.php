<?php declare(strict_types=1);

namespace ApiGen\Tests\Generator\Resolvers;

use ApiGen\Configuration\Configuration;
use ApiGen\Generator\Resolvers\RelativePathResolver;
use ApiGen\Utils\FileSystem;
use Mockery;
use PHPUnit\Framework\TestCase;

class RelativePathResolverTest extends TestCase
{

    public function testGetRelativePath()
    {
        $configuration = Mockery::mock(Configuration::class);
        $configuration->shouldReceive('getOption')->with('source')->andReturn([TEMP_DIR]);
        $relativePathResolver = new RelativePathResolver($configuration, new FileSystem);

        $this->assertSame('some-file.txt', $relativePathResolver->getRelativePath(TEMP_DIR . '/some-file.txt'));
        $this->assertSame(
            'some/dir/some-file.txt',
            $relativePathResolver->getRelativePath(TEMP_DIR . '/some/dir/some-file.txt')
        );
    }


    public function testGetRelativePathWithWindowsPath()
    {
        $configuration = Mockery::mock(Configuration::class);
        $configuration->shouldReceive('getOption')->with('source')->andReturn(['C:\some\dir']);
        $relativePathResolver = new RelativePathResolver($configuration, new FileSystem);

        $this->assertSame('file.txt', $relativePathResolver->getRelativePath('C:\some\dir\file.txt'));
        $this->assertSame('more-dir/file.txt', $relativePathResolver->getRelativePath('C:\some\dir\more-dir\file.txt'));
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetRelativePathInvalid()
    {
        $configuration = Mockery::mock(Configuration::class);
        $configuration->shouldReceive('getOption')->with('source')->andReturn([TEMP_DIR]);
        $relativePathResolver = new RelativePathResolver($configuration, new FileSystem);

        $relativePathResolver->getRelativePath('/var/dir/some-strange-file.txt');
    }


    /**
     * Issue #408
     */
    public function testGetRelativePathWithSourceEndingSlash()
    {
        $configuration = Mockery::mock(Configuration::class);
        $configuration->shouldReceive('getOption')->with('source')->once()->andReturn(['ProjectBeta']);
        $configuration->shouldReceive('getOption')->with('source')->twice()->andReturn(['ProjectBeta/']);
        $relativePathResolver = new RelativePathResolver($configuration, new FileSystem);

        $fileName = 'ProjectBeta/entities/Category.php';
        $this->assertSame('entities/Category.php', $relativePathResolver->getRelativePath($fileName));

        $fileName = 'ProjectBeta/entities/Category.php';
        $this->assertSame('entities/Category.php', $relativePathResolver->getRelativePath($fileName));
    }
}
