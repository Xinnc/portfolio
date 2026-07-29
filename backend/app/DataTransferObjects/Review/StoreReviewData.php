<?php

namespace App\DataTransferObjects\Review;

use App\Concerns\ValidationError;
use Spatie\LaravelData\Attributes\Validation\Between;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Regex;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;


class StoreReviewData extends Data
{
    use ValidationError;

    public function __construct(
        #[Required, StringType, Min(3), Max(255)]
        public string $title,

        #[Required, StringType, Min(10), Max(1000)]
        public string $description,

        #[Required, StringType, Min(4), Max(100)]
        public string $name,
    )
    {
    }

//    public static function rules(): array
//    {
//        return [
//            'g-recaptcha-response' => 'required|captcha',
//        ];
//    }

    public static function attributes(): array
    {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'name' => 'Имя пользователя',
        ];
    }
}
