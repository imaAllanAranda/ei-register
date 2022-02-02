<?php

namespace App\Actions\Memo;

use App\Models\Memo;
use App\Traits\Validators\MemoValidator;
use Illuminate\Support\Facades\Validator;


class UpdateMemo
{
    use MemoValidator;

    public function update($input, Memo $memo)
    {
        $data = Validator::make($input, $this->memoRules(), [], $this->memoAttributes())->validate();

        $memo->update($data);
    }
}
