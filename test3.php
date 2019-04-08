<?php
require_once('assets/conf.php');
require_once('assets/classes/kategoria.class.php');
require_once('assets/classes/produkt.class.php');


$k = new Kategoria($conn);

$kategorie = $k->zwroc_wszystkie();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#kategoria').on('change',function(){
                var nazwaKategori = $(this).val();
                if (nazwaKategori){
                    $.ajax({
                        type:'POST',
                        url:'test3ajax.php',
                        data:'nazwaKategori='+nazwaKategori,
                        success:function(html){
                            $('#produkt').html(html);
                            $('#produkt').show("fast");
                        }
                    })
                }
                else {
                    $('#produkt').html('<option value="">Wybierz kategorie</option>');
                    $('#produkt').hide("fast");
                }
            });
        });


    </script>
</head>
<body>
    
<select id="kategoria">
    <option value="">Wybierz kategorie</option>
    <?php
            foreach($kategorie as $kategoria){
                echo '<option value="'.$kategoria->nazwa.'">'.$kategoria->nazwa.'</option>';
            }
            

    ?>
</select>

<select id="produkt" style="display:none;">
    <option value="">Najpier wybierz kategorie</option>
</select>


</body>
</html>
