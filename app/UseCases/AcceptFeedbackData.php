<?php


namespace App\UseCases;

use DateTime;

class AcceptFeedbackData
{
    public function __construct(
        public string $title,
        public string $description,
        public DateTime $datetime,
        public int $service_id,
        public int $rating,
    ) {}
}
