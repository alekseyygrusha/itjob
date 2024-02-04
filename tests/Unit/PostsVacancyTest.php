<?php

namespace Tests\Unit;
use App\Models\User;
use App\Models\Vacancies;
use Tests\TestCase;

class PostsVacancyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_page_status_without_auth()
    {
        $response = $this->get('/cabinet/vacancy/');

        //проверяем работает ли страница приложения без авторизации
        $response->assertStatus(302);
    }

    public function test_page_status_auth()
    {
        //проверяем работает ли страница приложения c авторизацией
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/cabinet/vacancy/');

        $response->assertStatus(200);
    }

    public function test_page_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/cabinet/vacancy/');

        //проверяем пришли ли данные на страницу
        $response->assertViewHasAll([
            'skills', 'groups',  'experiences'
        ]);
    }

    public function post_vacancy_form()
    {
        $user = User::factory()->create();
        $vacancy = Vacancies::factory()->create();

        //проверяем создание вакансии c авторизацией

        $this->$this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('post-vacancy', $vacancy)
            ->seeJson([
                'answer' => true,
            ]);
    }
}


