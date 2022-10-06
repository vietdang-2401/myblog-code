<?php 

namespace middlewares;

use core\Application;
use core\Middleware;

class AuthMiddleware extends Middleware {
    public function handle() {
        if (!Application::$app->isLogin()) {
            header('location: /login');
        }
    }
}

?>