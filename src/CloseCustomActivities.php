<?php

namespace Close;

use Http\Client\Exception;
use stdClass;

class CloseCustomActivities extends CloseResource
{
    /**
     * See CloseActivities for further methods e.g. Create Custom Activity Instance etc
     */

    /**
     * Creates a Custom Activity.
     *
     * @see    https://developer.close.com/#custom-activities-create-new-custom-activity-type
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create(array $options)
    {
        return $this->client->post("custom_activity", $options);
    }

    /**
     * Updates a Custom Activity
     *
     * @see    https://developer.close.com/#custom-activities-update-existing-custom-activity-type
     * @param string $id

     * @param array $options
     * @return stdClass
     */
    public function update(string $id, array $options)
    {
        return $this->client->put("custom_activity/$id", $options);
    }

    /**
     * Lists All Custom Activities.
     *
     * @see    https://developer.close.com/#custom-activities-list-custom-activity-types
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getActivities(array $options = [])
    {
        return $this->client->get('custom_activity', $options);
    }

    /**
     * Gets a single Custom Activity by ID
     *
     * @see    https://developer.close.com/#custom-activities-retrieve-a-single-custom-activity-type
     * @param string $id
     * @param array $options
     * @return stdClass
     */
    public function getActivity(string $id, array $options = [])
    {
        return $this->client->get("custom_activity/$id", $options);
    }

    /**
     * Permenently Deletes a single Custom Activity Type by ID
     *
     * @see    https://developer.close.com/#custom-activities-delete-a-custom-activity-type
     * @param string $id
     * @param array $options
     * @return stdClass
     */
    public function deleteActivity(string $id, array $options = [])
    {
        return $this->client->delete("custom_activity/$id", $options);
    }
}
