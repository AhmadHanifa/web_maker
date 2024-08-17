@extends('layouts.admin')

@section('content')
<div class="col-12 p-3">
    <!-- breadcrumb -->
    <x-bread-crumb :breads="[
        ['url' => url('/admin'), 'title' => 'لوحة التحكم', 'isactive' => false],
        ['url' => route('admin.users.index'), 'title' => 'قاعدة البيانات', 'isactive' => false],
        ['url' => '#', 'title' => 'اضافة [جدول]', 'isactive' => true],
    ]"></x-bread-crumb>
    <!-- /breadcrumb -->

    <div class="col-12 col-lg-12 p-0">
        <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
              action="{{ route('admin.Pages-maker.createPage') }}">
            @csrf

            <div class="col-12 col-lg-8 p-0 main-box">
                <div class="col-12 px-0">
                    <div class="col-12 px-3 py-3">
                        <span class="fas fa-info-circle"></span> إضافة جديد
                    </div>
                    <div class="col-12 divider" style="min-height: 2px;"></div>
                </div>

                <div class="col-12 p-3 row">
                    <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">اسم الجدول</div>
                        <div class="col-12 pt-3">
                            <input type="text" name="table_name" required minlength="3" maxlength="190"
                                   class="form-control" value="{{ old('name_table') }}">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 p-2 row">
                        <label class="col-9" for="num_fields">عدد الحقول:</label>
                        <div class="col-9 pt-3">
                            <input type="number" name="column_count" id="column_count" class="form-control">
                        </div>
                        <div class="col-3 pt-3">
                            <button class="btn btn-success" id="generate-fields">التالي</button>
                        </div>
                    </div>
                </div>
                <div id="fields-container"></div>
                <div class="col-12 p-3">
                    <button type="button" id="add-relation" class="btn btn-primary">إضافة علاقة</button>
                </div>
                <div id="relations-container"></div>
                <div class="col-12 col-lg-6 p-2">
                    <div class="col-12 p-2">حدد نوع الربط مع الواجهات</div>
                    <div class="col-4 pt-3">
                        <select id="route-type" class="form-control" name="type_route[]" multiple>
                            <option value="web">Blade</option>
                            <option value="api">API</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-12 col-lg-6 p-2">
                    <div class="col-12">الفانكشنات المتاحة لـ Blade</div>
                    <div class="col-12 pt-3">
                        <select id="functions-blade" class="form-control select2-select" name="functions_blade[]" multiple>
                            @foreach($functions as $function => $file)
                                <option style="background-color: #e9ecef color: #495057" value="{{$file}}">{{$function}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div id="collapse-api" class="collapse col-12 col-lg-6 p-2">
                    <div class="col-12">الفانكشنات المتاحة لـ API</div>
                    <div class="col-12 pt-3">
                        <select id="functions-api" class="form-control select2-select" name="functions_api[]" multiple>
                            @foreach($functions as $function => $file)
                                <option value="{{$file}}">{{$function}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                

                <div class="col-12 p-3 row">
                    <div class="col-12 p-2">صفحات العرض</div>
                    @foreach ($views as $view )
                    <div class="form-check col-3">
                        <input class="form-check-input" type="checkbox" name="views[]" value="{{$view}}" id="{{ $view }}">
                        <label class="form-check-label" for="{{ $view }}">
                            {{ $view }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="col-12 p-3">
                    <button type="submit" style="display: none;" class="btn btn-success">إنشاء</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const generateButton = document.getElementById('generate-fields');
        const columnsContainer = document.getElementById('fields-container');
        const addRelationButton = document.getElementById('add-relation');
        const relationsContainer = document.getElementById('relations-container');

        const routeTypeSelect = document.getElementById('route-type');
        const collapseApi = document.getElementById('collapse-api');
        const functionsBlade = document.getElementById('functions-blade');
        const functionsApi = document.getElementById('functions-api');

        generateButton.addEventListener('click', (e) => {
            e.preventDefault();
            const numFields = document.getElementById('column_count').value;
            columnsContainer.innerHTML = '';

            for (let i = 0; i < numFields; i++) {
                const columnDiv = document.createElement('div');
                columnDiv.classList.add('col-12', 'p-2', 'row');

                // Label for column name
                const labelDiv = document.createElement('div');
                labelDiv.classList.add('col-6', 'pt-5');
                labelDiv.textContent = `العمود ${i+1}`;
                columnDiv.appendChild(labelDiv);

                // Input for column name
                const inputDiv = document.createElement('div');
                inputDiv.classList.add('col-6', 'pt-3');
                const nameInput = document.createElement('input');
                nameInput.type = 'text';
                nameInput.name = `columns[${i}][name]`;
                nameInput.classList.add('form-control');
                nameInput.value = '{{ old('columns[name]') }}';
                inputDiv.appendChild(nameInput);
                columnDiv.appendChild(inputDiv);

                // Label for column type
                const labelSelect = document.createElement('div');
                labelSelect.classList.add('col-6', 'pt-5');
                labelSelect.textContent = `نوع البيانات`;
                columnDiv.appendChild(labelSelect);

                // Select for column type
                const selectDiv = document.createElement('div');
                selectDiv.classList.add('col-6', 'pt-3');
                const typeSelect = document.createElement('select');
                typeSelect.classList.add('form-control');
                typeSelect.name = `columns[${i}][type]`;

                const stringOption = document.createElement('option');
                stringOption.value = 'string';
                stringOption.textContent = 'نص';
                typeSelect.appendChild(stringOption);

                const floatOption = document.createElement('option');
                floatOption.value = 'float';
                floatOption.textContent = 'عدد ';
                typeSelect.appendChild(floatOption);

                const textOption = document.createElement('option');
                textOption.value = 'text';
                textOption.textContent = 'نص طويل';
                typeSelect.appendChild(textOption);

                const dateOption = document.createElement('option');
                dateOption.value = 'datetime';
                dateOption.textContent = 'التاريخ';
                typeSelect.appendChild(dateOption);

                const enumOption = document.createElement('option');
                enumOption.value = 'enum';
                enumOption.textContent = 'سيلكتور';
                typeSelect.appendChild(enumOption);

                selectDiv.appendChild(typeSelect);
                columnDiv.appendChild(selectDiv);

                // Additional select for "string" type
                const typestringDiv = document.createElement('div');
                typestringDiv.classList.add('col-6', 'pt-3');
                typestringDiv.style.display = 'none';

                const typestringSelect = document.createElement('select');
                typestringSelect.classList.add('form-control');
                typestringSelect.name = `columns[${i}][typestring]`;

                const stringOptionFile = document.createElement('option');
                stringOptionFile.value = 'file';
                stringOptionFile.textContent = 'ملف';
                typestringSelect.appendChild(stringOptionFile);

                const stringOptionText = document.createElement('option');
                stringOptionText.value = 'string';
                stringOptionText.textContent = 'نص';
                typestringSelect.appendChild(stringOptionText);

                typestringDiv.appendChild(typestringSelect);
                columnDiv.appendChild(typestringDiv);

                // Toggle additional select based on selected type
                typeSelect.addEventListener('change', (event) => {
                    if (event.target.value === 'string') {
                        typestringDiv.style.display = 'block';
                    } else {
                        typestringDiv.style.display = 'none';
                    }
                });

                columnsContainer.appendChild(columnDiv);
            }

            document.querySelector('button[type="submit"]').style.display = 'block';
        });

        addRelationButton.addEventListener('click', (event) => {
            event.preventDefault();

            const relationDiv = document.createElement('div');
            relationDiv.classList.add('col-12', 'p-2', 'row');

            // Label for foreign key column
            const labelforeign = document.createElement('div');
            labelforeign.classList.add('col-4');
            labelforeign.textContent = `foreign key column`;
            relationDiv.appendChild(labelforeign);

            // Select for foreign key column
            const selectForeignkey = document.createElement('div');
            selectForeignkey.classList.add('col-4', 'pt-3');
            const selectDiv = document.createElement('select');
            selectDiv.classList.add('form-control', 'select2-select');
            selectDiv.name = `relations[][column_name]`;

            // Assuming `columnData` is available in JS context, replace with actual data
            columnData.forEach(column => {
                const option = document.createElement('option');
                option.value = column.name;
                option.textContent = column.name;
                selectDiv.appendChild(option);
            });

            selectForeignkey.appendChild(selectDiv);
            relationDiv.appendChild(selectForeignkey);

            // Select for relation type
            const selectRelation = document.createElement('div');
            selectRelation.classList.add('col-4', 'pt-3');
            const selectDiv3 = document.createElement('select');
            selectDiv3.classList.add('form-control', 'select2-select');
            selectDiv3.name = `relations[][relation_name]`;

            const onetooneOption = document.createElement('option');
            onetooneOption.value = 'One To One';
            onetooneOption.textContent = 'One To One';
            selectDiv3.appendChild(onetooneOption);

            const onetomanyOption = document.createElement('option');
            onetomanyOption.value = 'One To Many';
            onetomanyOption.textContent = 'One To Many';
            selectDiv3.appendChild(onetomanyOption);

            selectRelation.appendChild(selectDiv3);
            relationDiv.appendChild(selectRelation);

            // Select for referenced table
            const selectTable = document.createElement('div');
            selectTable.classList.add('col-4', 'pt-3');
            const selectDiv2 = document.createElement('select');
            selectDiv2.classList.add('form-control', 'select2-select');
            selectDiv2.name = `relations[][table_name]`;

            // Assuming `migrations` is available in JS context, replace with actual data
            migrations.forEach(migration => {
                const option = document.createElement('option');
                option.value = migration;
                option.textContent = migration;
                selectDiv2.appendChild(option);
            });

            selectTable.appendChild(selectDiv2);
            relationDiv.appendChild(selectTable);

            relationsContainer.appendChild(relationDiv);
        });

        routeTypeSelect.addEventListener('change', (event) => {
        const selectedOptions = Array.from(event.target.selectedOptions).map(option => option.value);

        // إذا تم اختيار Blade و API معاً
        if (selectedOptions.includes('web') && selectedOptions.includes('api')) {
            functionsBlade.closest('.col-12.col-lg-6.p-2').classList.remove('d-none');
            collapseApi.classList.add('show');
        }

        // إذا تم اختيار Blade فقط
        if (selectedOptions.includes('web') && !selectedOptions.includes('api')) {
            functionsBlade.closest('.col-12.col-lg-6.p-2').classList.remove('d-none');
            collapseApi.classList.remove('show');
        }

        // إذا تم اختيار API فقط
        if (selectedOptions.includes('api') && !selectedOptions.includes('web')) {
            functionsBlade.closest('.col-12.col-lg-6.p-2').classList.add('d-none');
            collapseApi.classList.add('show');
        }

        // إذا لم يتم اختيار أي شيء
        if (!selectedOptions.includes('web') && !selectedOptions.includes('api')) {
            functionsBlade.closest('.col-12.col-lg-6.p-2').classList.add('d-none');
            collapseApi.classList.remove('show');
        }
    });
    });
</script>
@endsection
