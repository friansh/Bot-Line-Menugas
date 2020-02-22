<?php
    require_once ('../database.php');

    if (!session_id()) session_start();

    Database::prepare('localhost', 'fikrirpc_friansh', 'a9B8c7D6.hUh?', 'fikrirpc_line_bot');
    Database::connect();

    $db = new Database();

    $commands = $db->query("SELECT id, command FROM response", true);
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
                <a class="nav-item nav-link active" href="../tambah">Tambah</span></a>
            </div>
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="#">Ubah <span class="sr-only">(current)</span></a>
            </div>
        </div>
    </div>
</nav>

<!-- Main Container -->
<div class="container my-4">
    <?php if ( isset($_SESSION['flasher']) ) : ?>
        <div class="row">
            <div class="col-lg-5">
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
        <div class="col-lg-5">
            <h3>Ubah Perintah</h3>
            <ul class="list-group mt-3">
                <?php foreach ( $commands as $command):?>
                    <li class="list-group-item"><?= $command['command'] ?>
                        <a href="#" class="badge badge-danger tombolHapusData float-right" data-toggle="modal" data-target="#konfirmasiHapus" data-command="<?= $command['command'] ?>" data-id="<?= $command['id'] ?>">Hapus</a>
                        <a href="#" class="badge badge-info tombolUbahData float-right mr-1" data-toggle="modal" data-target="#ubahData" data-id="<?= $command['id'] ?>">Ubah</a>

                    </li>
                <?php endforeach; ?>
            </ul>


            <div class="modal fade" id="konfirmasiHapus" tabindex="-1" role="dialog" aria-labelledby="konfirmasiHapusLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi penghapusan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Hapus item '<strong class="nama-item"></strong>'?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button id="konfirmasi-hapus" type="button" class="btn btn-danger" data-id="">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="ubahData" tabindex="-1" role="dialog" aria-labelledby="ubahDataLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ubah Perintah</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="cari_db.php" method="post">
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

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button id="konfirmasi-ubah" type="button" class="btn btn-primary" data-id="">Ubah</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>

    $( ".tombolHapusData" ).click(function() {
        $("#konfirmasi-hapus").data("id", $( this ).data( "id" ) );
        $("#konfirmasi-hapus").data("command", $( this ).data( "command" ) );
        $(".namaPerintah").text($( this ).data( "command" ))
    });

    $( ".tombolUbahData" ).click(function() {
        const id = $(this).data("id");
        $("#konfirmasi-ubah").data("id", id );

        $.ajax({
            url: "./cari_db.php",
            method: "post",
            data: { id : id },
            dataType: "json",
            success: function (result) {
                $("#command").val(result.command);

                if ( result.response_type == 'text' ){
                    $("#text").prop("checked", true);
                }else if ( result.response_type == 'image' ){
                    $("#image").prop("checked", true);
                }else if ( result.response_type == 'imagetext' ){
                    $("#imagetext").prop("checked", true);
                }
                $("#jawabanteks").val(result.response_text);
                $("#linkgambar").val(result.response_imgurl);
            }
        });
    });

    $("#konfirmasi-hapus").click(function(){
        const id = $(this).data("id");
        const command = $(this).data("command");

        $.ajax({
            url: "./hapus_db.php",
            method: "post",
            data: {
                id : id,
                command : command
            },
            dataType: "json",
        });

        window.location.replace("./");
    });


</script>
</body>
</html>

<?php unset( $_SESSION['flasher'] );
