@extends('front-end.main')
@section('content')
    <div class="container">
        <section class="breadcramp">
            <div class="container">
                <ul class="d-flex">
                    <li>
                        <a href="#">الرئسية</a>
                    </li>
                    <span>></span>
                    &nbsp;
                    <li>التمويل العقاري</li>
                </ul>
            </div>
            @if (session('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
        </section>
        <section class="estate-finance">
            <div class="container">
                <form method="post" action="{{ route('front.mortgage.store') }}" onsubmit="return validateForm()">

                    <div class="row">
                        @csrf
                        <div class="col-md-6">
                            <div class="first">
                                <label>الإسم بالكامل</label>
                                <input type="text" id="fullname" name="name" placeholder="اكتب الإسم بالكامل هنا"
                                    minlength="3" maxlength="255" class="form-control" required>
                                <span id="fullNameError" class="error-message"></span>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="first">
                                <label>العمر</label>
                                <select id="theAge" name="age" class="js-states" style="width: 100% !important;"
                                    required>
                                    @foreach (__('mortgage.age') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <span id="ageError" class="error-message"></span>
                                @error('age')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('age') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="first">
                                <label>الجنس</label>
                                <select id="theGender" name="gender" class="js-states" style="width: 100% !important;"
                                    required>
                                    <option></option>
                                    <option value="male">ذكر</option>
                                    <option value="female">أنثى</option>

                                </select>
                                <span id="genderError" class="error-message"></span>
                                @error('gender')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('gender') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="first">

                                <label>نوع القطاع</label>
                                <select id="theSector" class="js-states" name="group" style="width: 100% !important;"
                                    required>
                                    <option></option>
                                    @foreach (__('mortgage.group') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach

                                </select>
                                <span id="sectorError" class="error-message"></span>
                                @error('group')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('group') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="first">
                                <label>رقم الهويه</label>
                                <input type="text" id="idNumber" name="nationality"
                                    placeholder="الرجاء كتابة رقم الهوية" class="form-control" required>
                                <span id="idError" class="error-message"></span>
                                @error('nationality')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nationality') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="first">
                                <label>البنك المحول عليه الراتب</label>
                                <select id="theBank" class="js-states" name="bank" style="width: 100% !important;"
                                    required>
                                    <option></option>
                                    @foreach (__('mortgage.bank') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach

                                </select>
                                <span id="bankError" class="error-message"></span>
                                @error('bank')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('bank') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="first">
                                <label>رقم الجوال</label>
                                <input type="text" id="phone" placeholder="الرجاء كتابة رقم الجوال" name="phone"
                                    class="form-control" required>
                                <span id="phoneError" class="error-message"></span>
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('phone') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="first">
                                <label>الراتب الشهري</label>
                                <select id="theSalary" class="js-states" name="salary" style="width: 100% !important;">
                                    <option></option>
                                    @foreach (__('mortgage.salary') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach

                                </select>
                                <span id="salaryError" class="error-message"></span>
                                @error('salary')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('salary') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="first">
                                <label>البريد الإلكتروني</label>
                                <input type="email" id="email" name="email"
                                    placeholder="الرجاء كتابة البردي الإلكتروني" class="form-control">
                                <span id="emailError" class="error-message"></span>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="first">
                                <label>المنطقة</label>
                                <select id="theArea" class="js-states" style="width: 100% !important;" name="area">
                                    <option></option>
                                    @foreach (__('mortgage.area') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <span id="areaError" class="error-message"></span>
                                @error('area')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('area') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="link-style-small">
                            <span>تقديم طلب</span>
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script>
        function validateForm() {
            var fullName = document.getElementById("fullname").value;
            var fullNameError = document.getElementById("fullNameError");
            var age = document.getElementById("theAge").value;
            var ageError = document.getElementById("ageError");
            var nationality = document.getElementById("idNumber").value;
            var gender = document.getElementById("theGender").value;
            var genderError = document.getElementById("genderError");
            var sector = document.getElementById("theSector").value;
            var sectorError = document.getElementById("sectorError");
            var idNum = document.getElementById("idNumber").value;
            var idError = document.getElementById("idError");
            var bank = document.getElementById("theBank").value;
            var bankError = document.getElementById("bankError");
            var phone = document.getElementById("phone").value;
            var phoneError = document.getElementById("phoneError");
            var salary = document.getElementById("theSalary").value;
            var salaryError = document.getElementById("salaryError");
            var email = document.getElementById("email").value;
            var emailError = document.getElementById("emailError");
            var area = document.getElementById("theArea").value;
            var areaError = document.getElementById("areaError");

            fullNameError.style.display = "none";
            ageError.style.display = "none";
            genderError.style.display = "none";
            sectorError.style.display = 'none';
            idError.style.display = "none";
            bankError.style.display = "none";
            phoneError.style.display = "none";
            salaryError.style.display = "none";
            emailError.style.display = "none";
            if (fullName === "") {
                fullNameError.textContent = "الرجاء إدخال الاسم بالكامل";
                fullNameError.style.display = "block";
                return false;
            }
            if (age === "") {
                ageError.textContent = "الرجاء تحديد العمر";
                ageError.style.display = "block";
                return false;
            }
            if (gender === "") {
                genderError.textContent = "الرجاء تحديد النوع";
                genderError.style.display = "block";
                return false;
            }
            if (sector === "") {
                sectorError.textContent = "الرجاء تحديد نوع القطاع";
                sectorError.style.display = "block";
                return false;
            }
            if (idNum === "") {
                idError.textContent = "الرجاء تحديد رقم الهويه";
                idError.style.display = "block";
                return false;
            }
            if (bank === "") {
                bankError.textContent = "الرجاء اختيار البنك";
                bankError.style.display = "block";
                return false;
            }
            if (phone === "") {
                phoneError.textContent = "الرجاء كتابة رقم الجوال";
                phoneError.style.display = "block";
                return false;
            }

            if (salary === "") {
                salaryError.textContent = "الرجاء اختيار الراتب الشهرى";
                salaryError.style.display = "block";
                return false;
            }
            if (email === "") {
                emailError.textContent = "الرجاء كتابة البريد الالكترونى";
                emailError.style.display = "block";
                return false;
            }
            if (!email.includes("@")) {
                emailError.textContent = "يجب أن يحتوي البريد الإلكتروني على علامة @";
                emailError.style.display = "block";
                return false;
            }
            if (area === "") {
                areaError.textContent = "الرجاء اختيار المنطقه";
                areaError.style.display = "block";
                return false;
            }
            return true
        }
    </script>
    <script src="{{ asset('front-end/js/jquery.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#theAge").select2({
            placeholder: "الرجاء اختيار العمر",
        });
        $("#theGender").select2({
            placeholder: "الرجاء اختيار الجنس",
        });
        $("#theSector").select2({
            placeholder: "الرجاء اختيار نوع القطاع",
        });
        $("#theBank").select2({
            placeholder: "الرجاء اختيار البنك",
        });
        $("#theSalary").select2({
            placeholder: "الرجاء اختيار الراتب الشهري",
        });
        $("#theArea").select2({
            placeholder: "الرجاء اختيار المنطقة",
        });
    </script>
@endsection

@push('custom-style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endpush
