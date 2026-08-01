<?php

namespace App\DataTransferObjects\Project;

use App\Concerns\ValidationError;
use Spatie\LaravelData\Attributes\Validation\AlphaDash;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class StoreProjectData extends data
{
    use ValidationError;

    public static function authorize(): bool
    {
        return true;
    }

    public function __construct(
        #[Required, StringType, Min(3), Max(255)]
        public string $title,

        #[Nullable, StringType, Min(10), Max(2000)]
        public ?string $description,

        #[Required, Date]
        public string $project_date,
    )
    {
    }

    public static function attributes(): array
    {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'category_id' => 'Категория проекта',
            'project_date' => 'Дата съемки проекта'
        ];
    }
}
