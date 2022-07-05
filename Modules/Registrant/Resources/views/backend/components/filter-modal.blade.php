<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Filter Data Pendaftar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="js-datatable-filter-form">
              @include('registrant::backend.components.filter-form')
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
        <button id="filterSubmit" type="button" class="btn btn-primary" data-dismiss="modal">Filter</button>
      </div>
    </div>
  </div>
</div>


<x-library.select2 />

@push ('after-scripts')

<script type="text/javascript">
  var notification_count = 0;
    $('#filterSubmit').on('click', function (e) {
      $('.js-datatable-filter-form :input').each(function () {
          if( $(this).val() != ""){
            notification_count+=1;
          }
        });

        console.log(notification_count);
        if(notification_count > 0){
          $('#filter-count').html("Tabel Disaring Menggunakan "+notification_count+" Filter");
          $('#clear-filter').show();
        }else{
          $('#filter-count').html("");
          $('#clear-filter').hide();
        }
        
        notification_count = 0;
        
        window.LaravelDataTables["registrants-table"].draw();
    });

    $('#registrants-table').on('preXhr.dt', function ( e, settings, data ) {
      $('.js-datatable-filter-form :input').each(function () {
          data[$(this).prop('name')] = $(this).val();
      });
    });

    $('#clear-filter').on('click', function (e) {
        $('.js-datatable-filter-form :input').each(function () {
          $(this).val("");
        });

        window.LaravelDataTables["registrants-table"].draw();

        $('#filter-count').html("");
        $('#clear-filter').hide();
    });

</script>
@endpush