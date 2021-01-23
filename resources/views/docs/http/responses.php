<?php $this->layout('docs/layout', [
    'page_title' => 'HTTP Responses | Documentation'
]) ?>

<?php $this->start('page_content') ?>

<div class="card mb-5" id="basic-routing">
    <div class="card-header">HTTP Responses</div>

    <div class="card-body">
        <p class="font-weight-bold">Send HTTP responses from Response class</p>
        <p>Send basic HTTP response</p>
        
        <div class="card mb-4">
            <pre class="m-0"><code class="p-3">Response::send($body, bool $json = false, array $headers = [], int $status_code = 200);</code></pre>
        </div>

        <p>Send HTTP headers only</p>
        
        <div class="card mb-4">
            <pre class="m-0"><code class="p-3">Response::headers(array $headers, int $status_code = 200);</code></pre>
        </div>

        <p class="font-weight-bold">Send HTTP responses inside Controller</p>
        <p>Example :</p>
        
        <div class="card">
            <pre class="m-0"><code class="p-3">&lt;?php

namespace App\Controllers;

use Framework\Routing\Controller;

class MyController extends Controller
{
    /**
     * @return void
     */
    public function index(): void
    {
        $this->headers(['Access-Control-Allow-Origin' => '*']); //send response headers only
        //or
        $this->response('Hello world!'); //send basic HTTP response
        //or
        $this->response(['response' => 'Hello world!'], true); //send JSON response
    }
}</code></pre>
        </div>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <span>Next: <a href="<?= absolute_url('docs/guides/client') ?>">HTTP Client</a></span>
        <span>Previous: <a href="<?= absolute_url('docs/guides/requests') ?>">HTTP Requests</a></span>
    </div>
</div>

<?php $this->stop() ?>