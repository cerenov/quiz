<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quizzes')->insert([
            'id' => 1,
            'title' => 'Программирование',
        ]);
        {
            // вопрос 1
            DB::table('questions')->insert([
                'id' => '1',
                'text' => 'С какого символа начинаются все переменные в php?',
                'quiz_id' => 1
            ]);
            {
                // варианты ответов к вопросу 1
                DB::table('choices')->insert([
                    'id' => '1',
                    'text' => '<>',
                    'question_id' => 1,
                    'is_сorrect' => false
                ]);

                DB::table('choices')->insert([
                    'id' => '2',
                    'text' => '$',
                    'question_id' => 1,
                    'is_сorrect' => true
                ]);

                DB::table('choices')->insert([
                    'id' => '3',
                    'text' => '!',
                    'question_id' => 1,
                    'is_сorrect' => false
                ]);

                DB::table('choices')->insert([
                    'id' => '4',
                    'text' => '_',
                    'question_id' => 1,
                    'is_сorrect' => false
                ]);
            }
        }

        {
            // вопрос 2
            DB::table('questions')->insert([
                'id' => '2',
                'text' => 'Как инвертировать массив в php',
                'quiz_id' => 1
            ]);
            {
                // варианты ответов к вопросу 2
                DB::table('choices')->insert([
                    'id' => '5',
                    'text' => '$m = array_reverse($m)',
                    'question_id' => 2,
                    'is_сorrect' => true
                ]);

                DB::table('choices')->insert([
                    'id' => '6',
                    'text' => '$m = reverse_array($m)',
                    'question_id' => 2,
                    'is_сorrect' => false
                ]);

                DB::table('choices')->insert([
                    'id' => '7',
                    'text' => '$q = array_key_exists("zima", $ar)',
                    'question_id' => 2,
                    'is_сorrect' => false
                ]);

                DB::table('choices')->insert([
                    'id' => '8',
                    'text' => 'array_splice($m, 2, 0)',
                    'question_id' => 2,
                    'is_сorrect' => false
                ]);
            }
        }

        {
            // вопрос 3
            DB::table('questions')->insert([
                'id' => '3',
                'text' => 'Какими тегами обрамляется php код в стандартной конфигурации',
                'quiz_id' => 1
            ]);
            {
                // варианты ответов к вопросу 3
                DB::table('choices')->insert([
                    'id' => '9',
                    'text' => '<? php ... ?>',
                    'question_id' => 3,
                    'is_сorrect' => true
                ]);

                DB::table('choices')->insert([
                    'id' => '10',
                    'text' => '<% ... %>',
                    'question_id' => 3,
                    'is_сorrect' => false
                ]);

                DB::table('choices')->insert([
                    'id' => '11',
                    'text' => '<script type=\"php\"> ... </script>',
                    'question_id' => 3,
                    'is_сorrect' => false
                ]);

                DB::table('choices')->insert([
                    'id' => '12',
                    'text' => '<? ... ?>',
                    'question_id' => 3,
                    'is_сorrect' => false
                ]);
            }
        }

        {
            // вопрос 4
            DB::table('questions')->insert([
                'id' => 4,
                'text' => 'Как правильно писать комментарии в php?',
                'quiz_id' => 1
            ]);
            {
                // варианты ответов к вопросу 4
                DB::table('choices')->insert([
                    'id' => '13',
                    'text' => '/? php ... ?/',
                    'question_id' => 4,
                    'is_сorrect' => false
                ]);

                DB::table('choices')->insert([
                    'id' => '14',
                    'text' => '% ... %',
                    'question_id' => 4,
                    'is_сorrect' => false
                ]);

                DB::table('choices')->insert([
                    'id' => '15',
                    'text' => '/*...*/',
                    'question_id' => 4,
                    'is_сorrect' => true
                ]);

                DB::table('choices')->insert([
                    'id' => '16',
                    'text' => '//...',
                    'question_id' => 4,
                    'is_сorrect' => true
                ]);
            }
        }
    }
}
