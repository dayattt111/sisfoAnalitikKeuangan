<?php
namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\View\View;

class DownloadController extends Controller
{
    public function index(): View
    {
        // Ambil semua riwayat unduhan
        $downloads = Download::all();
        // Kirim ke view downloads/index.blade.php
        return view('downloads.index', compact('downloads'));
    }

    public function show(int $id): View
    {
        // Tampilkan detail satu riwayat unduhan
        $download = Download::findOrFail($id);
        return view('downloads.show', compact('download'));
    }
}
