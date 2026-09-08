@extends('admin.layouts.master')
@section('title', 'Role')
@section('content')
    @php
        $permissions = getPermissionsForActiveRole();
    @endphp
    {{ Breadcrumbs::render('role') }}

    <!-- Form Get Access By Role  -->
    <div class="header">
        <div class="max-w-lg mt-5 text-primary text-3xl font-semibold font-lato leading-[39px]">Role</div>
        <div class="mt-6">
            <form action="#" method="GET">
                <div class="flex flex-row space-x-2">
                    <div class="items-center">
                        <div class="lg:w-64 w-full">
                            <select id="pemohon" onchange="getRoleById()"
                                class="bg-gray-50 border border-gray-700 text-gray-900 text-sm rounded-lg focus:ring-themecolor-primary w-full focus:border-red-800 block ">
                                @foreach (getRolesWithoutSuperAdmin() as $item)
                                    <option value="{{ $item->id }}">{{ $item->description }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Form Get Access By Role  -->

    <!-- Form Access Role -->
    <form id="frmAksesRole" class="mt-10">
        <!-- Form By Section -->
        <div id="list_role" class="flex flex-col space-y-2">

        </div>
        <!-- End Form By Section -->

        <!-- Button Save -->
        @if (in_array(Permissions::FITUR_ROLE_UPDATE, $permissions))
            <div class="flex justify-end mb-5">
                <div class="relative w-1/2 md:w-1/5 lg:w-1/6">
                    <button type="submit" id="btn_submit"
                        class="absolute w-full text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                        Simpan
                    </button>
                    <button id="btn_loading" hidden
                        class="absolute w-full text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                        <div role="status">
                            <svg aria-hidden="true"
                                class="inline w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>
                </div>
            </div>
        @endif

        <!-- End Button Save -->
    </form>
    <!-- End Form Akses Role -->


@endsection
{{-- stack js --}}
@push('prepend-script')
    <script>
        $(document).ready(function() {
            getRoleById();

            $('#btn_submit').click(function(e) {
                e.preventDefault();
                const checkedValues = [];
                var roleId = $('#pemohon').val();
                var url = "{{ route('role.update', ':roleId') }}";
                url = url.replace(':roleId', roleId);

                $('input[type="checkbox"]:checked').each(function() {
                    checkedValues.push($(this).val())
                })

                showButtonProgress();

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: JSON.stringify({
                        "permissions": checkedValues
                    }),
                    url: url,
                    contentType: 'application/json',
                    success: function(response) {
                        hideButtonProgress();
                        showNotificationSuccess(response.message)
                    },
                    error: function(response) {
                        var errors = response.responseJSON;
                        var errorMessage = errors.message + '<br>';
                        $.each(errors.errors, function(key,
                            value) {
                            errorMessage += value + '<br>'
                        })
                        hideButtonProgress();
                        showNotificationError(errorMessage)
                    }
                });
            });
        });

        function checkAll(key, event) {
            event.preventDefault();
            var access = $('#allowAccess' + key).is(':checked');

            if (access) {
                $('.check' + key).prop('checked', 'checked');
            }
        }

        function allowAccess(key) {
            var access = $('#allowAccess' + key).is(':checked');

            if (access) {
                $('.check' + key).attr('disabled', false);
                $('.check' + key).removeClass('bg-gray-400');
                $('.check' + key).addClass('bg-white');
            } else {
                $('.check' + key).prop('checked', false);
                $('.check' + key).removeClass('bg-white');
                $('.check' + key).addClass('bg-gray-400');
                $('.check' + key).attr('disabled', true);
            }
        }

        function getRoleById() {
            var roleId = $('#pemohon').val();
            var url = "{{ route('role.show', ':roleId') }}";
            url = url.replace(':roleId', roleId);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(response) {
                    insertListRole(response.data);
                },
                error: function(response) {
                    var errors = response.responseJSON;
                    var errorMessage = errors.message + '<br>';
                    $.each(errors.errors, function(key,
                        value) {
                        errorMessage += value + '<br>'
                    })
                    showNotificationError(errorMessage)
                }
            });
        }


        function insertListRole(data) {
            const htmlElements = [];
            $('#list_role').html("");
            for (const item of data) {
                var checked = item.has_access ? "checked" : "";
                var disabled = item.has_access ? "" : "disabled";
                var bgChecklist = item.has_access ? "bg-white" : "bg-gray-400";

                var htmlString = '<div class="relative overflow-x-auto sm:rounded-lg mb-2 mx-auto lg:max-w-full w-full">' +
                    '<div class="flex flex-row justify-between bg-themecolor-primary px-6 py-4">' +
                    '<div><p class="inline-flex items-center text-xl font-light text-white dark:text-gray-400 dark:hover:text-white">' +
                    item.description + '</p></div>' +
                    // '<div>' +
                    // '<button type="button" aria-controls="section' + item.id + '" data-collapse-toggle="section' +
                    // item.id +
                    // '">' +
                    // '<svg xmlns="http://www.w3.org/2000/svg"' +
                    // 'class="flex-shrink-0 w-5 h-5 text-white transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white"' +
                    // 'fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">' +
                    // '<path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />' +
                    // '</svg>' +
                    // '</button>' +
                    // '</div>' +
                    '</div>' +
                    '<div id="section' + item.id + '" class="bg-slate-200">' +
                    '<div class="flex flex-row space-x-1 px-6 py-4 ">' +
                    '<div>' +
                    '<label class="inline-flex items-center mb-5 cursor-pointer">' +
                    '<input id="allowAccess' + item.id + '" type="checkbox" onchange="allowAccess(' + item.id + ')"' +
                    ' value="' + item.id + '" ' + checked + ' class="sr-only peer">' +
                    '<div ' +
                    'class="relative w-11 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primaryTransparent dark:peer-focus:ring-themecolor-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-themecolor-primary">' +
                    '</div>' +
                    '<span class="ms-3 text-sm font-medium text-themecolor-primary dark:text-gray-300">Allow Access |</span>' +
                    '</label>' +
                    '</div>' +
                    '<div>' +
                    '<button onclick="checkAll(' +
                    item.id + ',event)"' +
                    'class="text-blue-600 hover:text-blue-800 text-sm font-medium">Select All' +
                    '</button>' +
                    '</div>' +
                    '</div>';

                //start detail
                htmlString += '<div class="grid gap-4 grid-cols-3 px-6">';

                for (const detail of item.children) {
                    var checkedDetail = detail.has_access ? "checked" : "";
                    //start perulangan
                    htmlString += '<div class="col-span-2 sm:col-span-1 flex items-center mb-4">' +
                        '<input id="default-checkbox' + detail.id + '" type="checkbox" ' + checkedDetail + ' value="' +
                        detail.id + '" ' +
                        disabled +
                        ' class="check' + item.id +
                        ' w-4 h-4 text-themecolor-primary ' + bgChecklist +
                        ' border-gray-300 rounded focus:ring-primaryTransparent dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">' +
                        '<label for="default-checkbox' + detail.id + '"' +
                        'class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">' + detail.description +
                        '</label>' +
                        '</div>';
                    //end perulangan
                }
                htmlString += '</div>';
                //end detail

                htmlString += '</div>' +
                    '</div><br>';


                htmlElements.push(htmlString);
            }

            // Join HTML elements into a single string
            const joinedHTML = htmlElements.join('');
            // console.log(joinedHTML)
            $('#list_role').append(joinedHTML);
        }

        function showButtonProgress() {
            $('#btn_loading').removeAttr('hidden');
            $('#btn_submit').attr('hidden', true);
        }

        function hideButtonProgress() {
            $('#btn_submit').removeAttr('hidden');
            $('#btn_loading').attr('hidden', true);
        }
    </script>
@endpush


{{-- '<div class="relative overflow-x-auto sm:rounded-lg mb-2 mx-auto lg:max-w-full w-full">' +
    '<div class="flex flex-row justify-between bg-themecolor-primary px-6 py-4">' +
        '<div><p class="inline-flex items-center text-xl font-light text-white dark:text-gray-400 dark:hover:text-white">Sengketa</p></div>'+
        '<div>'+
            '<button type="button" aria-controls="sectionSengketa" data-collapse-toggle="sectionSengketa">'+
                '<svg xmlns="http://www.w3.org/2000/svg"'+
                    'class="flex-shrink-0 w-5 h-5 text-white transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white"'+
                    'fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">'+
                    '<path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />'+
                '</svg>'+
            '</button>'+
        '</div>'+
    '</div>'+
    '<div id="sectionSengketa" class="bg-slate-200">'+
        '<div class="flex flex-row space-x-1 px-6 py-4 ">'+
            '<div>'+
                '<label class="inline-flex items-center mb-5 cursor-pointer">'+
                    '<input id="allowAccessSengketa" type="checkbox" onchange="allowAccess('=Sengketa')"'+
                        'value="" class="sr-only peer">'+
                    '<div'+
                        'class="relative w-11 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primaryTransparent dark:peer-focus:ring-themecolor-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-themecolor-primary">'+
                    '</div>'+
                    '<span class="ms-3 text-sm font-medium text-themecolor-primary dark:text-gray-300">Allow Access |</span>'+
                '</label>'+
            '</div>'+
            '<div>'+
                '<button onclick="checkAll('Sengketa',event)"'+
                    'class="text-blue-600 hover:text-blue-800 text-sm font-medium">Select All'+
                '</button>'+
            '</div>'+
        '</div>'+
        '<div class="grid gap-4 grid-cols-3 px-6">'+
            '<div class="col-span-2 sm:col-span-1 flex items-center mb-4">'+
                '<input id="default-checkbox" type="checkbox" value="" disabled'+
                    'class="checkSengketa w-4 h-4 text-themecolor-primary bg-gray-400 border-gray-300 rounded focus:ring-primaryTransparent dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">'+
                '<label for="default-checkbox"'+
                    'class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tambah Sengketa'+
                '</label>'+
            '</div>'+
        '</div>'+
    '</div>'+
'</div>'; --}}
