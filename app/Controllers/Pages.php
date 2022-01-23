<?php

// controller untuk menangani method atau halaman statis

namespace App\Controllers;

class Pages extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Home | Rudy Nurafif',
      'tes' => ['satu', 'dua', 'tiga']
    ];
    return view('pages/home', $data);
  }

  public function about()
  {
    $data = [
      'title' => 'About Me | Rudy Nurafif'
    ];
    return view('pages/about', $data);
  }

  public function contact()
  {
    $data = [
      'title' => 'Contact Me',
      'alamat' => [
        [
          'tipe' => 'Rumah',
          'alamat' => 'Jalan Margonda No. 10',
          'kota' => 'Depok'
        ],
        [
          'tipe' => 'Kantor',
          'alamat' => 'Jalan Pancoran No. 123',
          'kota' => 'Jakarta'
        ]
      ]
    ];
    return view('pages/contact', $data);
  }

}
