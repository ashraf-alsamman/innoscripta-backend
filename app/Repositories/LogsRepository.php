<?php

namespace App\Repositories;

use App\Models\Logs;

class LogsRepository
{
    /**
     * Save logs to the database.
     *
     * @param string $model
     * @param string $title
     * @param mixed $message
     * @return void
     * @throws \Exception
     */
    public function saveLogs(string $model, string $title, $message)
    {
        try {
            $data = new Logs();
            $data->title = $title;
            $data->model = $model;
            $message_str = json_encode($message);
            $limitedData = substr($message_str, 0, 400); // Limit the data to the first 400 characters
            $data->message = $limitedData;
            $data->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage()); // Throw an exception if saving logs fails
        }
    }
}
