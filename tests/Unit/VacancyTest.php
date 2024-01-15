<?php

namespace Tests\Unit;

use App\Models\Vacancies;
use PHPUnit\Framework\TestCase;

class VacancyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_vacancy_page()
    {
        $vacancy = Vacancies::factory()->create();

        //проверяем страницу просмотра вакансии

        $response = $this->get("/vacancy/$vacancy->id", $vacancy);

        //проверяем пришли ли данные на страницу
        $response->assertViewHasAll([
            'vacancy', 'resume_list'
        ]);
    }
}
