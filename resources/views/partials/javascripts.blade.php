
<script src="{{ url('adminlte/plugins/datatables-1.2/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/jQueryUI/jquery-ui.min.js') }}"></script>

<script src="{{ url('adminlte/plugins/datatables-1.2/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-1.2/buttons.flash.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-1.2/jszip.min.js') }}"></script>

<script src="{{ url('adminlte/plugins/datatables-1.2/pdfmake.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-1.2/vfs_fonts.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-1.2/buttons.html5.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-1.2/buttons.print.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-1.2/buttons.colVis.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-1.2/dataTables.select.min.js') }}"></script>
 
<script>
 

function on() {

  document.getElementById("overlay").style.display = "block";
}

function off() {
  document.getElementById("overlay").style.display = "none";
}
 
$('.modal').on('shown.bs.modal', function (e) {
  $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
  });


$(".modal").on("show.bs.modal", function () {
  var top = $("body").scrollTop(); $("body").css('position','fixed').css('overflow','hidden').css('top',-top).css('width','100%').css('height',top);
}).on("hide.bs.modal", function () {
  var top = $("body").position().top; $("body").css('position','relative').css('overflow','auto').css('top',0).scrollTop(-top);
});

function showLoader(){
      $(".loader").show();
    }

    function hideLoader(){    
        $(".loader").fadeOut();
    }
    function humanizeNumber(nStr) { nStr += ''; var x = nStr.split('.'); var x1 = x[0]; var x2 = x.length > 1 ? '.' + x[1] : ''; var rgx = /(\d+)(\d{3})/; while (rgx.test(x1)) { x1 = x1.replace(rgx, '$1' + ',' + '$2'); } return x1 + x2; }
</script>

@yield('javascript')