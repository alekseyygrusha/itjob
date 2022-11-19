<?php
namespace App\Models\Resume;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ResumeLib extends Model 
{
    public function getResumeData($resume_id) {
        $resume = Resume::find($resume_id)->with(['skills', 'city', 'group'])->get()->first();
        return $resume;
    }

    public static function deleteBindResumeSkills($id) {
        $skill_links = DB::table('resume_skills')
            ->where('resume_skills.resume_id', $id)
            ->delete();
    }

    public static function fillResumeSkillLinks($skills, $resume_id) {
        //Переписать на Laravel!
        self::deleteBindResumeSkills($resume_id);
    
        if($skills) {
            foreach ($skills as $skill) {
                
                DB::table('resume_skills')->insert(
                    ['skill_id' => $skill, 'resume_id' => $resume_id],
                );
            }
        }
    }  
        
}