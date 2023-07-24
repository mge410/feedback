<?php

namespace App\Http\Controllers\Feedback;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'datetime' => 'required|int',
            'service_id' => 'required|integer|exists:service,id',
            'rating' => 'required|integer|min:1|max:5',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Это поле необходимо для заполнения',
            'title.string' => 'Название должно быть в виде строки',

            'description.required' => 'Это поле необходимо для заполнения',
            'description.string' => 'Описание должно быть в виде текста',

            'datetime.required' => 'Это поле необходимо для заполнения',
            'datetime.int' => 'Дата должна быть в виде числа',

            'service_id.required' => 'Это поле необходимо для заполнения',
            'service_id.integer' => 'Сервис должен быть в виде числа',
            'service_id.exists' => 'Похоже такого сервиса не существует',

            'rating.required' => 'Это поле необходимо для заполнения',
            'rating.integer' => 'Рейтинг должен быть числом от одного до пяти',
            'rating.min' => 'Рейтинг должен быть числом от одного до пяти',
            'rating.max' => 'Рейтинг должен быть числом от одного до пяти',
        ];
    }
}
