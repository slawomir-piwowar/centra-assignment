<?php
declare(strict_types=1);

namespace KanbanBoard;

use DI\Container;
use DI\ContainerBuilder;
use DI\Definition\Source\DefinitionFile;
use DI\Definition\Source\ReflectionBasedAutowiring;
use Dotenv\Dotenv;
use KanbanBoard\Application\Controller\IndexController;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Application
{
    protected const SERVICES_FILE = __DIR__ . '/../config/services.php';
    protected const ENV_DIR = __DIR__ . '/../';

    private Container $container;
    private Mustache_Engine $viewEngine;
    private Response $response;

    private function __construct(Container $container, Response $response, Mustache_Engine $viewEngine)
    {
        $this->container = $container;
        $this->viewEngine = $viewEngine;
        $this->response = $response;
    }

    public static function init(): self
    {
        Dotenv::createImmutable(self::ENV_DIR)->load();

        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->addDefinitions(new DefinitionFile(self::SERVICES_FILE, new ReflectionBasedAutowiring()));

        $container = $builder->build();

        // TODO: use factory to make it replaceable
        $viewEngine = new Mustache_Engine([
            'pragmas' => [Mustache_Engine::PRAGMA_BLOCKS],
            'loader' => new Mustache_Loader_FilesystemLoader('../src/views'),
            'cache' => '../var/cache',
        ]);

        return new self($container, $container->get(Response::class), $viewEngine);
    }

    public function run(string $controller = IndexController::class, string $action = 'index'): void
    {
        if (!class_exists($controller)) {
            throw new RuntimeException(
                sprintf('Controller \'%s\' does not exists', $controller),
            );
        }

        if (!method_exists($controller, $action)) {
            throw new RuntimeException(
                sprintf('Method \'%s\' does not exists', $action),
            );
        }

        $template = static function (string $controller, string $action): string {
            $explodedController = explode('\\', $controller);

            return sprintf(
                '%s/%s',
                str_replace('controller', '', strtolower(array_pop($explodedController))),
                $action,
            );
        };

        try {
            $context = $this->container->get($controller)->$action();
            $templateName = $template($controller, $action);

            if (!is_array($context)) {
                throw new RuntimeException('Returning array data in controller is required');
            }
        } catch (Throwable $throwable) {
            $templateName = 'error/error';
            $context = [
                'message' => $throwable->getMessage(),
                'code' => $throwable->getCode(),
                'exception' => $throwable,
            ];
        } finally {
            $this->response->setContent($this->viewEngine->render($templateName, $context));
            $this->response->send();
        }
    }
}
