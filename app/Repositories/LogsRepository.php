<?php

namespace App\Repositories;
use App\Models\Logs;

class LogsRepository
{

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
            // Return an error response
            throw new \Exception($e->getMessage()); // Throw an exception if all classes failed
            return response()->json(['error' => 'Error saving logs.'], 500);
        }
    }
}
