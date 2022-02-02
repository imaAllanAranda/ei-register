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

        // $folderPath = public_path('signatures/');
        // $image_parts = explode(";base64,", $request->signature_of_writer);
        // $image_type_aux = explode("image/", $image_parts[0]);
        // $image_type = $image_type_aux[1];
        // $image_base64 = base64_decode($image_parts[1]);
        // $signature = uniqid() . '.' . $image_type;
        // $file = $folderPath . $signature;
        // file_put_contents($file, $image_base64);

        // $insert = new Testsignature;
        // $insert->signature = $request->signature;
        // $insert->save();

        // var_dump("asdsad");

        // $data['memo_num'] = $memo_num_format;
        // $id = $request->id;
        // if (!empty($id)) {

        //     $memo =  Memo::findOrFail($id);
        //     $memo->memo_date = $request->memo_date;
        //     // $memo->memo_num = $memo_num_format;
        //     $memo->recipient = $request->recipient;
        //     $memo->recipient_company = $request->recipient_company;
        //     $memo->recipient_address = $request->recipient_address;
        //     $memo->subject = $request->subject;
        //     $memo->content = $request->content;
        //     $memo->name_of_writer = $request->name_of_writer;
        //     $memo->position_of_writer = $request->position_of_writer;
        //     $memo->signature_of_writer = $request->signature64;
        //     $memo->save();

        //     if (!empty($memo)) {
        //         $status = 'success';
        //         $message = 'Memo has been updated.';
        //         return response()->json(array(
        //             'status'    => $status,
        //             'message'   => $message,
        //             'msg'       => $memo
        //         ), 200);
        //     } else {
        //         $status = 'error';
        //         return response()->json(array(
        //             'status'    => $status,

        //         ), 200);
        //     }
        // } else {
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
            $status = 'success';
            $message = 'Memo has been registered.';
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
        // }



        // return response()->json(array('msg' => $memo), 200);
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
        $memo->signature_of_writer = $request->signature64;
        $memo->save();

        if (!empty($memo)) {
            $status = 'success';
            $message = 'Memo has been updated.';
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


        $footer = '<p>asdasdsda</p>';


        $pdf = Pdf::loadView('pdf.memos.show', [
            'title' => 'Memo',
            'memo' => $memo,
        ], [], [
            'instanceConfigurator' => function ($mpdf) {
                $mpdf->setAutoBottomMargin = 'stretch';
                //         $mpdf->SetHTMLFooter(
                //             '
                // <p style="font-size:9px;; text-align: justify; font-family: calibri;">Disclaimer: Eliteinsure has used reasonable endeavours to ensure the accuracy and completeness of the information provided but makes no warranties as to the accuracy or completeness of such information. The information should not be taken as advice. Eliteinsure accepts no responsibility for the results of any omissions or actions taken on basis of this information. This report includes commercially sensitive information. Accordingly, it may be used for the purpose provided; may not be disclosed to any third party; and will be subject to any obligation of confidence owed by the recipient under contract or otherwise.</p><footer>
                // <div class="footer" style="font-size:6pt;">
                // <img src="assets/admin/img/logo.png" alt="eliteinsure" class="logo" width="200"/>
                // <div style="margin-left:520px; margin-top:-15px;" >
                // <a style="font-size:11px;" href="https://eliteinsure.co.nz" class="footer-link" target="_blank">
                // www.eliteinsure.co.nz
                // </a>&nbsp;|&nbsp;Page
                // {PAGENO}
                // </div>
                // </div>
                // </footer>'
                //         );

                $mpdf->setFooter('{PAGENO}');
            },
        ]);
        // set_time_limit(300);
        // return $pdf->stream('memo.pdf');
        return $pdf->stream();



        // $htmlFooter = '
        // <p style="font-size:9px;; text-align: justify; font-family: calibri;">Disclaimer: Eliteinsure has used reasonable endeavours to ensure the accuracy and completeness of the information provided but makes no warranties as to the accuracy or completeness of such information. The information should not be taken as advice. Eliteinsure accepts no responsibility for the results of any omissions or actions taken on basis of this information. This report includes commercially sensitive information. Accordingly, it may be used for the purpose provided; may not be disclosed to any third party; and will be subject to any obligation of confidence owed by the recipient under contract or otherwise.</p><footer>
        // <div class="footer" style="font-size:6pt;">
        // <img src="assets/admin/img/logo.png" alt="eliteinsure" class="logo" width="200"/>
        // <div style="margin-left:520px; margin-top:-15px;" >
        // <a style="font-size:11px;" href="https://eliteinsure.co.nz" class="footer-link" target="_blank">
        // www.eliteinsure.co.nz
        // </a>&nbsp;|&nbsp;Page
        // {PAGENO}
        // </div>
        // </div>
        // </footer>';

        // $mpdf = new \Mpdf\Mpdf();
        // $report = view('pdf.memos.show', [
        //     'title' => 'Memo',
        //     'memo' => $memo,
        // ]);
        // $mpdf->SetHTMLFooter($htmlFooter);
        // $mpdf->WriteHTML($report);
        // $mpdf->Output('I');


        // return view('memos.index');
    }
}
