<?php

// Composer: "fzaninotto/faker": "v1.4.0"
// use Faker\Factory as Faker;

class CriteriaTableSeeder extends Seeder {

	public function run()
	{
		DB::table('criteria')->delete();
		Criterion::create(array(
			'criterion'     => 'Specification',
			'description' => 'Tingkat spesifikasi sebuah kata kunci yang dilihat dari jumlah kata pada keyword (umum, normal, spesifik, sangat spesifik).',
			'field'    => 'word'
		));

		Criterion::create(array(
			'criterion'     => 'Search',
			'description' => 'Jumlah pencarian rata-rata tiap bulan pada sebuah keyword',
			'field'    => 'search'
		));

		Criterion::create(array(
			'criterion'     => 'Competition',
			'description' => 'Tingkat persaingan antar advertiser',
			'field'    => 'competition'
		));

		Criterion::create(array(
			'criterion'     => 'BID',
			'description' => 'Harga keyword yang disarankan oleh Google AdWords',
			'field'    => 'bid'
		));
	}

}
