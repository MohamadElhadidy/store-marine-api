@extends('layout.app')
@section('title', 'تعديل صنف ')
@section('style')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('body')

      <section class="section">
          <div class="section-header">
            <h1>تعديل صنف </h1>
            
          </div>
          <div class="section-body">
            @if (session('EditItem'))
                <div class="alert alert-success">
                    {{ session('EditItem') }}
                </div>
            @endif
          
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <form method="post" class="needs-validation" novalidate="" action="/items/{{ $item->id }}" enctype="multipart/form-data"  id="myForm" dir="rtl">
                    @csrf
                    <input type="hidden" name="_method" value="put" />

                    <div class="card-header">
                    </div>
                    <div class="card-body">
                      <div class="row">         
                           
                           
                          <div class="form-group col-md-4 col-12">
                            <label  class="float-right"> كـــود الصنف </label>
                            <input type="text" class="form-control"  name="code"   value="{{ $item->code }}"  required="">
                            <div class="invalid-feedback">     ادخل  كـــود الصنف </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('code') }}</strong>

                          </div>
                          
                         <div class="form-group col-md-4 col-12">
                            <label  class="float-right"> إســـــم الصنف </label>
                            <input type="text" class="form-control"  name="name"   value="{{ $item->name }}"  required="">
                            <div class="invalid-feedback">     ادخل  إســـــم الصنف </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('name') }}</strong>
                          </div>
                           <div class="form-group col-md-4 col-12">
                            <label  class="float-right">  الرصيد الحالي   </label>
                            <input type="text" class="form-control"  name="balance" @if ($new != 0) readonly @endif  value="{{ $item->balance }}"  required="">
                            <div class="invalid-feedback">     ادخل    الرصيد الحالي  </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('balance') }}</strong>

                          </div>
                        </div>
 <div class="row">         
                            <div class="form-group col-md-4 col-12">
                            <label  class="float-right">   الوحدة   </label>
                            <select class="form-control select2" name='unit' required >
                        <option disabled selected>أختر الوحدة </option>
                        @foreach ( $units as $unit)
                            <option value=" {{ $unit->id }}" {{ ($item->unit == $unit->id ? "selected":"") }}> {{ $unit->name }}</option>
                        @endforeach                   
                      </select>       
                       <strong  class="float-right" style="color: red;">{{ $errors->first('unit') }}</strong>
                            <div class="invalid-feedback">     ادخل    الوحدة   </div>

                          </div>
                            <div class="form-group col-md-4 col-12">
                            <label  class="float-right">   سعر الوحدة  </label>
                            <input type="text" class="form-control"  name="price" @if ($new != 0) readonly @endif  value="{{ $item->price }}"  required="">
                            <div class="invalid-feedback">     ادخل    سعر الوحدة  </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('price') }}</strong>
                          </div>
                      <div class="form-group col-md-4 col-12">
                            <label  class="float-right">  حد الطلب   </label>
                            <input type="text" class="form-control"  name="end"   value="{{ $item->end }}"  required="">
                            <div class="invalid-feedback">     ادخل   حد الطلب   </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('end') }}</strong>

                          </div>
                          
                        
                        </div>
                        <div class="row">         
                          <div class="form-group col-md-4 col-12">
                            <label  class="float-right">   نوع الصنف     </label>
                            <select class="form-control select2" name='type' required >
                        <option disabled selected>أختر  نوع الصنف </option>
                        @foreach ( $types as $type)
                            <option value=" {{ $type->id }}" {{ ($item->type == $type->id ? "selected":"") }}> {{ $type->name }}</option>
                        @endforeach                   
                      </select>                                  
                            <strong  class="float-right" style="color: red;">{{ $errors->first('type') }}</strong>
                                                        <div class="invalid-feedback">     ادخل    نوع الصنف   </div>

                          </div>

                      <div class="form-group col-md-4 col-12">
                            <label  class="float-right">   المخزن      </label>
                            <select class="form-control select2" name='store' required >
                              <option disabled selected>أختر  المخزن  </option>
                              @foreach ( $stores as $store)
                              <option value=" {{ $store->id }}" {{ ($item->store == $store->id ? "selected":"") }}> {{ $store->name }}</option>
                              @endforeach                   
                          </select>                                  
                            <strong  class="float-right" style="color: red;">{{ $errors->first('store') }}</strong>
                                                        <div class="invalid-feedback">     ادخل    المخزن   </div>

                      </div>

                          <div class="form-group col-md-4 col-12">
                            <label  class="float-right">    مُلاحــظـــــات  </label>
                            <input type="text" class="form-control"  name="notes"   value="{{ $item->notes }}" >
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
