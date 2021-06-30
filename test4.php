<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://oss.sheetjs.com/sheetjs/xlsx.full.min.js"></script>
    <script src="assets/FileSaver/FileSaver.js-master/FileSaver.min.js"></script>
  
    <title>Document</title>
</head>
<body>
<div id="navbar"><span>Red Stapler - SheetJS </span></div>
  <div id="wrapper">
      <table id="mytable">
        <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Company</th>
          </tr>
          <tr>
            <th colspan="3">Department Of Computer Science</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Harry</td>
            <td>Potter</td>
            <td>WB</td>
            </tr>
            <tr>
            <td>Captain</td>
            <td>America</td>
            <td>Marvel</td>
          </tr>
        </tbody>
        <tfoot>
        </tfoot>
      </table>
      <button id="button-a">Create Excel</button>
  </div>
<script>
        var wb = XLSX.utils.table_to_book(document.getElementById('mytable'), {sheet:"Sheet JS"});
        var wbout = XLSX.write(wb, {bookType:'xlsx', bookSST:true, type: 'binary'});
        function s2ab(s) {
                        var buf = new ArrayBuffer(s.length);
                        var view = new Uint8Array(buf);
                        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                        return buf;
        }
        $("#button-a").click(function(){
        saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'test.xlsx');
        });
</script>
</body>
</html>