<?php

namespace App\DataTransferObjects\category;

use App\Concerns\ValidationError;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\AlphaDash;
use Spatie\LaravelData\Attributes\Validation\Image;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Size;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class StoreCategoryData extends data
{
    use ValidationError;

    public static function authorize(): bool
    {
        return true;
    }

    public function __construct(
        #[Required, StringType, Min(3), Max(255)]
        public string $title,

        #[Required, StringType, Min(3), Max(100), AlphaDash, Unique('categories', 'slug')]
        public string $slug,

        #[Nullable, StringType, Max(1000)]
        public ?string $description = null,

        #[Nullable, IntegerType, Min(0)]
        public ?int $sort_order = 0,

        #[Nullable, Image]
        public UploadedFile $cover_image,
    )
    {
    }

    public static function attributes(): array
    {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'cover_image' => 'Обложка категории',
            'slug' => 'Название в адресной строке (латиница)',
            'sort_order' => 'Порядковый номер (0 - откл)',
        ];
    }
}
