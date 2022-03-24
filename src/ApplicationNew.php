<?php
declare(strict_types=1);

namespace KanbanBoard;

use DI\Container;
use DI\ContainerBuilder;
use DI\Definition\Source\DefinitionFile;
use Dotenv\Dotenv;
use KanbanBoard\Application\Controller\IndexController;
use RuntimeException;

class ApplicationNew
{
    protected const SERVICES_FILE = __DIR__ . '/../config/services.php';
    protected const ENV_DIR = __DIR__ . '/../';

    protected Container $container;

    public static function init(): self
    {
        Dotenv::createImmutable(self::ENV_DIR)->load();

        $builder = new ContainerBuilder();
        $builder->addDefinitions(new DefinitionFile(self::SERVICES_FILE));

        return new self($builder->build());
    }

    public function run(
        string $controller = IndexController::class,
        string $action = 'index'
    ): void {
        if (!class_exists($controller)) {
            throw new RuntimeException(
                sprintf('Controller \'%s\' does not exists', $controller)
            );
        }

        if (!method_exists($controller, $action)) {
            throw new RuntimeException(
                sprintf('Method \'%s\' does not exists', $action)
            );
        }

        $this->container->get($controller)->$action();
    }

    private function __construct(Container $container)
    {
        $this->container = $container;
    }
}
