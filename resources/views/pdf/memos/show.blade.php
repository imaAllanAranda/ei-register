<!DOCTYPE html>
<html>
<title>Memo</title>
<head>
  <style type="text/css">
    pre {font-family: Trebuchet MS, sans-serif
    }

    @page{
      margin-left: 120px;
      margin-right: 50px;
      header: page-header;
      footer: page-footer;
    }
    .response{
      text-align: justify;
      text-justify: inter-word;
    }
    #title{
      text-align: center;
    }
    p{
      font-size: 13px;
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

    <div style="position:absolute;top:0.26in;left:7.4in;width:90px;line-height:0.27in; background-color: #1881c7;height:70px;">

      <span style="background-colro:red"></span><br><br><br>

    </div>

    <div style="position:absolute;top:0.26in;left:6.1in;width:150px;line-height:0.27in;">
      <p>{{ $memo->memo_num }}</p>
    </div>


    <div style="position:absolute;top:1.26in;left:1.2in;width:190px;line-height:0.27in;">
      <p>
        <?php
        $orig_date =  explode('-', $memo->memo_date);
        $con_date = $orig_date[0].'-'.$orig_date[1].'-'.$orig_date[2];
        echo date("jS F Y", strtotime($con_date));
        ?>
      </p>
    </div>

    <div id="recipient" style="position:absolute;top:1.90in;left:1.2in;width:200px;line-height:0.17in;">
      <p>
        <strong>{{ $memo->recipient }}</strong>
      </p>
      <p>{{ $memo->recipient_company }}</p>
      <p>{{ $memo->recipient_address }}</p>
    </div>

    <div style="position:absolute;top:3.20in;left:1.2in;width:200px;line-height:0.17in;">
      <p>Dear Team,</p>
    </div>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <div style="text-align: center;"><p style="font-family: calibri; color:#3b76d4; font-size: 17px;letter-spacing: .5px;
    ">{{ $memo->subject }}</p>
  </div>
<!-- 
    <div style="position:absolute;top:3.5in;padding-left: 50px"><p style="font-family: calibri; color:#3b76d4; font-size: 17px;letter-spacing: .5px;
">{{ $memo->subject }}</p>
</div> -->

<div style="position:absolute;top:3.78in;left:1.2in;width:600px;line-height:0.17in;">
  <hr style="color:#3b76d4;">
</div>

<div style="position:absolute;top:4.28in;left:1.2in;width:600px;line-height:0.17in;">
  <p>{!! $memo->content !!}</p>

  <br><br><br>
  <p style="font-size: 13px;">Regards,</p>
  <div style="padding-top: -30px;"><img src="{{ $memo->signature_of_writer }}" alt="" height="70" width="100" ></div>
  <div style="padding-top: -30px;"><p style="font-size: 13px;" >{{ $memo->name_of_writer }}</p></div>
  <div style="text-align: center; width:120px; padding-top: -10px;"><hr style="  border-top: 1px dotted black;"></div>
  <div style="text-align: center; width:120px; padding-top: -20px;"><p style="font-size: 13px;">{{ $memo->position_of_writer }}</p></div>
</div>
</div>

<htmlpagefooter name="page-footer">
  <div class="footer" style="font-size:6pt;">
    <img src="{{ asset('images/horizontal-logo.png') }}" alt="eliteinsure" class="logo" width="200"/>
    <div style="margin-left:460px; margin-top:-15px;" >
      <a style="font-size:11px;" href="https://eliteinsure.co.nz" class="footer-link" target="_blank">
        www.eliteinsure.co.nz
      </a>&nbsp;|&nbsp;Page
      {PAGENO}
    </div>
  </div>
</footer>
</htmlpagefooter>

</body>
</html>






