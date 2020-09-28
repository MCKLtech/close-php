<?php

namespace Close;

abstract class CloseResource
{
    /**
     * @var CloseClient
     */
    protected $client;

    /**
     * IntercomResource constructor.
     *
     * @param CloseClient $client
     */
    public function __construct(CloseClient $client)
    {
        $this->client = $client;
    }
}
