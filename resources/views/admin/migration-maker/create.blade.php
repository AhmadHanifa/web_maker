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
                <div name="columns" id="fields-container"></div>
                <div class="col-12 p-3">
                    <button type="button" id="add-relation" class="btn btn-primary">إضافة علاقة</button>
                </div>
                <div id="relations-container"></div>
                <div class="col-12 col-lg-6 p-2">
                    <div class="col-12 p-2">
                        حدد نوع الربط مع الواجهات
                    </div>
                    <div class="col-4 pt-3">
                        <select class="form-control select1-select" name="type_route" >

                                <option value="web">blade</option>
                                <option value="api">api</option>

                        </select>
                    </div>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <div class="col-12">
                        الفانكشنات المتاحة
                    </div>
                    <div class="col-12 pt-3">
                        <select class="form-control select2-select" name="functions[]" multiple >
                            @foreach($functions as $function => $file)
                                <option style="background-color: #e9ecef color: #495057" value="{{$file}}">{{$function}}</option>
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

        generateButton.addEventListener('click', (e) => {
            e.preventDefault();
            const numFields = document.getElementById('column_count').value;
            columnsContainer.innerHTML = '';

            const columnDiv = document.createElement('div');
            columnDiv.classList.add('col-12', 'p-2', 'row');

            for (let i = 0; i < numFields; i++) {
                const labelDiv = document.createElement('div');
                labelDiv.classList.add('col-6', 'pt-5');
                labelDiv.textContent = `العمود ${i+1}`;
                columnDiv.appendChild(labelDiv);

                const labelSelect = document.createElement('div');
                labelSelect.classList.add('col-3', 'pt-5');
                labelSelect.textContent = `نوع البيانات`;
                columnDiv.appendChild(labelSelect);

                const inputDiv = document.createElement('div');
                inputDiv.classList.add('col-6', 'pt-3');

                const nameInput = document.createElement('input');
                nameInput.type = 'text';
                nameInput.name = `columns[${i}][name]`;
                nameInput.classList.add('form-control');
                nameInput.value = '{{ old('columns[name]') }}';
                inputDiv.appendChild(nameInput);

                columnDiv.appendChild(inputDiv);

                const selectDiv = document.createElement('div');
                selectDiv.classList.add('col-6', 'pt-3');

                const typeSelect = document.createElement('select');
                typeSelect.classList.add('form-control', 'select2-select');
                typeSelect.name = `columns[${i}][type]`;

                const stringOption = document.createElement('option');
                stringOption.value = 'string';
                stringOption.textContent = 'نص';
                typeSelect.appendChild(stringOption);

                const integerOption = document.createElement('option');
                integerOption.value = 'integer';
                integerOption.textContent = 'عدد صحيح';
                typeSelect.appendChild(integerOption);

                const textOption = document.createElement('option');
                textOption.value = 'text';
                textOption.textContent = 'نص طويل';
                typeSelect.appendChild(textOption);

                selectDiv.appendChild(typeSelect);
                columnDiv.appendChild(selectDiv);
            }

            columnsContainer.appendChild(columnDiv);

            document.querySelector('button[type="submit"]').style.display = 'block';
        });

        addRelationButton.addEventListener('click', (event) => {
            const numFields = document.getElementById('column_count').value;

            const inputs = document.querySelectorAll('input[name^="column"]');
            columnData = [];

            inputs.forEach(input => {
                columnData.push({
                    name: input.value
                });
            });

            var migrations = @json($migrations_name);

            relationsContainer.innerHTML = '';

            const relationDiv = document.createElement('div');
            relationDiv.classList.add('col-12', 'p-2', 'row');

            const labelforeign = document.createElement('div');
            labelforeign.classList.add('col-4');
            labelforeign.textContent = `foreign key column`;
            relationDiv.appendChild(labelforeign);

            const labelrelation = document.createElement('div');
            labelrelation.classList.add('col-4');
            labelrelation.textContent = `type relation`;
            relationDiv.appendChild(labelrelation);

            const labeltable = document.createElement('div');
            labeltable.classList.add('col-4');
            labeltable.textContent = `table refrence`;
            relationDiv.appendChild(labeltable);

            const selectForeignkey = document.createElement('div');
            selectForeignkey.classList.add('col-4', 'pt-3');
            const selectDiv = document.createElement('select');
            selectDiv.classList.add('form-control', 'select2-select');
            selectDiv.name = `relations[][column_name]`;

            columnData.forEach(column => {
                const Option = document.createElement('option');
                Option.value = column.name;
                Option.textContent = column.name;
                selectDiv.appendChild(Option);
            });

            selectForeignkey.appendChild(selectDiv);
            relationDiv.appendChild(selectForeignkey);

            const selectTable = document.createElement('div');
            selectTable.classList.add('col-4', 'pt-3');
            const selectDiv2 = document.createElement('select');
            selectDiv2.classList.add('form-control', 'select2-select');
            selectDiv2.name = `relations[][table_name]`;

            migrations.forEach(migration => {
                const stringOption = document.createElement('option');
                stringOption.value = migration;
                stringOption.textContent = migration;
                selectDiv2.appendChild(stringOption);
            });

            selectTable.appendChild(selectDiv2);
            relationDiv.appendChild(selectTable);

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

            relationsContainer.appendChild(relationDiv);
        });
    });
</script>
@endsection
