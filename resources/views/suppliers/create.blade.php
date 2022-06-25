@extends('layout.app')
@section('title', 'إضافة مورد جديد')
@section('style')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('body')

      <section class="section">
          <div class="section-header">
            <h1>إضافة مورد جديد</h1>
            
          </div>
          <div class="section-body">
            @if (session('NewSupplier'))
                <div class="alert alert-success">
                    {{ session('NewSupplier') }}
                </div>
            @endif
          
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <form method="post" class="needs-validation" novalidate="" action="/suppliers" enctype="multipart/form-data"  id="myForm" dir="rtl">
                    @csrf
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                      <div class="row">         

                          <div class="form-group col-md-4 col-12">
                            <label  class="float-right"> كـــود المورد </label>
                            <input type="text" class="form-control"  name="code"   value="S{{ $code+1 }}"  required="" readonly>
                            <div class="invalid-feedback">     ادخل  كـــود المورد </div>
                        <strong  class="float-right" style="color: red;">{{ $errors->first('code') }}</strong>

                          </div>
                          
                        <div class="form-group col-md-4 col-12">
                            <label  class="float-right"> إســـــم المورد </label>
                            <input type="text" class="form-control"  name="name"   value="{{ old('name') }}"  required="">
                            <div class="invalid-feedback">     ادخل  إســـــم المورد </div>
                        <strong  class="float-right" style="color: red;">{{ $errors->first('name') }}</strong>
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
                             <div class="form-group col-md-4 col-12">
                            <label  class="float-right">    مجال التعامل  </label>
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