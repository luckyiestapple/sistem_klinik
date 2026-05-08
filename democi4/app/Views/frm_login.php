<!DOCTYPE html>
<html>
<body>
    <h2>Form Login Mahasiswa</h2>

    <?= validation_list_errors() ?>
    
    <?= form_open('/formlogin')?>
        <label for="fname">Username:</label><br>
        <input type="text" name="fusn" placeholder="Masukan Username" required><br>
        <label for="lname">Password:</label><br>
        <input type="password" name="fpw" placeholder="Masukan Password" required><br>
        <label for="lname">Ulangi Password:</label><br>
        <input type="password" name="fupw" placeholder="Masukan Ulangi Password"><br><br>
        <input type="submit" value="Login">
    <?= form_close()?>
</body>
</html>