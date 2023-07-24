<?php


namespace App\UseCases;


use App\Models\Feedback;

class FeedbackUseCases
{
    public function acceptFeedback(AcceptFeedbackData $data): Feedback
    {
        $feedback = Feedback::make();
        $feedback->title = $data->title;
        $feedback->description = $data->description;
        $feedback->datetime = $data->datetime->format('Y-m-d H:i:s');
        $feedback->service_id = (integer) $data->service_id;
        $feedback->rating = (integer) $data->rating;
        $feedback->save();
        $feedback->refresh();

        return $feedback;
    }
}
