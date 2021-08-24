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
    $('#filterSubmit').on('click', function (e) {
        window.LaravelDataTables["registrants-table"].draw();
    });

    $('#registrants-table').on('preXhr.dt', function ( e, settings, data ) {
        $('.js-datatable-filter-form :input').each(function () {
            data[$(this).prop('name')] = $(this).val();
        });
    });

    $('#filterModal').on('hidden.bs.modal', function (e) {
        // $('#{{$module_name}}-table').addClass("d-none");
        $('.js-datatable-filter-form :input').each(function () {
            $(this).val("");
        });
    })
</script>
@endpush