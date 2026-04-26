<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kelas_siswa; // Model untuk tabel kelas_siswa
use Illuminate\Support\Facades\DB; // WAJIB: Panggil library Database

class SiswaController extends Controller
{
    // 1. TAMPILKAN DAFTAR SISWA (Limit + Filter Kelas + Search)
    public function index(Request $request) {
        // Ambil input dari user (Default 10 jika kosong)
        $datakelas = kelas_siswa::all(); // Ambil data kelas untuk dropdown
        $limit = $request->input('limit', 10);
        $kelas = $request->input('kelas');
        $search = $request->input('search');

        // Mulai Query
        $query = DB::table('attendance_dubes_siswa')->orderBy('id_siswa', 'desc');

        // Filter Kelas
        if ($kelas) {
            $query->where('id_kelas', $kelas);
        }

        // Filter Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Eksekusi (Pakai variable $limit)
        $siswa = $query->paginate($limit)->withQueryString();

        return view('siswa.index', [
            'dataSiswa' => $siswa,
            'kelasSelected' => $kelas,
            'search' => $search,
            'limit' => $limit, // <-- Kirim data limit ke View
            'datakelas' => $datakelas
        ]);
    }

    // 2. FORM TAMBAH (Create)
    public function create() {
        $datakelas = kelas_siswa::all(); // Ambil data kelas untuk dropdown
        return view('siswa.create', compact('datakelas'));
    }

    // MANAGE KELAS - Tampilkan daftar kelas
    public function kelasIndex() {
        $datakelas = kelas_siswa::all();
        return view('siswa.kelas-manage', compact('datakelas'));
    }

    public function storekelas(Request $request)
{
    $validated = $request->validate([
        'nama_kelas' => 'required|unique:kelas_siswa,nama_kelas',
    ]);

    $kelas = kelas_siswa::create($validated);

    return redirect()->back()->with('success', 'Kelas "' . $kelas->nama_kelas . '" baru berhasil ditambahkan!');
}


    // 3. PROSES SIMPAN SISWA (Store)
    public function store(Request $request) {
        // VALIDASI: NIS harus unik di tabel 'attendance_dubes_siswa'
        $request->validate([
            'nis' => 'required|unique:attendance_dubes_siswa,nis', 
            'nama' => 'required',
        ], [
            // Pesan Error Custom (Bahasa Indonesia)
            'nis.unique' => 'Gagal! NIS :input sudah terdaftar di sistem.',
            'nis.required' => 'NIS wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
        ]);

        DB::table('attendance_dubes_siswa')->insert([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'id_kelas' => $request->kelas,
            'gender' => $request->gender,
            'created_at' => now(),
        ]);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan!');
    }

    // 4. FORM EDIT (Edit)
    public function edit($id) {
        $siswa = DB::table('attendance_dubes_siswa')->where('id_siswa', $id)->first();
        $datakelas = DB::table('kelas_siswa')->get(); // Ambil data kelas untuk dropdown
        return view('siswa.edit', ['siswa' => $siswa, 'datakelas' => $datakelas]);
    }

    // 5. PROSES UPDATE (Update)
    public function update(Request $request, $id) {
         $request->validate([
            'nis' => 'required|unique:attendance_dubes_siswa,nis,' .$id. ",id_siswa",
            'nama' => 'required',
        ], [
            // Pesan Error Custom (Bahasa Indonesia)
            'nis.unique' => 'Gagal! NIS :input sudah terdaftar di sistem.',
            'nis.required' => 'NIS wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
        ]);

        DB::table('attendance_dubes_siswa')->where('id_siswa', $id)->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'id_kelas' => $request->kelas,
            'gender' => $request->gender,
            'updated_at' => now(),
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    // 6. PROSES HAPUS (Destroy)
    public function destroy($id) {
        DB::table('attendance_dubes_siswa')->where('id_siswa', $id)->delete();
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }

    public function kelasDestroy($id) {
        DB::table('kelas_siswa')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Kelas berhasil dihapus!');
    }
}