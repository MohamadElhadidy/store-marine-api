@extends('layout.app')
@section('title', 'منظومة المخازن والصيانة ')
@section('style')
@endsection

@section('body')

      <section class="section">
          <div class="section-header">
            <h1>الحساب الشخصي</h1>
            
          </div>
          <div class="section-body">
            @if (session('profile'))
            <script>
              setTimeout(function(){  
                  $( "#profile1" ).load(window.location.href + " #profile1" );
                  $( "#profile2" ).load(window.location.href + " #profile2" ); 
                  $( "#profile3" ).load(window.location.href + " #profile3" ); 
                }, 1000)
            </script>
                <div class="alert alert-success">
                    {{ session('profile') }}
                </div>
            @endif
          
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                  <div class="profile-widget-header" id="profile2">                     
                    <img alt="image" src="{{ asset( $user->image) }}" class="rounded-circle profile-widget-picture image">
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">اسم الدخول</div>
                        <div class="profile-widget-item-value"> {{ $user->username }}</div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">الاسم</div>
                        <div class="profile-widget-item-value"> {{ $user->name }}</div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">المخزن</div>
                        <div class="profile-widget-item-value">{{ $user->stores->name }}</div>
                      </div> 
                    </div>
                  </div>
                </div>
                  @if ( auth()->user()->type == 'admin' AND  $user->type != 'admin')
                <div class="card">
                  <div class="card-header">
                    <h4>الصلاحيات</h4>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped" style="text-align: center" dir="rtl">
                      <thead>
                        <tr>
                          <th scope="col">القسم</th>
                          <th scope="col">الصلاحيات</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($roles as  $role)
                        <tr>
                          <td>{{ $role->section_id }}</td>
                          <td>{{ $role->action }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                      </div>
                </div>
                @endif
              </div>
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                  <form method="post" class="needs-validation" novalidate="" action="/users/{{ $user->id }}" enctype="multipart/form-data"  id="myForm">
                    @csrf
                      <input type="hidden" name="_method" value="put" />
                    <div class="card-header">
                      <h4>تعديل الحساب الشخصي</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">         
                           <div class="form-group col-md-6 col-12">
                         <label  class="float-right">الصورة الشخصية</label>
                      <input type="file" class="form-control"  name="file">
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label  class="float-right">الاسم</label>
                            <input type="text" class="form-control"  name="name"  value="{{ $user->name }}" required="">
                            <div class="invalid-feedback">     ادخل الاسم</div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('name') }}</strong>

                          </div>
                        
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                            <label  class="float-right">اسم الدخول</label>
                            <input type="text" class="form-control"  name="username" value="{{ $user->username }}" required="">
                            <div class="invalid-feedback ">
                              ادخل اسم الدخول
                            </div>
                       <strong  class="float-right" style="color: red;">{{ $errors->first('username') }}</strong>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label  class="float-right">كلمة السر</label>
                            <input type="password" class="form-control"  name="password">
                          </div>
                    </div>

                      @if ( auth()->user()->type == 'admin' AND  $user->type != 'admin')
                          <div class="row">
                              
                            <div class="form-group col-md-6 col-12">
                        <label class="float-right"> الصلاحية</label>
                      <select class="custom-select"  required=""  name="action">
                        <option  disabled>اختر الصلاحية</option>
                          <option value="read" >Read</option>
                          <option value="write" >Write</option>
                          <option value="delete" >Delete</option>
                      </select>
                      <div class="invalid-feedback">     ادخل الصلاحية</div>
                          </div>
                            <div class="form-group col-md-6 col-12">
                        <label class="float-right"> القسم</label>
                      <select class="custom-select"  required=""  name="section">
                        <option  disabled>اختر القسم</option>
                        @foreach ($sections as  $section)
                          <option   value="{{ $section->id }}" >{{ $section->name_ar }}</option>
                        @endforeach
                      </select>
                     <div class="invalid-feedback">     ادخل القسم</div>
                          </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label class="float-right"> المخزن</label>
                      <select class="custom-select"  required=""  name="store">
                        <option  disabled>اختر المخزن</option>
                        @foreach ($stores as  $store)
                          <option @if($store->id  == $user->store) selected @endif  value="{{ $store->id }}" >{{ $store->name }}</option>
                        @endforeach
                      </select>
                       <div class="invalid-feedback">     ادخل المخزن</div>
                          </div>
                    
                    </div>
                      @endif
                    
                     
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