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
                            $('#ile').show("fast");
                            $('#add').show("fast");
                        }
                    })
                }
                else {
                    $('#produkt').html('<option value="">Wybierz kategorie</option>');
                    $('#produkt').hide("fast");
                    $('#ile').hide("fast");
                    $('#add').hide("fast");
                }
            });

            var form = $("#form1");
            var i = 1;
            $("#add").click(function() {
                var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field\"/>");
                var kategoria = $('#kategoria').val();
                var produkt = $('#produkt').val();
                var ile = $('#ile').val();
                if (ile === "") {ile = 1;}
                //var fkategoria = $("<input type=\"text\" name=\"nazwa\" value=\""+kategoria+"\" readonly />");
                var fprodukt = $("<input type=\"text\" name=\"nazwa_"+i+"\" value=\""+produkt+"\" readonly />");
                var filosc = $("<input type=\"text\" name=\"ilosc_"+i+"\" value=\""+ile+"\" readonly />");
                var removeButton = $("<input type=\"button\" class=\"remove\" value=\"usuń\" />");
                removeButton.click(function() {
                    $(this).parent().remove();
                });
                //fieldWrapper.append(fkategoria);
                fieldWrapper.append(fprodukt);
                fieldWrapper.append(filosc);
                fieldWrapper.append(removeButton);
                form.append(fieldWrapper);
                $('#ile').val('1');
                i++;
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

<input type="number" id="ile" name="ilosc" value="1" style="display:none;" />

<input type="button" value="+" id="add" style="display:none;" />


<div>
<form id="form_1" action="test4n.php" method="post">
<div id='form1'>
</div>
<input type="submit" name="wyslij" value="wyslij" />
</form>
</div>



</body>
</html>
