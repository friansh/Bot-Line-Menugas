<?php
    if (!session_id()) session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Bot Line Menugas</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="">Tambah <span class="sr-only">(current)</span></a>
            </div>
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="../ubah">Ubah</a>
            </div>
        </div>
    </div>
</nav>

<!-- main container -->
<div class="container mt-3">
    <?php if ( isset($_SESSION['flasher']) ) : ?>
        <div class="row">
            <div class="col-lg-4">
                <div class="alert alert-<?= $_SESSION['flasher']['type'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['flasher']['text']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-4">
            <h3>Tambah respon</h3>

            <form action="./tambah_db.php" method="post">
                <div class="form-group">
                    <label for="command">Perintah</label>
                    <input type="text" class="form-control" id="command" name="command" placeholder="Bot akan merespon chat ini">
                </div>

                <div class="form-group">
                    <label>Jenis respons:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio" id="text" value="text" checked>
                        <label class="form-check-label" for="text">
                            Teks
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio" id="image" value="image">
                        <label class="form-check-label" for="image">
                            Gambar
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio" id="imagetext" value="imagetext">
                        <label class="form-check-label" for="imagetext">
                            Gambar kemudian teks
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio" id="sticker" value="sticker">
                        <label class="form-check-label" for="sticker">
                            Stiker
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio" id="stickertext" value="stickertext">
                        <label class="form-check-label" for="stickertext">
                            Stiker kemudian teks
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="jawabanteks">Teks</label>
                    <textarea type="text" class="form-control" id="jawabanteks" name="jawabanteks" placeholder="Kosongkan jika hanya memilih gambar" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="linkgambar">Link Gambar</label>
                    <input type="text" class="form-control" id="linkgambar" name="linkgambar" placeholder="Kosongkan jika hanya memilih teks">
                    <small id="linkgambarhelp" class="form-text text-muted">Contoh: <i>http://imgbb.com/12345678.jpg</i></small>
                    <p>Unggah gambar <a href="https://imggmi.com/" rel="noopener noreferrer" target="_blank">di sini</a>.</p>
                </div>


                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

<?php unset( $_SESSION['flasher'] ); ?>
