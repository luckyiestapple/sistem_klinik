<html>
    <head>
        <title>Data Jurusan</title>
    </head>
</html>
<body>
    <h3><?= $judul ?></h3>
    <ul>
        <?php foreach($prodi as $prd) {?>
            <li><?= $prd['kode_prodi'].' '.$prd['prodi'] ?></li>
        <?php } ?>
    </ul>
</body>