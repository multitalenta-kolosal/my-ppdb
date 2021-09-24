
@inject('unit', \Modules\Core\Services\UnitService::class)

<div class="modal fade" id="contact-modal" tabindex="2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <h5 class="modal-title" id="exampleModalLabel">Kontak Kami</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card">
            <div class="row">
            @foreach($unit->getList()->data as $unit)
                    <?php
                      $crude_number = $unit->contact_number;
                      $clean_number = \Str::replaceFirst('0','62',$crude_number);
                    ?>
                    <div class="col p-2 my-2 text-center">
                        <h5>{{$unit->name}}</h5>
                        <div class="m-2">
                           <a type="button" href="https://wa.me/{{$clean_number}}" id ="{{$unit->id}}" class="btn btn-success">
                            <i class="fab fa-lg fa-whatsapp text-white"></i>
                            <span class="text-white">
                              {{'+'.$clean_number}}
                            </span>
                          </a>
                        </div>
                        <div class="m-2">
                            <i class="fas fa-lg fa-envelope text-danger"></i><br>
                            {{$unit->contact_email}}
                        </div>
                    </div>
            @endforeach
            </div>
        </div>
      </div>
    </div>
  </div>
</div>