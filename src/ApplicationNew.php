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
    protected Container $container;

    public static function init(): self
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $builder = new ContainerBuilder();
        $builder->addDefinitions(new DefinitionFile(__DIR__ . '/../config/services.php'));

        return new self($builder->build());
    }

    public function run(
        string $controller = IndexController::class,
        string $action = 'index'
    ) {
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



        dd($this->container->get($controller)->$action());

        return $this;
    }

    private function __construct(Container $container)
    {
        $this->container = $container;
    }
}
