@extends('admin.layouts.master')
@section('title', 'Validasi Putusan')

@section('content')

{{ Breadcrumbs::render('verifikasi_putusan') }}

<h1 class="max-w-lg mt-5 text-primary text-3xl font-semibold font-lato leading-[39px]">
    Validasi Putusan
</h1>

<div class="block max-w-full mt-5 min-h-[59vh] rounded-xl bg-gray-200">
    <div class="p-6">
        {{-- Upload bar (gaya konsisten seperti form kelengkapan) --}}
        <div class="">
            <label class="block text-sm font-medium text-gray-700 mb-1">Berkas Putusan/Sengketa (PDF)</label>
            <div class="flex items-center w-full md:w-4/5 lg:w-3/5 h-[40px]">
                <label for="pdf_sengketa"
                    class="cursor-pointer inline-flex w-max-content items-center px-2 xl:px-4 py-2 text-sm lg:text-base bg-primary text-white rounded-s-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary h-full">
                    <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                    Pilih File
                </label>
                <span
                    class="inline-flex items-center min-w-[50%] h-full px-3 py-1 text-xs lg:text-sm rounded-e-md border border-gray-300 font-semibold text-gray-600">
                    <p id="file_info" class="truncate">tidak ada file yang dipilih</p>
                </span>
            </div>
            <input type="file" id="pdf_sengketa" accept="application/pdf" class="hidden" />
        </div>

        {{-- Action buttons --}}
        <div class="flex items-center gap-3 mt-4">
            <button id="btnExtract" disabled
                    class="bg-primary hover:bg-red-800 disabled:opacity-50 text-white px-5 py-2 rounded-lg shadow">
                Ekstrak Teks
            </button>
            <button id="btnCopy" disabled
                    class="bg-gray-700 hover:opacity-80 text-white px-5 py-2 rounded-lg shadow">
                Copy
            </button>
            <button id="btnReset"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-5 py-2 rounded-lg shadow">
                Clear
            </button>
        </div>

        {{-- Hasil Ekstraksi --}}
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Hasil Ekstraksi</h3>

            <div id="resultWrap" class="space-y-3">
                <div class="bg-gray-100 rounded-xl px-4 py-3 text-gray-800">
                    Unggah PDF lalu klik <b>Ekstrak Teks</b> untuk melakukan validasi.
                </div>

                {{-- kartu status --}}
                <div id="cardStatus" class="hidden bg-gray-100 rounded-xl px-4 py-3 font-mono"></div>

                {{-- grid hasil --}}
                <div id="gridHasil" class="hidden grid md:grid-cols-2 gap-3">
                    <div class="bg-white rounded-xl px-4 py-3 shadow">
                        <div class="text-gray-500 text-xs font-semibold">Nomor Registrasi</div>
                        <div id="outNomor" class="mt-1 font-mono text-sm text-gray-900">-</div>
                    </div>
                    <div class="bg-white rounded-xl px-4 py-3 shadow">
                        <div class="text-gray-500 text-xs font-semibold">Pemohon</div>
                        <div id="outPemohon" class="mt-1 font-mono text-sm text-gray-900">-</div>
                    </div>
                    <div class="bg-white rounded-xl px-4 py-3 shadow md:col-span-2">
                        <div class="text-gray-500 text-xs font-semibold">Termohon (Badan Publik)</div>
                        <div id="outTermohon" class="mt-1 font-mono text-sm text-gray-900">-</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('prepend-script')
<script>
    // Base URL AI Service (pastikan env SERVICES.AI_SERVICE_URL sudah diset)
    const aiServiceUrl = "{{ config('services.ai_service_url') }}";

    function joinUrl(base, path) {
        return base.replace(/\/+$/, '') + '/' + path.replace(/^\/+/, '');
    }

    const $input  = document.getElementById('pdf_sengketa');
    const $info   = document.getElementById('file_info');
    const $btnExt = document.getElementById('btnExtract');
    const $btnCpy = document.getElementById('btnCopy');
    const $btnRst = document.getElementById('btnReset');

    const $status = document.getElementById('cardStatus');
    const $grid   = document.getElementById('gridHasil');
    const $nomor  = document.getElementById('outNomor');
    const $pem    = document.getElementById('outPemohon');
    const $ter    = document.getElementById('outTermohon');

    $input.addEventListener('change', () => {
        const f = $input.files[0];
        $btnExt.disabled = !f;
        $info.textContent = f ? f.name : 'tidak ada file yang dipilih';
    });

    $btnExt.addEventListener('click', async () => {
        const f = $input.files[0];
        if(!f) return;

        const form = new FormData();
        form.append('pdf_file', f);

        const original = $btnExt.textContent;
        $btnExt.textContent = 'Memproses…';
        $btnExt.disabled = true;
        $btnCpy.disabled = true;

        // reset tampilan
        $status.classList.remove('hidden');
        $grid.classList.add('hidden');
        $status.textContent = 'Memproses dokumen…';

        try{
            const url = joinUrl(aiServiceUrl, '/api/extract');
            const res = await fetch(url, { method:'POST', body: form });
            const data = await res.json();

            if (data.error){
                $status.textContent = data.error;
                if (typeof showNotificationError === 'function') showNotificationError(data.error);
                return;
            }

            // Render hasil
            $status.textContent = 'File processed successfully.';
            $nomor.textContent = data.Nomor    || '-';
            $pem.textContent   = data.Pemohon  || '-';
            $ter.textContent   = data.Termohon || '-';

            $grid.classList.remove('hidden');
            $btnCpy.disabled = false;

            if (typeof showNotificationSuccess === 'function')
                showNotificationSuccess('Berhasil mengekstrak dokumen.');
        }catch(e){
            $status.textContent = 'Terjadi kesalahan jaringan atau server.';
            if (typeof showNotificationError === 'function')
                showNotificationError('Gagal memproses dokumen.');
        }finally{
            $btnExt.textContent = original;
            $btnExt.disabled = false;
        }
    });

    $btnCpy.addEventListener('click', async () => {
        const text = [
            `Nomor: ${$nomor.textContent}`,
            `Pemohon: ${$pem.textContent}`,
            `Termohon: ${$ter.textContent}`
        ].join('\n');
        try {
            await navigator.clipboard.writeText(text);
            if (typeof showNotificationSuccess === 'function')
                showNotificationSuccess('Hasil disalin ke clipboard.');
        } catch {
            if (typeof showNotificationError === 'function')
                showNotificationError('Gagal menyalin hasil.');
            alert('Gagal menyalin hasil.');
        }
    });

    $btnRst.addEventListener('click', () => {
        $input.value = '';
        $info.textContent = 'tidak ada file yang dipilih';
        $btnExt.disabled = true;
        $btnCpy.disabled = true;
        $status.classList.add('hidden');
        $grid.classList.add('hidden');
    });
</script>
@endpush
