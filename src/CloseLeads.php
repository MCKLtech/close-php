<?php

namespace Close;

use Http\Client\Exception;
use stdClass;

class CloseLeads extends CloseResource
{
    /**
     * Creates a Lead.
     *
     * @see    https://developer.close.com/#leads-create-a-new-lead
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create(array $options)
    {
        return $this->client->post("lead", $options);
    }

    /**
     * Updates a Lead.
     *
     * @see    https://developer.close.com/#leads-update-an-existing-lead
     * @param  string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function update(string $id, array $options)
    {
        $path = $this->leadPath($id);
        return $this->client->put($path, $options);
    }

    /**
     * Lists Leads.
     *
     * @see    https://developer.close.com/#leads-list-or-search-for-leads
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getLeads(array $options = [])
    {
        return $this->client->get('lead', $options);
    }

    /**
     * Gets a single Lead based on the Close Lead ID.
     *
     * @see    https://developer.close.com/#leads-retrieve-a-single-lead
     * @param  string $id
     * @param  array  $options
     * @return stdClass
     * @throws Exception
     */
    public function getContact(string $id, array $options = [])
    {
        $path = $this->leadPath($id);
        return $this->client->get($path, $options);
    }

    /**
     * Permenently Deletes a single Lead based on the Close ID.
     *
     * @see    https://developer.close.com/#leads-delete-a-lead
     * @param  string $id
     * @param  array  $options
     * @return stdClass
     * @throws Exception
     */
    public function deleteLead(string $id, array $options = [])
    {
        $path = $this->leadPath($id);
        return $this->client->delete($path, $options);
    }

    /**
     * Returns list of Leads that match search query.
     *
     * @see     https://developer.close.com/#search
     * @param   array $options
     * @return  stdClass
     * @throws  Exception
     */
    public function search(array $options)
    {
        return $this->client->get('lead', $options);
    }

    /**
     * Returns list of Custom Fields for Leads
     *
     * @see     https://developer.close.com/#custom-fields-list-all-the-lead-custom-fields-for-your-organization
     * @param array $options
     * @return stdClass
     */

    public function customFields(array $options = []) {

        return $this->client->get('custom_field/lead', $options);
    }

    /**
     * Returns list of Statuses for Leads
     *
     * @see     https://developer.close.com/#lead-statuses
     * @param array $options
     * @return stdClass
     */

    public function statuses(array $options = []) {

        return $this->client->get('status/lead', $options);
    }

    /**
     * @param string $id
     * @return string
     */
    public function leadPath(string $id)
    {
        return 'lead/' . $id;
    }
}
