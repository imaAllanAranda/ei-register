<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Carbon;

use App\Models\Testsignature;
use PHPUnit\Util\Test;

class MemoController extends Controller
{

    // public function __construct()
    // {
    //     // set_time_limit(8000000);
    //     ini_set('max_execution_time', '300');
    //     ini_set('max_execution_time', '0');
    // }

    public function index()
    {
        // $test = "asdasdas";
        // dd($test);
        return view('memos.index');
    }


    public function testget()
    {
        return view('test');
    }



    public function submitmemo(Request $request)
    {

        $memo_data = Memo::all();
        $year = Carbon::now()->format('Y');
        $numCount = $memo_data->count();
        $order_num = str_pad($numCount + 1, 3, "0", STR_PAD_LEFT);
        $memo_num_format = 'MEMOEI' . $year . $order_num;
        $memo = new Memo;
        $memo->memo_date = $request->memo_date;
        $memo->memo_num = $memo_num_format;
        $memo->recipient = $request->recipient;
        $memo->recipient_company = $request->recipient_company;
        $memo->recipient_address = $request->recipient_address;
        $memo->subject = $request->subject;
        $memo->content = $request->content;
        $memo->name_of_writer = $request->name_of_writer;
        $memo->position_of_writer = $request->position_of_writer;
        $memo->signature_of_writer = $request->signature64;
        $memo->save();

        // $msg = $request->signature64;

        if (!empty($memo)) {
            $status = '1';
            $message = 'created';
            return response()->json(array(
                'status'    => $status,
                'message'   => $message,
                'msg'       => $memo
            ), 200);
        } else {
            $status = 'error';
            return response()->json(array(
                'status'    => $status,

            ), 200);
        }
    }



    public function memoupdate(Request $request)
    {
        $id = $request->id;
        $memo =  Memo::findOrFail($id);
        $memo->memo_date = $request->memo_date;

        $memo->recipient = $request->recipient;
        $memo->recipient_company = $request->recipient_company;
        $memo->recipient_address = $request->recipient_address;
        $memo->subject = $request->subject;
        $memo->content = $request->content;
        $memo->name_of_writer = $request->name_of_writer;
        $memo->position_of_writer = $request->position_of_writer;
        $memo->save();

        if (!empty($memo)) {
            $status = '1';
            $message = 'updated';
            return response()->json(array(
                'status'    => $status,
                'message'   => $message,
                'msg'       => $memo
            ), 200);
        } else {
            $status = 'error';
            return response()->json(array(
                'status'    => $status,

            ), 200);
        }
    }



    public function pdf(Memo $memo)
    {
        
        $pdf = Pdf::loadView('pdf.memos.show', [
            'title' => 'Memo',
            'memo' => $memo,
        ], [], [
            'instanceConfigurator' => function ($mpdf) {
                $mpdf->setAutoBottomMargin = 'stretch';
            },
        ]);
        return $pdf->stream();
    }
}
