<?php

namespace Close;

use Http\Client\Exception;
use stdClass;

class CloseActivities extends CloseResource
{
    /**
     * Creates an Activity.
     *
     * @see    https://developer.close.com/#activities-create-a-note-activity
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create(string $type, array $options)
    {
        return $this->client->post("activity/$type", $options);
    }

    /**
     * Updates an Activity
     *
     * @see    https://developer.close.com/#activities-update-a-note-activity
     * @param string $id
     * @param string $type
     * @param array $options
     * @return stdClass
     */
    public function update(string $id, string $type, array $options)
    {
        return $this->client->put("activity/$type/$id", $options);
    }

    /**
     * Lists Activities.
     *
     * @see    https://developer.close.com/#activities
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getActivities(array $options = [])
    {
        return $this->client->get('activity', $options);
    }

    /**
     * Gets a single Activity based on Type and ID
     *
     * @see    https://developer.close.com/#activities-fetch-a-single-created-activity
     * @param string $id
     * @param string $type
     * @param array $options
     * @return stdClass
     */
    public function getActivity(string $id, string $type, array $options = [])
    {
        return $this->client->get("activity/$type/$id", $options);
    }

    /**
     * Permenently Deletes a single Activity based on Type and ID
     *
     * @see    https://developer.close.com/#activities-delete-a-note-activity
     * @param string $id
     * @param string $type
     * @param array $options
     * @return stdClass
     */
    public function deleteActivity(string $id, string $type, array $options = [])
    {
        return $this->client->delete("activity/$type/$id", $options);
    }

    /**
     * Returns list of Custom Fields for Leads
     *
     * @see     https://developer.close.com/#custom-fields-list-all-the-activity-custom-fields-for-your-organization
     * @param array $options
     * @return stdClass
     */

    public function customFields(array $options = []) {

        return $this->client->get('custom_field/activity', $options);
    }
}
