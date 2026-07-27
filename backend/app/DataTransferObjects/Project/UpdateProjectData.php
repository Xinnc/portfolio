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

class UpdateProjectData extends data
{
    use ValidationError;

    public static function authorize(): bool
    {
        return true;
    }

    public function __construct(
        #[Nullable, StringType, Min(3), Max(255)]
        public ?string $title,

        #[Nullable, StringType, Min(10), Max(2000)]
        public ?string $description,

        #[Nullable, Date]
        public ?string $project_date,
    )
    {
    }

    public static function attributes(): array
    {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'project_date' => 'Дата съемки проекта'
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
        if ($this->project_date) {
            $filled['project_date'] = $this->project_date;
        }
        return $filled;
    }
}
