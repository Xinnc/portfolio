<?php

namespace App\DataTransferObjects\category;

use App\Concerns\ValidationError;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\AlphaDash;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class UpdateCategoryData extends data
{
    use ValidationError;

    public static function authorize(): bool
    {
        return true;
    }

    public function __construct(
        #[Nullable, StringType, Min(3), Max(255)]
        public ?string $title,

        #[Nullable, StringType, Min(3), Max(100), AlphaDash, Unique('categories', 'slug')]
        public ?string $slug,

        #[Nullable, StringType, Max(1000)]
        public ?string $description,

        #[Nullable, IntegerType, Min(0)]
        public ?int $sort_order,

        #[Nullable]
        public ?UploadedFile $cover_image,
    )
    {
    }

    public static function attributes(): array
    {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'slug' => 'Название в адресной строке(латиница)',
            'sort_order' => 'Порядковый номер(0 - откл)',
            'cover_image' => 'Обложка',
        ];
    }

    public static function rules(): array
    {
        return [
            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,jfif'
            ],
        ];
    }

    public function getFilledFields(): array
    {
        $filled = [];

        if ($this->title) {
            $filled['title'] = $this->title;
        }
        if ($this->description) {
            $filled['description'] = $this->description;
        }
        if ($this->slug) {
            $filled['slug'] = $this->slug;
        }
        if ($this->sort_order !== null) {
            $filled['sort_order'] = $this->sort_order;
        }
        if ($this->cover_image) {
            $filled['cover_image'] = $this->cover_image;
        }
        return $filled;
    }
}
