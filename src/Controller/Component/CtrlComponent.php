<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Utility\Hash;
use ReflectionClass;
use ReflectionMethod;

/**
 * Ctrl component
 */
class CtrlComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    protected $_printActions = [];

    public function initialize(array $config): void
    {
        $this->_printActions = $config;
    }

    public function getControllers()
    {
        $files = scandir(APP . 'Controller/');
        $results = [];
        $ignoreList = [
            '.',
            '..',
            'Component',
            'AppController.php',
        ];
        foreach ($files as $file) {
            if (!in_array($file, $ignoreList)) {
                $controller = explode('.', $file)[0];
                array_push($results, str_replace('Controller', '', $controller));
            }
        }
        return $results;
    }

    public function getActions($controllerName)
    {
        $className = 'App\\Controller\\' . $controllerName . 'Controller';
        $class = new ReflectionClass($className);
        $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $results = [$controllerName => []];
        $ignoreList = ['beforeFilter', 'afterFilter', 'initialize'];
        foreach ($actions as $action) {
            if ($action->class == $className && !in_array($action->name, $ignoreList)) {
                array_push($results[$controllerName], $action->name);
            }
        }
        return $results;
    }

    public function getResources()
    {
        $controllers = $this->getControllers();
        $resources = [];
        foreach ($controllers as $controller) {
            $actions = $this->getActions($controller);
            array_push($resources, $actions);
        }
        return $resources;
    }

    /**
     * returns array
     * [ Controller::action => Controller::action ]
     *
     * @return array
     */
    public function getPrintActions(): array
    {
        $controllersWithActions = $this->getResources();
        $flattened = [];

        foreach ($controllersWithActions as $cA) {
            foreach ($cA as $controller => $actions) {
                if (in_array($controller, array_keys($this->_printActions))) {
                    foreach ($actions as $action) {
                        if (in_array($action, array_values($this->_printActions[$controller]))) {
                            $flattened[] = $controller . '::' . $action;
                        }
                    }
                }
            }
        }

        return array_combine($flattened, $flattened);
    }

    public function getMenuActions()
    {
        $controllersWithActions = $this->getResources();
        $flattened = [];

        foreach ($controllersWithActions as $cA) {
            foreach ($cA as $controller => $actions) {
                foreach ($actions as $action) {
                    $flattened[] = $controller . '::' . $action;
                }
            }
        }
        sort($flattened);
        return array_combine($flattened, $flattened);
    }
}