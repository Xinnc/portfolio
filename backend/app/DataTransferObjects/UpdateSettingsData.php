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

class UpdateSettingsData extends data
{
    use ValidationError;

    public static function authorize(): bool
    {
        return true;
    }

    public function __construct(
        #[Nullable, StringType, Min(1), Max(255)]
        public ?string $telegram,

        #[Nullable, StringType, Min(1), Max(255)]
        public ?string $instagram,

        #[Nullable, StringType, Min(1), Max(255)]
        public ?string $whatsapp,

        #[Nullable, StringType, Min(1), Max(255)]
        public ?string $vk,

        #[Nullable, StringType, Min(1), Max(255)]
        public ?string $max,
    )
    {
    }

    public function getFilledFields(): array
    {
        $filled = [];

        if ($this->telegram) {
            $filled['telegram'] = $this->telegram;
        }
        if ($this->instagram) {
            $filled['instagram'] = $this->instagram;
        }
        if ($this->whatsapp) {
            $filled['whatsapp'] = $this->whatsapp;
        }
        if ($this->vk) {
            $filled['vk'] = $this->vk;
        }
        if ($this->max) {
            $filled['max'] = $this->max;
        }

        return $filled;
    }
}
