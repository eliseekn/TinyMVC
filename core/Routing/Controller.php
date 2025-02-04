<?php

declare(strict_types=1);

namespace Core\Routing;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Validator\Validator;
use Core\Support\Cookies;
use Core\Support\Session;

class Controller
{
    public function __construct(
        public Request $request,
        public Response $response,
        public Session $session,
        public Cookies $cookies
    ) {
    }

    public function redirectUrl(string $uri, array $queries = []): void
    {
        $this->response->url($uri, $queries)->send();
    }

    public function redirectRoute(string $route, array $params = []): void
    {
        $this->response->route($route, $params)->send();
    }

    public function redirectBack(): void
    {
        $this->response->back()->send();
    }

    public function render(string $view, array $data = []): void
    {
        $this->response->view($view, $data)->send(200);
    }

    public function response(string $data, int $code = 200): void
    {
        $this->response->data($data)->send($code);
    }

    public function jsonResponse(array $data, int $code = 200): void
    {
        $this->response->json($data)->send($code);
    }

    public function downloadResponse(string $filename, int $code = 200): void
    {
        $this->response->download($filename)->send($code);
    }

    public function validate(Validator $validator): array
    {
        return $validator
            ->validate($this->request->inputs(), $this->response)
            ->validated();
    }
}
