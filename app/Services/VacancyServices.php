<?php
namespace App\Services;
use App\Models\VacancyCandidates;

class VacancyServices
{
    public static function getVacancyCandidates($vacancy_id, $limit = null)
    {
        $vacancy_candidates = new VacancyCandidates();
        $query = $vacancy_candidates->getDefaultQuery();

        $query->where('vc.vacancy_id', $vacancy_id);

        if($limit) {
            $query->limit($limit);
        }
        $candidates = $query->get();
        if($candidates) {
            foreach($candidates as $candidate) {
                $candidate->skills = self::getCandidateSkills($candidate->resume_id)->toArray();
            }
        }

        return $candidates;
    }

    public static function getCandidateSkills($resume_id) {
        $resume_skills = new VacancyCandidates();
        $query = $resume_skills->getCandidateSkillsQuery();

        $query->where('rs.resume_id', $resume_id);

        return $query->get();
    }
}
