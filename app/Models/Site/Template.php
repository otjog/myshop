<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $casts = [
        'options' => 'array',
    ];

    public function getTemplateWithContent($contentKey, $templateName = 'default'){
        $options = self::select(
            'id',
            'name',
            'options'
        )
            ->where('name', $templateName)
            ->first();

        $currenTemplate = $options->options;

        $currenTemplate['content'] = array_get($currenTemplate['content'], $contentKey, null);

        $options['current'] = $currenTemplate;

        return $options;
    }
}
