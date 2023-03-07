<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AgendaResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tanggal_agenda' => date('j F Y', strtotime($this->tanggal_agenda)),
            'nama_agenda' => $this->nama_agenda,
            'waktu_agenda' => $this->waktu_agenda,
            'tempat_agenda' => $this->tempat_agenda,
            'disposisi_agenda' => $this->disposisi_agenda
        ];
    }
}