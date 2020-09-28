<?php

namespace Close;

use Http\Client\Exception;
use stdClass;

class CloseContacts extends CloseResource
{
    /**
     * Creates a Contact.
     *
     * @see    https://developer.close.com/#contacts-create-a-new-contact
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create(array $options)
    {
        return $this->client->post("contact", $options);
    }

    /**
     * Updates a Contact.
     *
     * @see    https://developer.close.com/#contacts-update-an-existing-contact
     * @param  string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function update(string $id, array $options)
    {
        $path = $this->contactPath($id);
        return $this->client->put($path, $options);
    }

    /**
     * Lists Contacts.
     *
     * @see    https://developer.close.com/#contacts-list-contacts
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getContacts(array $options = [])
    {
        return $this->client->get('contact', $options);
    }

    /**
     * Gets a single Contact based on the Close Contact ID.
     *
     * @see    https://developer.close.com/#contacts-fetch-a-single-contact
     * @param  string $id
     * @param  array  $options
     * @return stdClass
     * @throws Exception
     */
    public function getContact(string $id, array $options = [])
    {
        $path = $this->contactPath($id);
        return $this->client->get($path, $options);
    }

    /**
     * Permenently Deletes a single Contact based on the Close ID.
     *
     * @see    https://developer.close.com/#contacts-delete-a-contact
     * @param  string $id
     * @param  array  $options
     * @return stdClass
     * @throws Exception
     */
    public function deleteContact(string $id, array $options = [])
    {
        $path = $this->contactPath($id);
        return $this->client->delete($path, $options);
    }

    /**
     * Returns list of Contacts that match search query.
     *
     * @see     https://developer.close.com/#search
     * @param   array $options
     * @return  stdClass
     * @throws  Exception
     */
    public function search(array $options)
    {
        return $this->client->get('contact', $options);
    }

    /**
     * Returns list of Custom Fields for Contacts
     *
     * @see     https://developer.close.com/#custom-fields-list-all-the-contact-custom-fields-for-your-organization
     * @param array $options
     * @return stdClass
     */

    public function customFields(array $options = []) {

        return $this->client->get('custom_field/contact', $options);
    }

    /**
     * @param string $id
     * @return string
     */
    public function contactPath(string $id)
    {
        return 'contact/' . $id;
    }
}
