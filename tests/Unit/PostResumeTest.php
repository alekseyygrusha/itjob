<?php

namespace Tests\Unit;

use App\Models\Resume\Resume;
use App\Models\User;

use PHPUnit\Framework\TestCase;

class PostResumeTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_page_status_without_auth()
    {
        $response = $this->get('/cabinet/resume/');

        //проверяем работает ли страница приложения без авторизации
        $response->assertStatus(302);
    }

    public function test_page_status_auth()
    {
        //проверяем работает ли страница приложения c авторизацией
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/cabinet/resume/');

        $response->assertStatus(200);
    }

    public function test_page_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/cabinet/resume/');

        //проверяем пришли ли данные на страницу
        $response->assertViewHasAll([
            'skills', 'groups',  'experiences', 'cities'
        ]);
    }

    public function post_vacancy_form()
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->create();

        //проверяем создание вакансии

        $this->$this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('ajax/resume/post', $resume)
            ->seeJson([
                'answer' => true,
            ]);
    }
}
