
<div class="modal fade" id="modal_{{$model->registrant_id ?? 'no_data'}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<!-- <div class="modal fade" id="modal_tes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    title
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div name="form">
                <div class="modal-body">
                    <form role="form" id="form_{{$model->id}}" method="PATCH" action="{{ route('backend.registrantStages.update', $model->registrant_stage ?? '0') }}">
                        @csrf
                        <!-- <input type="hidden" name="_method" id="_method" value="PATCH">-->
                        <input type="hidden" name="registrant_id" id="registrant_id_{{$model->id}}" value="{{ $model->registrant_id }}"> 
                        <div class="row">
                            <div class="col">
                                <div class="form-group shadow p-2 mb-2 bg-white rounded">
                                    <?php
                                    $field_name = 'va_pass';
                                    $required = "";
                                    $checked = ( ($model->registrant_stage->$field_name ?? 'nope') == '1' ) ? 'checked' : '';
                                    ?>
                                    <div class="row">
                                        <div class="col-2">
                                            {{ html()->checkbox($field_name.$model->id)->class('form-control float-left')->attributes(["$required", "$checked"]) }}
                                        </div>
                                        <div class="col-2 align-self-center text-success"  id="col_{{$field_name}}_{{$model->id}}">
                                            @if($model->registrant_stage)
                                                @if($model->registrant_stage->$field_name)
                                                    <i class="far fa-lg fa-check-circle"></i>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                    
            </div>
        </div>
    </div>
</div>
    