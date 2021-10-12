<?php

namespace App\Models\Rows;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Models\DB;

class Insert extends DB
{
    use HasFactory;

    public function insert(array $data):void {
        $id = $this->inBackup($data);
        $this->inColumns($id, $data);
    }

    private function inBackup(array $data):int {
        $filepath = Storage::path('public/' . $this->name . '/' . $this->name . '.json');
        $id = $this->getLastId($filepath) + 1;
        $json = json_encode([
            'id' => $id,
            'data' => $data
        ]);
        Storage::append('public/' . $this->name . '/' . $this->name . '.json', $json);
        return $id;
    }

    private function inColumns(int $id, array $data):void {
        foreach ($data as $column => $value) {
            $this->inColumn($id, $column, $value);
        }
    }

    private function inColumn(int $id, string $column, mixed $value):void {
        $json = json_encode([
            'id' => $id,
            $column => $value
        ]);
        Storage::append('public/' . $this->name . '/' . $column . '.json', $json);
    }


}
