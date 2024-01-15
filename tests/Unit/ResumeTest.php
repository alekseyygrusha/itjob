<?php

namespace Tests\Unit;

use App\Models\Resume\Resume;
use PHPUnit\Framework\TestCase;

class ResumeTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_resume_page()
    {

        $resume = Resume::factory()->create();

        //проверяем создание вакансии

        $this->get('ajax/resume/post', $resume)
            ->seeJson([
                'answer' => true,
            ]);
    }
}
