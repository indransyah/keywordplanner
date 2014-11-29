<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

class SubCriteriaTableSeeder extends Seeder {

	public function run()
	{
		DB::table('subcriteria')->delete();

		// Subkriteria Spesifikasi
		Subcriterion::create(array(
			'subcriterion'     => 'Umum',
			'description' => 'Tingkat spesifikasi keyword umum (jumlah kata pada keyword berjumlah = 1)',
			'range'    => '1',
			'criterion_id'    => '1',
		));

		Subcriterion::create(array(
			'subcriterion'     => 'Normal',
			'description' => 'Tingkat spesifikasi keyword normal (jumlah kata pada keyword berjumlah = 2)',
			'range'    => '2',
			'criterion_id'    => '1',
		));

		Subcriterion::create(array(
			'subcriterion'     => 'Spesifik',
			'description' => 'Tingkat spesifikasi keyword spesifik (jumlah kata pada keyword berjumlah = 3)',
			'range'    => '3',
			'criterion_id'    => '1',
		));

		Subcriterion::create(array(
			'subcriterion'     => 'Sangat Spesifik',
			'description' => 'Tingkat spesifikasi keyword sangat spesifik(jumlah kata pada keyword berjumlah > 3)',
			'range'    => '>3',
			'criterion_id'    => '1',
		));

		// Subkriteria Pencarian
		Subcriterion::create(array(
			'subcriterion'     => 'Sangat Sedikit',
			'description' => 'Jumlah rata-rata pencarian keyword tiap bulan < 500',
			'range'    => '<500',
			'criterion_id'    => '2',
		));

		Subcriterion::create(array(
			'subcriterion'     => 'Sedikit',
			'description' => 'Jumlah rata-rata pencarian keyword tiap bulan 500 - 1000',
			'range'    => '500-1000',
			'criterion_id'    => '2',
		));

		Subcriterion::create(array(
			'subcriterion'     => 'Normal',
			'description' => 'Jumlah rata-rata pencarian keyword tiap bulan 1001 - 2000',
			'range'    => '1001-2000',
			'criterion_id'    => '2',
		));

		Subcriterion::create(array(
			'subcriterion'     => 'Banyak',
			'description' => 'Jumlah rata-rata pencarian keyword tiap bulan 2001 - 5000',
			'range'    => '2001-5000',
			'criterion_id'    => '2',
		));

		Subcriterion::create(array(
			'subcriterion'     => 'Sangat Banyak',
			'description' => 'Jumlah rata-rata pencarian keyword tiap bulan > 5000',
			'range'    => '>5000',
			'criterion_id'    => '2',
		));

		// Subkriteria Persaingan
		Subcriterion::create(array(
			'subcriterion'     => 'Rendah',
			'description' => 'Tingkat persaingan antar advertiser rendah',
			'range'    => '<0.33',
			'criterion_id'    => '3',
		));

		Subcriterion::create(array(
			'subcriterion'     => 'Sedang',
			'description' => 'Tingkat persaingan antar advertiser sedang',
			'range'    => '0.33-0.66',
			'criterion_id'    => '3',
		));

		Subcriterion::create(array(
			'subcriterion'     => 'Tinggi',
			'description' => 'Tingkat persaingan antar advertiser tinggi',
			'range'    => '>0.66',
			'criterion_id'    => '3',
		));

		// Subkriteria Harga
		Subcriterion::create(array(
			'subcriterion'     => 'Murah',
			'description' => 'Harga yang disarankan Google AdWords murah (< $0.2)',
			'range'    => '<0.2',
			'criterion_id'    => '4',
		));

		Subcriterion::create(array(
			'subcriterion'     => 'Sedang',
			'description' => 'Harga yang disarankan Google AdWords sedang ($0.2 - $0.5)',
			'range'    => '0.2-0.5',
			'criterion_id'    => '4',
		));

		Subcriterion::create(array(
			'subcriterion'     => 'Mahal',
			'description' => 'Harga yang disarankan Google AdWords mahal ($0.6 - $1)',
			'range'    => '0.6-1',
			'criterion_id'    => '4',
		));

		Subcriterion::create(array(
			'subcriterion'     => 'Sangat Mahal',
			'description' => 'Harga yang disarankan Google AdWords sangat mahal (> $1)',
			'range'    => '>1',
			'criterion_id'    => '4',
		));


	}

}
