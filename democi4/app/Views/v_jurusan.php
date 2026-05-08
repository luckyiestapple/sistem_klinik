<html>
    <head>
        <title>Data Jurusan</title>
    </head>
</html>
<body>
    <h3><?= $judul ?></h3>
    <ul>
        <?php foreach($jurusan as $jrs) {?>
            <li><?= $jrs['kode_jur'].' '.$jrs['jurusan'] ?></li>
        <?php } ?>
    </ul>
</body>