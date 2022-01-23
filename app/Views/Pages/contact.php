<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
  <div class="row">
    <div class="col">
      <!-- <h1>Contact Me</h1> -->

      <button type="button" class="btn btn-secondary btn-lg"><a href="https://rudynurafif.github.io/#contact" target="_blank" class="text-decoration-none text-light">Contact here</a></button>
      <!--
        <?php foreach($alamat as $a) : ?>
          <ul>
            <li><?= $a['tipe']; ?></li>
            <li><?= $a['alamat']; ?></li>
            <li><?= $a['kota']; ?></li>
          </ul>
        <?php endforeach; ?>
      -->

    </div>
  </div>
</div>

<?= $this->endSection(); ?>