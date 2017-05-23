<!DOCTYPE html>
<html>
<head>
  <title>TestPDF</title>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style>
    table{
      border-collapse: collapse;
      align-content: center;
    }
    td,th{
      border: 1px solid;
      padding-top: 5px;
      padding-bottom: 5px;
    }
    .txt_align{
      text-align: center;
    }
    /*www.ishare.in.th*/
    @font-face {
            font-family: 'THSarabun';
            font-style: normal;
            font-weight: normal;
            src: url("file://{{ public_path('fonts/THSarabun.ttf') }}") format('truetype');
    }@font-face {
        font-family: 'THSarabun';
        font-style: normal;
        font-weight: bold;
        src: url("file://{{ public_path('fonts/THSarabun Bold.ttf') }}") format('truetype');
    }
    @font-face {
        font-family: 'THSarabun';
        font-style: italic;
        font-weight: normal;
        src: url("file://{{ public_path('fonts/THSarabun Italic.ttf') }}") format('truetype');
    }
    @font-face {
        font-family: 'THSarabun';
        font-style: italic;
        font-weight: bold;
        src: url("file://{{ public_path('fonts/THSarabun Bold Italic.ttf') }}") format('truetype');
    }
    body {
        font-family: "THSarabun";
    }
    h2{
      margin-left: 2.7cm;
    }
    .txt_pading {
        padding-left: 15px;
    }
  </style>
</head>
<body>
    <h2>{{"Subject name : ".$sub_name}}<br>{{"Practice name : ".$pract_name}}</h2>
    <table align="center">
        <tr>
          <th class="txt_align" width="120">Student ID</th>
          <th class="txt_align" width="180">Student Name</th>
          <th class="txt_align" width="80">Student Score</th>
        </tr>
      @foreach($std_score as $key => $val)
        <tr>
          <td class="txt_align" width="120">{{$val['student_id']}}</td>
          <td class="txt_pading" width="180">{{$val['name']}}</td>
          <td class="txt_align" width="80">{{$val['score']}}</td>
        </tr>
      @endforeach
    </table>
</div>
</body>
</html>
