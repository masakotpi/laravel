
$(function(){
    $('#bulk-check-action').on('click', function() {
        if(!$(this).prop('checked')){
            $('.each_ids').prop('checked',false);
        }else{
            $('.each_ids').prop('checked',true);
        }
    })


    var element = document.getElementById( "csvdata" ) ;
    var resultElement = document.getElementById( "result" ) ;
    var fileReader = new FileReader() ;
  

    element.onchange = function () {
        resultElement.textContent = "" ;
        var file = element.files[0] ;
        fileReader.readAsText( file ) ;
    // fileReader.abort() ;	// 読み込みを中止！
    }

    fileReader.onload = function ( event ) {
        var result = event.target.result;
        var tableHtml = makeCSV(result);
        resultElement.insertAdjacentHTML("beforeend", tableHtml);
 
    }
    var lastError ;

    //CSVを出力する関数
    function makeCSV(csvdata) {
        //5:csvデータを1行ごとに配列にする
        var tmp = csvdata.split("\n");
        html = `<table class="table">\n<tr><td>`;
        //6：1行のデータから各項目（各列）のデータを取りだして、2次元配列にする
        //各列を格納する変数
        var data = [];
        for (var i = 0; i < tmp.length; i++) {
            //csvの1行のデータを取り出す
            var row_data = tmp[i]; 

            html += `<tr><td>`;
            html += row_data.replaceAll(',', "</td><td>")
            html += `</td></tr>\n`;
        }
        html += `</table>`;
        console.log(html);
      return html;
    }
    
        
   

    
});

