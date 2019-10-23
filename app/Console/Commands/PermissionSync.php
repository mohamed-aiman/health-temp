<?php

namespace App\Console\Commands;

use App\Permission;
use App\Resource;
use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PermissionSync extends Command
{
    /**
     * router
     * @var Router
     */
    protected $router;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'permission:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize system permission table.';


    protected $collection;

    public function __construct(Router $router, Permission $permission)
    {
        parent::__construct();

        $this->permission = $permission;
        $this->router = $router;
        $this->routes = $router->getRoutes();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (count($this->routes) === 0) {
            return $this->error("Your application doesn't have any routes.");
        }

        $this->saveRoutesAsPermissions($this->getRoutes());
    }

    /**
     * Compile the routes into a displayable format.
     *
     * @return array
     */
    protected function getRoutes()
    {
        $routes = collect($this->routes)->map(function ($route) {
            return $this->getRouteInformation($route);
        })->all();

        return array_filter($routes);
    }

    /**
     * Get the route information for a given route.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return array
     */
    protected function getRouteInformation(Route $route)
    {
        return [
            'host'   => $route->domain(),
            'method' => implode('|', $route->methods()),
            'uri'    => $route->uri(),
            'name'   => $route->getName(),
            'action' => ltrim($route->getActionName(), '\\'),
            'middleware' => $this->getMiddleware($route),
        ];
    }

    /**
     * Get before filters.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return string
     */
    protected function getMiddleware($route)
    {
        return collect($route->gatherMiddleware())->map(function ($middleware) {
            return $middleware instanceof Closure ? 'Closure' : $middleware;
        })->implode(',');
    }

    public function saveRoutesAsPermissions($routes)
    {
        foreach ($routes as $route) {
        // "host" => null
        // "method" => "POST"
        // "uri" => "logout"
        // "name" => "logout"
        // "action" => "App\Http\Controllers\Auth\LoginController@logout"
        // "middleware" => "web"
            if ($route['name']) {
                if ($this->permission->where('slug', $route['name'])->first()) {
                    $this->warn('permission created: slug:' . $route['name'] . ' name:' . $route['uri']);
                } else {
                    if ($this->permission->create([
                        'slug' => $route['name'],
                        'name' => $route['uri'],
                    ])) {
                        $this->info('permission created: slug:' . $route['name'] . ' name:' . $route['uri']);
                    }
                }  
            } else {
                $this->error('no route name for route: ' . json_encode($route));
            }
        }
    }
}

