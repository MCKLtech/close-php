<?php

namespace Close;

use Http\Client\Exception;
use stdClass;

class CloseUsers extends CloseResource
{
    /**
     * Get yourself (me)
     *
     * @see    https://developer.close.com/#users
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function me(array $options = [])
    {
        return $this->client->get("me", $options);
    }

    /**
     * Lists Users. Defaults to same org. as the authenticated user
     *
     * @see    https://developer.close.com/#users-list-all-the-users-who-are-members-of-the-same-organizations-as-you-are
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getUsers(array $options = [])
    {
        return $this->client->get('user', $options);
    }

    /**
     * Gets a single User based on their Close ID.
     *
     * @see    https://developer.close.com/#users-fetch-a-single-user
     * @param  string $id
     * @param  array  $options
     * @return stdClass
     * @throws Exception
     */
    public function getUser(string $id, array $options = [])
    {
        $path = $this->userPath($id);

        return $this->client->get($path, $options);
    }

    /**
     * Fetch the availability statuses of all users within an organization
     *
     * @see    https://developer.close.com/#users-fetch-the-availability-statuses-of-all-users-within-an-organization
     * @param array $options
     * @return stdClass
     */
    public function availability(array $options = [])
    {
        return $this->client->get('user/availability', $options);
    }

    /**
     * @param string $id
     * @return string
     */
    public function userPath(string $id)
    {
        return 'user/' . $id;
    }
}
