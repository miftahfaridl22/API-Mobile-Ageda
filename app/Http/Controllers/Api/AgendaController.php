<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use DateTime;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    public function tambahagenda(Request $request)
    {
        $request->validate([
            'nama_agenda' => 'required',
            'waktu_agenda' => 'required',
            'tempat_agenda' => 'required',
            'disposisi_agenda' => 'required'
        ]);

        $tglskr = date("Y-m-d");
        $tglbsk = date("Y-m-d", strtotime($tglskr . "+1 days"));

        $agenda = Agenda::create([
            'tanggal_agenda' => $tglbsk,
            'nama_agenda' => $request->nama_agenda,
            'waktu_agenda' => $request->waktu_agenda,
            'tempat_agenda' => $request->tempat_agenda,
            'disposisi_agenda' => $request->disposisi_agenda
        ]);

        return response()->json([
            'message' => 'Berhasil disimpan!',
            'success' => true,
            'data' => $agenda
        ]);

    }

    public function tampilagenda()
    {
        $dt = new DateTime();
        $ndt = $dt->format('Y-m-d');
        $tampil = DB::table('agendas')->select('*')->where('tanggal_agenda', '=' , $ndt)->orderBy('waktu_agenda')->get();

        return response()->json([
            'success' => true,
            'data' => $tampil,
            'message' => 'success'
        ]);
    }

    public function tampilagendabesok()
    {
        $dateskr = date('Y-m-d');
        $ndt = date('Y-m-d', strtotime($dateskr . "+1 days"));
        $tampil = DB::table('agendas')->select('*')->where('tanggal_agenda', '=' , $ndt)->orderBy('waktu_agenda')->get();

        return response()->json([
            'success' => true,
            'data' => $tampil,
            'message' => 'success'
        ]);
    }

    public function getlistagendatanggal(Request $request)
    {
        $start = $request->tglstart;
        $end = $request->tglend;

        $data_agenda = Agenda::select("*")
                        ->whereBetween('tanggal_agenda', [$start, $end])
                        ->get();
        
        if($data_agenda === []) {
            return response()->json([
                'success' => false,
                'data' => $data_agenda,
                'message' => 'Data kosong'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $data_agenda,
                'message' => 'success'
            ]);
        }
    }
}
