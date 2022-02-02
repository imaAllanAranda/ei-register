<?php

namespace App\Traits\Validators;

trait MemoValidator
{
    public function memoRules()
    {
        return [
            'memo_date' => ['required', 'date_format:Y-m-d'],
            // 'memo_num' => ['required', 'string', 'max:255'],
            'recipient' => ['required', 'string', 'max:255'],
            'recipient_company' => ['required', 'string', 'max:255'],
            'recipient_address' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'between:1,20000'],
            'name_of_writer' => ['required', 'string', 'max:255'],
            'position_of_writer' => ['required', 'string', 'max:255'],
            'signature_of_writer' => ['nullable'],
            // 'fsp_no' => ['required_if:type,Adviser', 'nullable', 'integer', 'max:999999999'],
        ];
    }

    public function memoAttributes()
    {
        return [
            'memo_date' => 'Memo Date',
            // 'memo_num'  => 'Memo Number',
            'recipient' => 'Recipient',
            'recipient_company' => 'Recipient Company',
            'recipient_address' => 'Recipient Address',
            'subject' => 'Subject',
            'content' => 'Content',
            'name_of_writer' => 'Writer Name',
            'position_of_writer' => 'Writer Position',
            'signature_of_writer' => 'Writer Signature',
        ];
    }
}
