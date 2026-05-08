<!DOCTYPE html>
<html>
<body>
    <h2>Form Data Mahasiswa</h2>

    <?= validation_list_errors() ?>
    <?= form_open('/formbiodata')?>
        <label for="fname">Nim:</label><br>
        <input type="text" name="fnim" placeholder="Masukan Nim" required><br>
        <label for="lname">Nama:</label><br>
        <input type="text" name="fnama" placeholder="Masukan Nama" required><br>
        <label for="lname">Alamat:</label><br>
        <input type="text" name="falamat" placeholder="Masukan Alamat"><br><br>
        <input type="submit" value="Kirim">
    <?= form_close()?>
</body>
</html>