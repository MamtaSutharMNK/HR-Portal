@extends('layouts.mainlayout')
@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
           <div class="col-md-7">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card shadow">
                <div class="card-header bg-primary button-blue-50 text-white">
                    <h1 class="h4 mb-0 text-center">Create Support Ticket</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('support_tickets.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <!-- Department -->
                        <div class="mb-3">
                            <label for="department_id" class="form-label-custom text-black font-medium">Department</label>
                            <select name="department_id" id="department_id" required class="form-select form-control form-control-custom text-black border-gray-300 rounded">
                                <option value="" selected disabled>Please Select Department</option>
                                @foreach(config('dropdown.department_list') as $key => $department)
                                    <option value="{{ $key }}" @selected(old('department_id') == $key)>{{ $department }}</option>
                                @endforeach
                            </select>
                            <div id="department_email_display" class="mt-2 text-muted font-italic"></div>
                            @error('department_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Issue Category -->
                        <div class="mb-3">
                            <label for="issue_category_id" class="form-label-custom text-black font-medium">Issue Category</label>
                            <select name="issue_category_id" id="issue_category_id" required class="form-select form-control text-black border-gray-300 rounded">
                                <option value="" selected disabled>Select Issue Category</option>
                            </select>
                            @error('issue_category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Issue Type -->
                        <div class="mb-3">
                            <label for="issue_type" class="form-label-custom text-black font-medium">Issue Type</label>
                            <select name="issue_type" id="issue_type" required class="form-select form-control text-black border-gray-300 rounded">
                                <option value="" selected disabled>Select Issue Type</option>
                            </select>
                            @error('issue_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label-custom text-black font-medium">Detailed Description</label>
                            <textarea name="description" id="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                        </div>

                        <!-- Attachments -->
                        <div class="mb-3">
                            <label for="attachments" class="form-label-custom text-black font-medium exclude">Attachments</label>
                            <input type="file" class="filepond form-control" name="attachments[]" multiple>
                        </div>

                        <input type="hidden" name="newCategoryName" id="hiddenCategoryName">
                        <input type="hidden" name="newTypeName" id="hiddenTypeName">

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-50">Submit</button>
                        </div>

                        <!-- Go Back -->
                        <div class="container-fluid">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('support_tickets.index')}}" class="btn btn-secondary btn-sm">
                                    ← Go Back
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Custom Category -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
            </div>
            <div class="modal-body">
                <input type="text" id="newCategoryName" class="form-control" placeholder="Enter new category name">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveCategoryBtn">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Custom Type -->
<div class="modal fade" id="typeModal" tabindex="-1" aria-hidden="true" style="z-index:9999;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Add Issue Type</h5>
            </div>
            <div class="modal-body">
                <input type="text" id="newTypeName" class="form-control" placeholder="Enter new issue type">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveTypeBtn">Save</button>
            </div>
        </div>
    </div>
</div>

@php
    $departmentEmails = [
        '1' => env('ADMIN_SUPPORT_EMAIL'),
        '2' => env('HR_SUPPORT_EMAIL'),
        '3' => env('IT_SUPPORT_EMAIL'),
    ];
@endphp

@endsection



@push('custome_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
        })
        .catch(error => {
            console.error('CKEditor Error:', error);
        });

    const isAdmin = @json(Auth::user()->isAdmin());
</script>
<script>
  
    document.addEventListener('DOMContentLoaded', function () {
        const deptSelect = document.getElementById('department_id');
        const categorySelect = document.getElementById('issue_category_id');
        const typeSelect = document.getElementById('issue_type');

        function resetDropdown(select, placeholder) {
            select.innerHTML = `<option value="">${placeholder}</option>`;
        }

        deptSelect.addEventListener('change', function () {
            const deptId = this.value;
            resetDropdown(categorySelect, 'Select Issue Category');
            resetDropdown(typeSelect, 'Select Issue Type');

            if (!deptId) return;

            fetch(`/support/categories/${deptId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(cat => {
                        categorySelect.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
                    });
                    categorySelect.innerHTML += `<option value="other">Other</option>`;
                });
        });

        categorySelect.addEventListener('change', function () {
            const categoryId = this.value;
            resetDropdown(typeSelect, 'Select Issue Type');

            if (categoryId === 'other') {
                const categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'));
                categoryModal.show();
                return;
            }

            fetch(`/support/types/${categoryId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(type => {
                        typeSelect.innerHTML += `<option value="${type.id}">${type.name}</option>`;
                    });
                    typeSelect.innerHTML += `<option value="other">Other</option>`;
                });
        });

        typeSelect.addEventListener('change', function () {
            if (this.value === 'other') {
                const typeModal = new bootstrap.Modal(document.getElementById('typeModal'));
                typeModal.show();
                return;
            }
        });

        document.getElementById('saveCategoryBtn').addEventListener('click', function () {
            const name = document.getElementById('newCategoryName').value;
            const deptId = deptSelect.value;
            document.getElementById('hiddenCategoryName').value = name;
            const categoryModalInstance = bootstrap.Modal.getInstance(document.getElementById('categoryModal'));
            if (categoryModalInstance) categoryModalInstance.hide();

            if (!name || !deptId) return alert('Please enter category name.');
            const isAdmin = @json(Auth::user()->isAdmin());
            console.log(isAdmin);

            if (isAdmin) {
                fetch('/support/categories/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name, department_id: deptId })
                })
                .then(res => res.json())
                .then(data => {
                      Swal.fire({
                            icon: 'success',
                            title: 'Category Added',
                            text: `New category "${data.name}" created successfully!`,
                            timer: 2000,
                            showConfirmButton: false
                        });

                    categorySelect.innerHTML += `<option value="${data.id}" selected>${data.name}</option>`;

                    resetDropdown(typeSelect, 'Select Issue Type');
                    fetch(`/support/types/${data.id}`)
                        .then(res => res.json())
                        .then(types => {
                            types.forEach(type => {
                                typeSelect.innerHTML += `<option value="${type.id}">${type.name}</option>`;
                            });
                            typeSelect.innerHTML += `<option value="other" selected>Other</option>`;

                            const typeModal = new bootstrap.Modal(document.getElementById('typeModal'));
                            typeModal.show();
                        });
                });
            } else {
                const tempId = 'temp-cat-' + Date.now();
                categorySelect.innerHTML += `<option value="${tempId}" selected>${name}</option>`;

                resetDropdown(typeSelect, 'Select Issue Type');
                typeSelect.innerHTML += `<option value="other" selected>Other</option>`;


                const typeModal = new bootstrap.Modal(document.getElementById('typeModal'));
                typeModal.show();
            }

            document.getElementById('newCategoryName').value = '';
        });

        document.getElementById('saveTypeBtn').addEventListener('click', function () {
            const name = document.getElementById('newTypeName').value;
            const categoryId = categorySelect.value;
            document.getElementById('hiddenTypeName').value = name;
            const typeModalInstance = bootstrap.Modal.getInstance(document.getElementById('typeModal'));
            if (typeModalInstance) typeModalInstance.hide();

            if (!name || !categoryId) return alert('Please enter issue type name.');
            const isAdmin = @json(Auth::user()->isAdmin());

            if (isAdmin) {
                fetch('/support/types/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name, issue_category_id: categoryId })
                })
                .then(res => res.json())
                .then(data => {
                     Swal.fire({
                            icon: 'success',
                            title: 'CategoryType Added',
                            text: `New categoryType "${data.name}" created successfully!`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    typeSelect.innerHTML += `<option value="${data.id}" selected>${data.name}</option>`;
                });
            } else {
                const tempId = 'temp-type-' + Date.now();
                typeSelect.innerHTML += `<option value="${tempId}" selected>${name}</option>`;
            }

            document.getElementById('newTypeName').value = '';
        });
    });


          
    const departmentEmails = @json($departmentEmails);

        function showDepartmentEmail() {
            const selectedDept = document.getElementById('department_id').value;
            console.log(selectedDept);
            const outputDiv = document.getElementById('department_email_display');
            const email = departmentEmails[selectedDept];

            outputDiv.textContent = email ? `Support Email: ${email}` : '';
        }

        document.getElementById('department_id').addEventListener('change', showDepartmentEmail);

</script>

@endpush


