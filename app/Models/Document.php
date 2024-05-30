<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_url',
    ];

    public function uploadFile($file, $documentId)
    {
        if ($file) {
            $path = $file->store('documents/'.$documentId, 's3');
            return env('AWS_S3_BASE_URL', 'https://s3-datn.s3.ap-southeast-2.amazonaws.com/') . $path;
        } else {
            return $this->link_url;
        }
    }
}
