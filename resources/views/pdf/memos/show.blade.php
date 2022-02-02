<!DOCTYPE html>
<html>
<title>Memo</title>
<head>
  <style type="text/css">
    pre {font-family: Trebuchet MS, sans-serif
    }
    @page{
      margin-left: 50px;
      margin-right: 50px;
    }
    .response{
      text-align: justify;
      text-justify: inter-word;
    }
    #title{
      text-align: center;
    }
  </style>
</head>
<body style="font-family: Trebuchet MS, sans-serif	">


  <div style="position:absolute;top:0.26in;left:0in;width:90px;line-height:0.27in; background-color: #455a73;height:70px;">
    <span style="background-colro:red"></span>
  </div>


  <div style="position:absolute;top:0.72in;left:5.18in;width:4.36in;line-height:0.27in;">
    <span style="font-style:normal;font-weight:bold;font-size:15pt;font-family:Calibri;color:#44546a">
      <span style="font-style:normal;font-weight:bold;font-size:15pt;font-family:Calibri;color:#44546a">
      </span>
    </div>
    <div style="position:absolute;top:0.18in;left:1.20in;width:20.36in;line-height:0.27in;">
      <img src="{{ url('images/elitelogo.png') }}" alt="eliteinsure" class="logo" width="100"/>
    </div>


    <div style="position:absolute;top:0.26in;right:50.90n;width:150px;line-height:0.27in;">
      <p>{{ $memo->memo_num }}</p>
    </div>

    <div style="position:absolute;top:0.26in;left:7.4in;width:90px;line-height:0.27in; background-color: #1881c7;height:70px;">

      <span style="background-colro:red"></span><br><br><br>

    </div>














    <div class="row">&nbsp;
      <br />
      <br />
      <p>
        <?php
        $orig_date =  explode('-', $memo->memo_date);
        $con_date = $orig_date[0].'-'.$orig_date[1].'-'.$orig_date[2];
        echo date("jS M, Y", strtotime($con_date));
        ?>
      </p>




      <br />
      <br />

      <strong>{{ $memo->recipient }}</strong>
      <br />
      <label for="">{{ $memo->recipient_company }}</label>
      <br />
      <label for="">{{ $memo->recipient_address }}</label>
      <br />
      <br />
      <br />
      <label for="">Dear Team,</label>
      <br />
      <br />
      <div style="text-align: center;"><label id="title" class="title" style=""><strong>{{ $memo->subject }}</strong></label></div>
      <hr>
      {{-- <hr style="margin-right: 10%"> --}}
      <br />
      <br />
      <br />
      <label for="">{{ $memo->content }}</label>

      <br />
      <br />
      <label for="">You will receive an invoice from us in regards to this.</label>
      <br/><br/>
      <label for="">Regards,</label>
      <br/>
      <img src="{{ $memo->signature_of_writer }}" alt="" height="50">








    </div>





    <div style="position:absolute;top:7.40in;left:0.55in;width:150px;line-height:0.27in;">
      <label for="" >{{ $memo->name_of_writer }}</label>
    </div>

    <div style="position:absolute;top:7.60in;left:0.71in;width:150px;line-height:0.27in;">
      <label for="">{{ $memo->position_of_writer }}</label>
    </div>

    <div style="position:absolute;top:10.50in;left:0.71in;width:150px;line-height:0.27in;">
      <img src="{{ url('images/logo.png') }}" alt="" height="50">
    </div>
    {{-- <footer class="footer" name="page-footer">
      <table class="table-footer">
        <tr>
          <td colspan="2" class="text-sm text-justify" style="padding-left: 0.5in; padding-right: 0.5in;">
            Disclaimer: Eliteinsure has used reasonable endeavours to ensure the accuracy and completeness of
            the information provided but makes no warranties as to the accuracy or completeness of such
            information. The information should not be taken as advice. Eliteinsure accepts no responsibility
            for the results of any omissions or actions taken on basis of this information. This report includes
            commercially sensitive information. Accordingly, it may be used for the purpose provided; may not be
            disclosed to any third party; and will be subject to any obligation of confidence owed by the
            recipient under contract or otherwise.
          </td>
        </tr>
        <tr>
          <td class="footer-logo">
            <img src="{{ asset('images/horizontal-logo.png') }}"
            width="2.12in" />
          </td>
          <td class="footer-page">
            <a
            href="{{ config('services.company.url') }}"
            class="footer-link"
            target="_blank">{{ config('services.company.web') }}</a>&nbsp;|&nbsp;Page
            {PAGENO}
          </td>
        </tr>
      </table>
    </footer> --}}




  </div>
</body>
</html>






