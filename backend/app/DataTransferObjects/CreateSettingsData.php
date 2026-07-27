<?php

namespace App\DataTransferObjects;

use App\Concerns\ValidationError;
use Spatie\LaravelData\Attributes\Validation\AlphaDash;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class CreateSettingsData extends data
{
    use ValidationError;

    public static function authorize(): bool
    {
        return true;
    }

    public function __construct(
        #[Nullable, StringType, Max(255)]
        public ?string $telegram,

        #[Nullable, StringType, Max(255)]
        public ?string $instagram,

        #[Nullable, StringType, Max(255)]
        public ?string $whatsapp,

        #[Nullable, StringType, Max(255)]
        public ?string $vk,

        #[Nullable, StringType, Max(255)]
        public ?string $max,
    )
    {
    }

}
