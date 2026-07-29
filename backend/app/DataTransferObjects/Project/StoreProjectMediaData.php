<?php

namespace App\DataTransferObjects\Project;

use App\Concerns\ValidationError;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;
class StoreProjectMediaData extends data
{
    use ValidationError;

    public static function authorize(): bool
    {
        return true;
    }

    public function __construct(

        /** @var UploadedFile[]|null */
        #[Required, ArrayType]
        public array $media,

    )
    {
    }

    public static function rules(): array
    {
        return [
            'media.*' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,mp4,mov,webm'
            ]
        ];
    }

    public static function attributes(): array
    {
        return [
            'media_url' => 'Фото/Видео',
        ];
    }
}
