@extends('layout.app')
@section('title', 'إذن صيانة خارجية')
@section('style')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
@endsection

@section('body')

      <section class="section">
          <div class="section-header">
            <h1>إذن صيانة خارجية</h1>
            
          </div>
          <div class="section-body">
            @if (session('NewExternal'))
                <div class="alert alert-success">
                    {{ session('NewExternal') }}
                </div>
            @endif
          
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <form method="post" class="needs-validation" novalidate="" action="/externals" enctype="multipart/form-data"  id="myForm" dir="rtl">
                    @csrf
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                      <div class="row">         
                           
                           
                          <div class="form-group col-md-4 col-12">
                            <label  class="float-right">التاريخ</label>
                          <input type="text" name="dates" class="form-control datepicker">
                            <div class="invalid-feedback">     ادخل  التاريخ  </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('dates') }}</strong>

                          </div>
                             <div class="form-group col-md-4 col-12">
                            <label  class="float-right">    اسم المُعِدة    </label>
                            <select class="form-control select2" name='equipment' required >
                        <option disabled selected>أختر  اسم المُعِدة  </option>
                        @foreach ( $equipments as $equipment)
                            <option value="{{ $equipment->id }}" {{ (old('equipment') == $equipment->id ? "selected":"") }}> {{ $equipment->name }}</option>
                        @endforeach                   
                      </select>       
                       <strong  class="float-right" style="color: red;">{{ $errors->first('equipment') }}</strong>

                          </div>
                         <div class="form-group col-md-4 col-12">
                            <label  class="float-right"> إســـــم الورشة  </label>
                            <input type="text" class="form-control"  name="workshop"   value="{{ old('workshop') }}"  required="">
                            <div class="invalid-feedback">     ادخل  إســـــم الورشة  </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('workshop') }}</strong>
                          </div>
                        
                        </div>
 <div class="row">         
                            <div class="form-group col-md-4 col-12">
                            <label  class="float-right">  الإصلاحات     </label>
                            <input type="text" class="form-control"  name="repairs"   value="{{ old('repairs') }}"  required="">
                            <div class="invalid-feedback">     ادخل     الإصلاحات   </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('repairs') }}</strong>

                          </div>
                            <div class="form-group col-md-4 col-12">
                            <label  class="float-right">   التكلفة    </label>
                            <input type="text" class="form-control"  name="price"   value="{{ old('price') }}"  required="">
                            <div class="invalid-feedback">     ادخل     التكلفة   </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('price') }}</strong>
                          </div>
                     <div class="form-group col-md-4 col-12">
                            <label  class="float-right">    اسم القائم بالعمل     </label>
                            <select class="form-control select2" name='employee' required >
                        <option disabled selected>أختر   اسم القائم بالعمل   </option>
                        @foreach ( $employees as $employee)
                            <option value=" {{ $employee->id }}" {{ (old('employee') == $employee->id ? "selected":"") }}> {{ $employee->name }}</option>
                        @endforeach                   
                      </select>                                  
                            <strong  class="float-right" style="color: red;">{{ $errors->first('employee') }}</strong>
                          </div>
                          
                        
                        </div>
                        <div class="row">         
                          <div class="form-group col-md-4 col-12">
                            <label  class="float-right">    اسم  مسئول الصيانة     </label>
                            <select class="form-control select2" name='supervisor' required >
                        <option disabled selected>أختر   اسم  مسئول الصيانة   </option>
                        @foreach ( $employees as $employee)
                            <option value=" {{ $employee->id }}" {{ (old('supervisor') == $employee->id ? "selected":"") }}> {{ $employee->name }}</option>
                        @endforeach                   
                      </select>                                  
                            <strong  class="float-right" style="color: red;">{{ $errors->first('supervisor') }}</strong>
                          </div>

                      <div class="form-group col-md-4 col-12">
                            <label  class="float-right">    اسم موظف المخزن       </label>
                            <select class="form-control select2" name='entry' required >
                              <option disabled selected>أختر   اسم موظف المخزن   </option>
                              @foreach ( $entries as $entry)
                              <option value=" {{ $entry->id }}"  {{ (old('entry') == $entry->id ? "selected":"") }}> {{ $entry->name }}</option>
                              @endforeach                   
                          </select>                                  
                            <strong  class="float-right" style="color: red;">{{ $errors->first('entry') }}</strong>
                      </div>

                        <div class="form-group col-md-4 col-12">
                            <label  class="float-right">   المخزن      </label>
                            <select class="form-control select2" name='store' required >
                              <option disabled selected>أختر  المخزن  </option>
                              @foreach ( $stores as $store)
                              <option value=" {{ $store->id }}" {{ (old('store') == $store->id ? "selected":"") }}> {{ $store->name }}</option>
                              @endforeach                   
                          </select>                                  
                            <strong  class="float-right" style="color: red;">{{ $errors->first('store') }}</strong>
                      </div>
                        </div>
                        <div class='row'>
                        <div class="form-group col-md-4 col-12">
                            <label  class="float-right">    مُلاحــظـــــات  </label>
                            <input type="text" class="form-control"  name="notes"   value="{{ old('notes') }}" >
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

<script>

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