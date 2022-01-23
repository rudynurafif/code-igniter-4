<?php

namespace App\Controllers;

use App\Models\ComicsModel;

class Comics extends BaseController
{
  protected $comicsModel;

  public function __construct()
  {
    $this->comicsModel = new ComicsModel();
  }

  public function index()
  {
    // $comics = $this->comicsModel->findAll();
    $data = [
      'title' => 'Comic List',
      'comic' => $this->comicsModel->getComic()
    ];
    return view('comics/index', $data);
  }

  public function detail($slug)
  {
    $data = [
      'title' => 'Comic Detail',
      'comic' => $this->comicsModel->getComic($slug)
    ];

    // jika komik tidak ada di tabel
    if(empty($data['comic'])) { // RAWAN ERROR
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . ' tidak ditemukan');
    }

    return view('comics/detail', $data);
  }

  public function create()
  {
    // session();
    $data = [
      'title' => 'Insert Comic Data Form',
      'validation' => \Config\Services::validation()
    ];
    return view('comics/create', $data);
  }

  public function save() // untuk mengelola data yg dikirim dari create untuk diinsert ke dalam table
  {
    // validasi input, baru judul, bisa buat input field yg lain
    if(!$this->validate([
      'judul' => [
        'rules' => 'required|is_unique[comics.judul]',
        'errors' => [
          'required' => '{field} komik harus diisi.',
          'is_unique' => '{field} komik sudah ada'
        ]
      ],
        'sampul' => [
          'rules' => 'max_size[sampul,2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
          'errors' => [
            'max_size' => 'Ukuran file gambar terlalu besar',
            'is_image' => 'File yang dipilih bukan gambar', 
            'mime_in' => 'File yang dipilih bukan gambar', 
          ]
        ]
    ])) {
      // $validation = \Config\Services::validation();
      // return redirect()->to('/comics/create')->withInput()->with('validation', $validation);
      return redirect()->to('/comics/create')->withInput();
    }

    // ambil file gambar
    $fileSampul = $this->request->getFile('sampul');
    // apakah tidak ada gambar diupload
    if($fileSampul->getError() == 4) {
      $namaSampul = 'default.jpg';
    } else {
      // generate nama sampul random
      $namaSampul = $fileSampul->getRandomName();
      // pindahkan file ke folder img
      $fileSampul->move('img', $namaSampul);
    }

    $slug = url_title($this->request->getVar('judul'), '-', true);

    $this->comicsModel->save([
      'judul' => $this->request->getVar('judul'),
      'slug' => $slug,
      'penulis' => $this->request->getVar('penulis'),
      'penerbit' => $this->request->getVar('penerbit'),
      'sampul' => $namaSampul
    ]);

    session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

    return redirect()->to('/comics');
  }

  public function delete($id)
  {
    // cari gambar berdasarkan id
    $comic = $this->comicsModel->find($id);

    // cek jika file gambarnya default
    if($comic['sampul'] != 'default.jpg') {
          // hapus gambar
          unlink('img/' . $comic['sampul']);
    }

    $this->comicsModel->delete($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus.');
    return redirect()->to('/comics');
  }

  public function edit($slug)
  {
    $data = [
      'title' => 'Form Ubah Data Komik',
      'validation' => \Config\Services::validation(),
      'comic' => $this->comicsModel->getComic($slug)
    ];
    return view('comics/edit', $data);
  }

  public function update($id)
  {
    // cek judul
    $comicLama = $this->comicsModel->getComic($this->request->getVar('slug'));
    if($comicLama['judul'] == $this->request->getVar('judul')) {
      $rule_judul = 'required';
    } else {
      $rule_judul = 'required|is_unique[comics.judul]';
    }

    if(!$this->validate([
      'judul' => [
        'rules' => $rule_judul,
        'errors' => [
          'required' => '{field} komik harus diisi.',
          'is_unique' => '{field} komik sudah ada'
        ]
        ],
        'sampul' => [
          'rules' => 'max_size[sampul,2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
          'errors' => [
            'max_size' => 'Ukuran file gambar terlalu besar',
            'is_image' => 'File yang dipilih bukan gambar', 
            'mime_in' => 'File yang dipilih bukan gambar', 
          ]
        ]
    ])) {
      return redirect()->to('/comics/edit/' . $this->request->getVar('slug'))->withInput();
    }

    $fileSampul = $this->request->getFile('sampul');

    // cek gambar, apakah tetap gambar lama
    if($fileSampul->getError() == 4) {
      $namaSampul = $this->request->getVar('sampulLama');
    } else {
      // generate nama file random
      $namaSampul = $fileSampul->getRandomName();
      // pindahkan gambar / upload gambar
      $fileSampul->move('img', $namaSampul);
      // hapus file yang lama
      unlink('img/' . $this->request->getVar('sampulLama'));
    }

    $slug = url_title($this->request->getVar('judul'), '-', true);

    $this->comicsModel->save([
      'id' => $id,
      'judul' => $this->request->getVar('judul'),
      'slug' => $slug,
      'penulis' => $this->request->getVar('penulis'),
      'penerbit' => $this->request->getVar('penerbit'),
      'sampul' => $namaSampul
    ]);

    session()->setFlashdata('pesan', 'Data berhasil diubah.');

    return redirect()->to('/comics');
  }

}