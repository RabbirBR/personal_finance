<!-- jQuery 3 -->
<script src="{{ url('/') }}/dist/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('/') }}/dist/adminlte/bower_components/jquery-ui/jquery-ui.min.js"></script>

<!-- Select-2 -->
<script src="{{ url('/') }}/dist/adminlte/bower_components/select2/dist/js/select2.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
      $(document).ready(function(){
            $('body').find('.select2').select2({
            	width: '100%',
				placeholder: 'Select an option'
            });

            $.widget.bridge('uibutton', $.ui.button);
      });
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('/') }}/dist/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<!-- <script src="{{ url('/') }}/dist/adminlte/bower_components/fastclick/lib/fastclick.js"></script> -->
<!-- AdminLTE App -->
<script src="{{ url('/') }}/dist/adminlte/dist/js/adminlte.min.js"></script>