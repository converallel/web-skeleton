<?php

namespace Native\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class NativeResourceOwner implements ResourceOwnerInterface
{
    /**
     * Raw response
     *
     * @var array
     */
    protected $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function getId()
    {
        $this->response['id'];
    }

    public function toArray()
    {
        $this->response;
    }
}