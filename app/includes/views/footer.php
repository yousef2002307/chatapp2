<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<?php
if (isset($_SESSION['phase1']) && $_SESSION['phase1'] == true) {
?>
    <script src="<?php echo $url ?>/app/layout/js/photo.js"></script>

<?php
} else if (isset($_SESSION['phase2']) && $_SESSION['phase2'] == true) {
?>
    <script src="<?php echo $url ?>/app/layout/js/photo.js"></script>

<?php
} else {


?>
    <script src="<?php echo $url ?>/app/layout/js/jq.js"></script>

    <?php
    if (isset($_SESSION['dashboard']) && $_SESSION['dashboard'] == true) {
    ?>
        <script src="<?php echo $url ?>/app/layout/js/ajax.js"></script>
<?php
    }
}

?>

<script src="<?php echo $url ?>/app/layout/js/jquery.nicescroll.min.js"></script>



<script src='<?php echo $url ?>/app/layout/js/main.js'></script>

</body>

</html>