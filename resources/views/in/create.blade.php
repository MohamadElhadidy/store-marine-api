@extends('layout.app')
@section('title', 'إذن دخول صنف جديد')
@section('style')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">

@endsection

@section('body')

      <section class="section">
          <div class="section-header">
            <h1>إذن دخول صنف جديد</h1>
            
          </div>
          <div class="section-body">
            @if (session('NewIn'))
                <div class="alert alert-success">
                    {{ session('NewIn') }}
                </div>
            @endif
          
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <form method="post" class="needs-validation" novalidate="" action="/in" enctype="multipart/form-data"  id="myForm" dir="rtl">
                    @csrf
                    <div class="card-header">
                            <a href='#' class="btn btn-primary"  id="new"> <li   class="fas fa-plus"></li>إضافة صنف جديد </a>
                    </div>
                    <div class="card-body">
                          <div class="row">         
                       <div class="form-group col-md-3 col-12">
                            <label  class="float-right">التاريخ</label>
                          <input type="text" name="dates" class="form-control datepicker">
                            <div class="invalid-feedback">     ادخل  التاريخ  </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('dates') }}</strong>

                          </div>
 <div class="form-group col-md-3 col-12">
                            <label  class="float-right"> المورد</label>
                            <select class="form-control select2" name='supplier' required >
                        <option disabled selected value="">أختر   المورد </option>
                        @foreach ( $suppliers as $supplier)
                            <option value=" {{ $supplier->id }}" {{ (old('supplier') == $supplier->id ? "selected":"") }}> {{ $supplier->name }}</option>
                        @endforeach                   
                      </select>          
                            <div class="invalid-feedback">     ادخل     المورد  </div>                       
                            <strong  class="float-right" style="color: red;">{{ $errors->first('supplier') }}</strong>
                          </div>
                  <div class="form-group col-md-3 col-12">
                            <label  class="float-right">    اسم موظف المخزن       </label>
                            <select class="form-control select2" name='entry' required >
                              <option disabled selected value="">أختر   اسم موظف المخزن   </option>
                              @foreach ( $entries as $entry)
                              <option value=" {{ $entry->id }}"  {{ (old('entry') == $entry->id ? "selected":"") }}> {{ $entry->name }}</option>
                              @endforeach                   
                          </select>                   
                            <div class="invalid-feedback">     ادخل      اسم موظف المخزن  </div>                                     
                            <strong  class="float-right" style="color: red;">{{ $errors->first('entry') }}</strong>
                      </div>
      <div class="form-group col-md-3 col-12">
                            <label  class="float-right">   المخزن      </label>
                            <select class="form-control select2" name='store' required >
                              <option disabled selected value="">أختر  المخزن  </option>
                              @foreach ( $stores as $store)
                              <option value=" {{ $store->id }}" {{ (old('store') == $store->id ? "selected":"") }}> {{ $store->name }}</option>
                              @endforeach                   
                          </select>            
                                  <div class="invalid-feedback">     ادخل     المخزن  </div>                       
                            <strong  class="float-right" style="color: red;">{{ $errors->first('store') }}</strong>
                      </div>
                        
                                                      

                        </div>
                      @php $i = 0 ; @endphp
                        <div class="now">
                        
                      <div class="row record">         
                            <div class="form-group col-md-4 col-12">
                            <label  class="float-right"> الصنف</label>
                            <select class="form-control" id="item1" name='item[]' required >
                            </select>           
                                <div class="invalid-feedback">     ادخل     الصنف  </div>                       
                            <strong  class="float-right" style="color: red;">{{ $errors->first('item.'.$i) }}</strong>
                          </div>
                           <div class="form-group col-md-2 col-12">
                            <label  class="float-right">عدد</label>
                            <input type="text" class="form-control" pattern="[0-9]+([\.,][0-9]+)?"  name="balance[]"   value="{{ old('balance.'.$i) }}"  required>
                            <div class="invalid-feedback">     ادخل     العدد  </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('balance.'.$i) }}</strong>
                                <script> a</script>
                          </div> 
                              <div class="form-group col-md-2 col-12">
                            <label  class="float-right">   سعر الوحدة  </label>
                            <input type="text" class="form-control"  name="price[]" pattern="[0-9]+([\.,][0-9]+)?"   value="{{ old('price.'.$i) }}"  required="">
                            <div class="invalid-feedback">     ادخل    سعر الوحدة  </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('price.'.$i) }}</strong>
                          </div>
                              <div class="form-group col-md-3 col-12">
                            <label  class="float-right">    مُلاحــظـــــات  </label>
                            <input type="text" class="form-control"  name="notes[]"   value="{{ old('notes.'.$i) }}" >

                          </div>
                          @php $i++ ; @endphp
                                  <a href='#' onclick="remove(this)" class="form-group col-md-1" style="font-size: 2.5rem !important;color: red;"  ><li   style="font-size: 1.5rem !important;" class="fas fa-trash-alt"></li></a>
                        </div>

                    
                        </div>
                  
                        <div class="card-footer text-center">
                      <button class="btn  btn-primary ">حفظ البيانات</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>

@endsection

@section('script')
  <script src="{{ asset('js/select2.full.min.js')}}"></script>
  <script src="{{ asset('js/daterangepicker.js')}}"></script>

<script type="text/javascript">
function remove(el) {
  $( el ).parent(':not(:first-child)').remove();
}
   $(document).ready(function(){
           
     $( "#item1" ).select2({
        ajax: { 
          url: "{{route('/select2-autocomplete-ajax')}}",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
                "_token": "{{ csrf_token() }}",
               search: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: true
        }

     });

   });

$("#new").click(function(e) {
$(".record:last").find('select').select2('destroy');
var clone =  $( ".record" ).last().clone() ;
var lastId = $(".record:last").find('select').attr('id');
var count = parseInt(lastId.replace('item', '') ) + 1;
var newId =  'item'+count;
jQuery(clone).find("select").attr("id",newId);

$( clone ).insertAfter(".record:last");

$(".record:last").find('input:text').val('');

for (let index = 1; index <= count; index++) {
  var forId =  'item'+index;
  
  $('#'+forId ).select2({
        ajax: { 
          url: "{{route('/select2-autocomplete-ajax')}}",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
                "_token": "{{ csrf_token() }}",
               search: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: true
        }

     });
}
    $(".record:last").find('select').val('').trigger('change');

});

  $('#myForm').on('submit', function(e){
      var form = $(this);
        e.preventDefault();
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }else{
        $( ".btn-primary" ).addClass( "btn-progress disabled " );
          this.submit();
        }
    });
</script>
@endsection