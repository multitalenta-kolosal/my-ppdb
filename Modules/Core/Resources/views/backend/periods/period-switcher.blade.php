@php
$period_list = \Modules\Core\Entities\Period::pluck('period_name','id')->all();
@endphp
<div class="">
    <div class="row">
        <div class="col">
            <div class="form-group pt-3">
                <?php
                $field_name = 'period_name';
                $field_data_id = 'period_name';
                $field_lable = __("core::period.$field_name");
                $field_placeholder = __("Select an option");
                $required = "required";
                $select_options = $period_list;
                ?>
                {{ html()->select($field_data_id, $select_options,my_period())->placeholder($field_placeholder)->class('form-control select2 pr-5')->attributes(["$required"]) }}
            </div>
        </div> 
    </div>

</div>

@push('after-scripts')
<script>
    $(document).ready(function (){
        $("#period_name").on('change', function(){  
            $.ajax({
                method: "GET",
                url: "{{route('backend.periods.changeSessionPeriod')}}",
                data:{
                    "_token": "{{ csrf_token() }}",
                    "now_period": this.value,
                },
                success: function (data) {
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                }
            });  
            location.reload();
        });
    });
</script>
@endpush
    