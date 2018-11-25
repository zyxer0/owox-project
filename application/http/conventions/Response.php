<?php

namespace App\Http\Conventions;

interface Response
{

    /**
     * @return Response
     */
    public static function getInstance();

    public function sendHeaders();

    public function sendContent();

    public function send();

    public function setContent($content);

    public function getContent();

    public function setProtocolVersion(string $version);

    public function getProtocolVersion(): string;

    public function setStatusCode(int $code, $text = null);
}