<?php

namespace App\Traits\Validators;

trait SiteValidator
{
    public function siteRules()
    {
        return [
            'name' => ['required', 'string', 'unique:sites'],
            'url' => ['required', 'string', 'url', 'unique:sites'],
            'launch_date' => ['required', 'date_format:Y-m-d'],
            'description' => ['required', 'string'],
        ];
    }

    public function siteAttributes()
    {
        return [
            'name' => 'Name',
            'url' => 'Link',
            'launch_date' => 'Date Launched',
            'description' => 'Description',
        ];
    }
}
