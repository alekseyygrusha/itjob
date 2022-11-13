<?php
namespace App\Models\Resume;
use Illuminate\Database\Eloquent\Model;


class ResumeLib extends Model 
{
    public function getResumeData($resume_id) {
        $resume = Resume::find($resume_id)->with(['skills', 'city', 'group'])->get()->first();
        return $resume;
    }
}