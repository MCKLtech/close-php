<?php

namespace Close;

use Http\Client\Exception;
use stdClass;

class ClosePipelines extends CloseResource
{
    /**
     * Lists Pipelines.
     *
     * @see    https://developer.close.com/#pipelines-list-pipelines-for-your-organization
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getPipelines(array $options = [])
    {
        return $this->client->get('pipeline', $options);
    }
}
