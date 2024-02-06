<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait TraitUploadImage
{
    public function upload_image(string $title, string $directory, object $image)
    {
        $name_img = "/img/$directory/" . Str::slug($title);
        $name_path_image = $this->generate_name_image($name_img, $image->extension());
        $image->storeAs('', $name_path_image);

        return $name_path_image;
    }

    public function generate_name_image(string $path_name, string $extension)
    {
        return $path_name . '-' . rand(1000, 9999) . '.' . $extension;
    }
}
