<?php

namespace Close;

use Http\Client\Exception;
use stdClass;

class CloseTasks extends CloseResource
{
    /**
     * Creates a Task.
     *
     * @see    https://developer.close.com/#tasks-create-a-task
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function create(array $options)
    {
        return $this->client->post("task", $options);
    }

    /**
     * Updates A Task
     *
     * @see    https://developer.close.com/#tasks-update-a-task
     * @param  string $id
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function update(string $id, array $options)
    {
        $path = $this->taskPath($id);

        return $this->client->put($path, $options);
    }

    /**
     * Lists Tasks.
     *
     * @see    https://developer.close.com/#tasks-list-or-filter-tasks
     * @param  array $options
     * @return stdClass
     * @throws Exception
     */
    public function getTasks(array $options = [])
    {
        return $this->client->get('task', $options);
    }

    /**
     * Gets a single Task based on the Close Task ID.
     *
     * @see    https://developer.close.com/#tasks-fetch-a-tasks-details
     * @param  string $id
     * @param  array  $options
     * @return stdClass
     * @throws Exception
     */
    public function getTask(string $id, array $options = [])
    {
        $path = $this->taskPath($id);
        return $this->client->get($path, $options);
    }

    /**
     * Permenently Deletes a single Tasks based on the Close ID.
     *
     * @see    https://developer.close.com/#tasks-delete-a-task
     * @param  string $id
     * @param  array  $options
     * @return stdClass
     * @throws Exception
     */
    public function deleteTask(string $id, array $options = [])
    {
        $path = $this->taskPath($id);
        return $this->client->delete($path, $options);
    }

    /**
     * @param string $id
     * @return string
     */
    public function taskPath(string $id)
    {
        return 'task/' . $id;
    }
}
