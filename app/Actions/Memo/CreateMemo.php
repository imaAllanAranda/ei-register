<?php

namespace App\Actions\Memo;

use App\Models\Memo;
use App\Traits\Validators\MemoValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
// use Illuminate\Http\Request;

class CreateMemo
{

    use MemoValidator;

    // public $signature_of_writer;

    public function create($input)
    {

        $data = Validator::make($input, $this->memoRules(), [], $this->memoAttributes())->validate();

        $memo_data = Memo::all();
        $year = Carbon::now()->format('Y');
        $numCount = $memo_data->count();
        $order_num = str_pad($numCount + 1, 3, "0", STR_PAD_LEFT);
        $memo_num_format = 'MEMOEI' . $year . $order_num;
        $data['memo_num'] = $memo_num_format;


        // $data['signature_of_writer'] = $memo_num_format;
        // $data['signature_of_writer'] = "testing signature";
        // $writer = [];
        // // $writer_signature = $data['signature_of_writer'];
        // // print_r($data['signature_of_writer']);

        // $folderPath = public_path('signatures/');
        // $image_parts = explode(";base64,", $data['signature_of_writer']);
        // $image_type_aux = explode("image/", $image_parts[0]);
        // $image_type = $image_type_aux[1];
        // $image_base64 = base64_decode($image_parts[1]);
        // $signature = uniqid() . '.' . $image_type;
        // $file = $folderPath . $signature;
        // file_put_contents($file, $image_base64);
        // $data['signature_of_writer'] = $signature;
        // dd($data['signature_of_writer']);

        // $memo = Memo::create($data);

        dd($data);

        // return $memo;
    }
}
