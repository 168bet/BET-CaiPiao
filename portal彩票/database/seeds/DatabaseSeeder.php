<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('lotteries')->insert([
    			'slug' => 'ssq',
    			'name' => '双色球',
    			'price' => 2,
    	]);
    	DB::table('lotteries')->insert([
    			'slug' => 'dlt',
    			'name' => '大乐透',
    			'price' => 2,
    	]);
    	DB::table('lotteries')->insert([
    			'slug' => '3d',
    			'name' => '福彩3D',
    			'price' => 2,
    	]);
    	DB::table('lotteries')->insert([
    			'slug' => 'cqssc',
    			'name' => '重庆时时彩',
    			'price' => 2,
    	]);
    	DB::table('lotteries')->insert([
    			'slug' => 'jx115',
    			'name' => '江西11选5',
    			'price' => 2,
    	]);
		DB::table('lotteries')->insert([
			'slug' => 'dc',
			'name' => '北京单场',
			'price' => 2,
		]);
        DB::table('lotteries')->insert([
            'slug' => 'zq',
            'name' => '竞彩足球',
            'price' => 2,
        ]);
        DB::table('lotteries')->insert([
            'slug' => 'lq',
            'name' => '竞彩篮球',
            'price' => 2,
        ]);
    }
}
