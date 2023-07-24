<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Service;
use App\UseCases\AcceptFeedbackData;
use App\UseCases\FeedbackUseCases;
use DateTime;
use DateTimeZone;
use Illuminate\Http\JsonResponse;

class FeedbackController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Service::select('id', 'title')->get();

        return response()->json($services);
    }

    public function store(FeedbackStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $feedback = app(FeedbackUseCases::class)->acceptFeedback(new AcceptFeedbackData(
            title: $data['title'],
            description: $data['description'],
            datetime: $this->convertTimestampToDT($data['datetime']),
            service_id: $data['service_id'],
            rating: $data['rating'],
        ));

        return response()->json([
            'id' => $feedback->id
        ], 201);
    }

    public function show(Feedback $feedback): JsonResponse
    {
        return response()->json([
            'title' => $feedback->title,
            'description' => $feedback->description,
            'datetime' => DateTime
                    ::createFromFormat('Y-m-d H:i:s', $feedback->datetime)
                    ->getTimestamp() * 1000,
            'service_name' => Service::select('id', 'title')
                ->whereId($feedback->service_id)
                ->first()
                ->title,
            'rating' => $feedback->rating,
        ]);
    }

    private function convertTimestampToDT($microtime): DateTime
    {
        $dt = DateTime::createFromFormat('U', floor($microtime / 1000));
        $dt->setTimeZone(new DateTimeZone('Europe/Moscow'));
        return $dt;
    }
}
