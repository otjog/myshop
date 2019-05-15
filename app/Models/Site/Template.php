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

        $currentTemplate = $options->options;

        $currentTemplate['content'] = array_get($currentTemplate['content'], $contentKey, null);

        $options['current'] = $currentTemplate;

        return $options;
    }
}
