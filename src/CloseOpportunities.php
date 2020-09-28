<?php

namespace Close;

use Http\Client\Exception;
use stdClass;

class CloseOpportunities extends CloseResource
{
    /**
     * Creates an Opportunity.
     *
     * @see    https://developer.close.com/#opportunities-create-an-opportunity
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create(array $options)
    {
        return $this->client->post("opportunity", $options);
    }

    /**
     * Updates am Opportunity.
     *
     * @see    https://developer.close.com/#opportunities-update-an-opportunity
     * @param  string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function update(string $id, array $options)
    {
        $path = $this->oppPath($id);
        return $this->client->put($path, $options);
    }

    /**
     * Lists Opportunities.
     *
     * @see    https://developer.close.com/#opportunities-list-or-filter-opportunities
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getOpportunities(array $options = [])
    {
        return $this->client->get('opportunity', $options);
    }

    /**
     * Gets a single Opportunities based on the Close Opportunity ID.
     *
     * @see    https://developer.close.com/#opportunities-retrieve-an-opportunity
     * @param  string $id
     * @param  array  $options
     * @return stdClass
     * @throws Exception
     */
    public function getOpportunity(string $id, array $options = [])
    {
        $path = $this->oppPath($id);
        return $this->client->get($path, $options);
    }

    /**
     * Permenently Deletes a single Opp based on the Close ID.
     *
     * @see    https://developer.close.com/#opportunities-delete-an-opportunity
     * @param  string $id
     * @param  array  $options
     * @return stdClass
     * @throws Exception
     */
    public function deleteOpportunity(string $id, array $options = [])
    {
        $path = $this->oppPath($id);
        return $this->client->delete($path, $options);
    }

    /**
     * Returns list of Statuses for Opportunities
     *
     * @see     https://developer.close.com/#opportunity-statuses
     * @param   array $options
     * @return  stdClass
     */

    public function statuses(array $options = []) {

        return $this->client->get('status/opportunity', $options);
    }

    /**
     * Returns list of Opportunties that match search query.
     *
     * @see     https://developer.close.com/#search
     * @param   array $options
     * @return  stdClass
     * @throws  Exception
     */
    public function search(array $options)
    {
        return $this->client->get('opportunity', $options);
    }

    /**
     * @param string $id
     * @return string
     */
    public function oppPath(string $id)
    {
        return 'opportunity/' . $id;
    }
}
