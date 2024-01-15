<?php

namespace Tests\Unit;
use Tests\TestCase;

class RootPageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_page_status()
    {
        $response = $this->get('/');

        //проверяем работает ли страница приложения
        $response->assertStatus(200);
    }

    public function test_root_data()
    {
        $response = $this->get('/');

        //проверяем пришли ли данные на страницу
        $response->assertViewHasAll([
            'cities', 'groups_list', 'vacancies', 'resume_list', 'experiences', 'skills'
        ]);
    }


}
