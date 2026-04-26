<x-app-layout>
    @include('components.sidebar')

    <!-- === create siswa === -->
    <div class="ml-64 p-10 min-h-screen bg-gray-50">
        <div class="mb-8 border-b border-gray-200 pb-4">
            <h2 class="text-3xl font-black text-gray-900">Tambah Siswa Baru</h2>
        </div>

        @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <strong class="font-bold">Gagal Menyimpan!</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-gren-700 px-4 py-3 rounded relative">
            <strong class="font-bold">Berhasil Disimpan</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                {{ session('success') }}
            </ul>
        </div>
        @endif

        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm w-full">
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm text-gray-700">NIS</label>
                    <input type="text" name="nis" required placeholder="Contoh: 12345"
                        class="w-full border-gray-300 rounded-lg p-3 focus:ring-black focus:border-black transition">
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama" required placeholder="Contoh: Ahmad Budi"
                        class="w-full border-gray-300 rounded-lg p-3 focus:ring-black focus:border-black transition">
                </div>

                <div class="flex gap-6 mb-8">
                    <div class="w-1/2">
                        <label class="block font-bold mb-2 text-sm text-gray-700">Kelas</label>
                        <select name="kelas"
                            class="w-full border-gray-300 rounded-lg p-3 focus:ring-black focus:border-black cursor-pointer">
                            @foreach ($datakelas as $dk)
                            <option value="{{ $dk }}">{{ $dk->nama_kelas }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="mt-2 bg-gray-200 px-4 py-2 rounded hover:bg-gray-300"
                            data-bs-toggle="modal" data-bs-target="#kelasModal" id="formkelas">
                            Tambah Kelas baru
                        </button>
                        <button type="button" class="mt-2 bg-gray-200 px-4 py-2 rounded hover:bg-gray-300"
                            data-bs-toggle="modalManage" data-bs-target="#kelasModalManage" id="formkelasManage">
                            Manage Kelas
                        </button>
                    </div>
                    <div class="w-1/2">
                        <label class="block font-bold mb-2 text-sm text-gray-700">Gender</label>
                        <select name="gender"
                            class="w-full border-gray-300 rounded-lg p-3 focus:ring-black focus:border-black cursor-pointer">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                        class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition shadow-lg">
                        Simpan Data
                    </button>
                    <a href="{{ route('siswa.index') }}"
                        class="bg-gray-100 text-gray-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal add kelas -->
    <div id="kelasModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Tambah Kelas Baru</h2>
            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf
                <input type="text" name="nama_kelas" placeholder="Contoh: XII RPL 2"
                    class="w-full border-gray-300 rounded-lg p-3 mb-4 focus:ring-black focus:border-black transition"
                    required>
                <div class="flex justify-end gap-2">
                    <button type="button" id="cancelModal" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Manage -->
    <div id="kelasModalManage" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center p-4 justify-center">
        <div class="bg-white overflow-auto h-[100%] rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Manage Kelas</h2>
            @foreach ($datakelas as $dkt)
            <!-- dkt -> data kelas table -->
            <table class="w-full mb-4">
                <tr class="border-b border-gray-200 flex justify-between items-center">
                    <td class="py-2">{{ $dkt->nama_kelas}}</td>
                    <td class="py-2">
                        <form action="{{ route('kelas.destroy', $dkt->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
            </table>
            @endforeach
              <button type="button" id="cancelModalManage" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
        </div>
    </div>

    @section('scripts')
    <script>
    const modal = document.getElementById('kelasModal');
    const modalManage = document.getElementById('kelasModalManage');
    const btnOpen = document.getElementById('formkelas');
    const btnOpenManage = document.getElementById('formkelasManage');
    const btnCancel = document.getElementById('cancelModal');
    const btnCancelManage = document.getElementById('cancelModalManage');

    btnOpen.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    btnCancel.addEventListener('click', () => {
        modal.classList.add('hidden');
    });
    btnOpenManage.addEventListener('click', () => {
        modalManage.classList.remove('hidden');
    });

    btnCancelManage.addEventListener('click', () => {
        modalManage.classList.add('hidden');
    });
    </script>
    @endsection


</x-app-layout>