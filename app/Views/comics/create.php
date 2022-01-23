<?= $this->extend("layout/template") ?>

<?= $this->section("content") ?>

<div class="container">
  <div class="row">
    <div class="col-md-8">
      <h2 class="my-3">Form Tambah Data Komik</h2>
      <form action="/comics/save" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row mb-3">
          <label for="judul" class="col-sm-2 col-form-label">Judul</label>
          <div class="col-sm-10">
            <input type="text" class="form-control <?= $validation->hasError("judul") ? "is-invalid" : ""; ?>" name="judul" id="judul" autofocus value="<?= old("judul") ?>">
            <div id="validationServer03Feedback" class="invalid-feedback">
              <?= $validation->getError("judul") ?>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="penulis" id="penulis" value="<?= old("penulis") ?>">
          </div>
        </div>
        <div class="row mb-3">
          <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="penerbit" id="penerbit" value="<?= old("penerbit") ?>">
          </div>
        </div>
        <div class="row mb-3">
          <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
          <div class="col-sm-2">
            <img src="/img/default.jpg" class="img-thumbnail img-preview">
          </div>
          <div class="col-sm-8">
            <div class="input-group mb-3">
              <input type="file" class="form-control <?= $validation->hasError("sampul") ? "is-invalid" : ""; ?>" name="sampul" id="sampul" onchange="previewImg()">
              <!-- <label class="input-group-text" for="sampul">Upload</label> -->
              <div id="validationServer03Feedback" class="invalid-feedback">
                <?= $validation->getError("sampul"); ?>
              </div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Data</button>
      </form>

    </div>
  </div>
</div>


<?= $this->endSection() ?>
