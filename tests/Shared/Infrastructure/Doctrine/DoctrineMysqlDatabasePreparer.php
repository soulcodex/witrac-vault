<?php

namespace Witrac\Tests\Shared\Infrastructure\Doctrine;

use App\Kernel;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class DoctrineMysqlDatabasePreparer implements DatabasePreparer
{
    public function __construct(
        private Kernel $kernel,
        private DatabaseCleaner $cleaner,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @throws Exception
     */
    public function beforeClass(): void
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $application->run(new ArrayInput([
            'command' => 'doctrine:database:create',
        ]), new NullOutput());

        $application->run(new ArrayInput([
            'command' => 'doctrine:migrations:migrate',
            '--no-interaction' => true,
        ]), new NullOutput());
    }

    /**
     * @throws Exception
     */
    public function afterClass(): void
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $application->run(new ArrayInput([
            'command' => 'doctrine:database:drop',
            '--force' => true,
            '--no-interaction' => true,
        ]), new NullOutput());
    }

    public function beforeTest(): void
    {
        $this->cleaner->clean($this->entityManager);
    }

    public function afterTest(): void
    {
    }
}
