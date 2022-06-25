@extends('layout.app')
@section('title', 'إنشاء حساب جديد')
@section('style')
@endsection

@section('body')

      <section class="section">
          <div class="section-header">
            <h1>إنشاء حساب جديد</h1>
            
          </div>
          <div class="section-body">
            @if (session('newAccount'))
                <div class="alert alert-success">
                    {{ session('newAccount') }}
                </div>
            @endif
          
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <form method="post" class="needs-validation" novalidate="" action="/users" enctype="multipart/form-data"  id="myForm">
                    @csrf
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row">         
                           <div class="form-group col-md-6 col-12">
                         <label  class="float-right">الصورة الشخصية</label>
                      <input type="file" class="form-control"  name="file">
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label  class="float-right">الاسم</label>
                            <input type="text" class="form-control"  name="name"   value="{{ old('name') }}"  required="">
                            <div class="invalid-feedback">     ادخل الاسم</div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('name') }}</strong>

                          </div>
                        
                        </div>
                        <div class="row">
                         
                          <div class="form-group col-md-6 col-12">
                            <label  class="float-right">كلمة السر</label>
                            <input type="password" class="form-control"  name="password" required="">
                                <div class="invalid-feedback ">
                              ادخل  كلمة السر
                            </div>
                                                   <strong  class="float-right" style="color: red;">{{ $errors->first('password') }}</strong>

                          </div>
                             <div class="form-group col-md-6 col-12">
                            <label  class="float-right">اسم الدخول</label>
                            <input type="text" class="form-control"  value="{{ old('username') }}"  name="username"  required="">
                            <div class="invalid-feedback ">
                              ادخل اسم الدخول
                            </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('username') }}</strong>
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
<script>

  $('#myForm').on('submit', function(e){
        e.preventDefault();
        $( ".btn-primary" ).addClass( "btn-progress disabled " );
        this.submit();
        
    });
</script>
@endsection