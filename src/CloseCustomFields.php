<?php

namespace Close;

use Http\Client\Exception;
use stdClass;

class CloseCustomFields extends CloseResource
{
    /**
     * Creates a Custom Field. Default to 'lead' type
     *
     * @see    https://developer.close.com/#custom-fields-create-a-new-lead-custom-field
     * @param string $type
     * @param array $options
     * @return stdClass
     */
    public function create(string $type, array $options)
    {
        return $this->client->post("custom_field/$type", $options);
    }

    /**
     * Updates a Custom Field. Defaults to 'lead' type
     *
     * @see    https://developer.close.com/#custom-fields-update-a-lead-custom-field
     * @param string $id
     * @param string $type
     * @param array $options
     * @return stdClass
     */
    public function update(string $id, string $type, array $options)
    {
        return $this->client->put("custom_field/$type/$id", $options);
    }

    /**
     * Lists All Custom Fields. Defaults to 'lead' type
     *
     * @see    https://developer.close.com/#custom-fields-list-all-the-lead-custom-fields-for-your-organization
     * @param string $type
     * @param array $options
     * @return stdClass
     */
    public function getFields(string $type = 'lead', array $options = [])
    {
        return $this->client->get("custom_field/$type", $options);
    }

    /**
     * Gets a single Custom Field by ID. Defaults to 'lead' type
     *
     * @see    https://developer.close.com/#custom-fields-fetch-lead-custom-fields-details
     * @param string $id
     * @param string $type
     * @param array $options
     * @return stdClass
     */
    public function getField(string $id, string $type = 'lead', array $options = [])
    {
        return $this->client->get("custom_field/$type/$id", $options);
    }

    /**
     * Permanently Deletes a single Custom Field by ID. Defaults to 'lead' type
     *
     * @see    https://developer.close.com/#custom-fields-delete-a-lead-custom-field
     * @param string $id
     * @param string $type
     * @param array $options
     * @return stdClass
     */
    public function deleteActivity(string $id, string $type, array $options = [])
    {
        return $this->client->delete("custom_field/$type/$id", $options);
    }
}
