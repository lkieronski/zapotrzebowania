$(document).ready(function(){
// ---------------------------- start -----------------------------------------------
// -----------------------dodawanie produktu show / hide ----------------------------
        $('#dodaj_produkt_b').on('click',function(){
            if ($('#dodaj_produkt').css("display") == "none"){
                $('#dodaj_produkt').show("slow");
                $('#dodaj_produkt_b').html("Kliknij żeby schować.")
            }
            else{
                $('#dodaj_produkt').hide("slow");
                $('#dodaj_produkt_b').html("Kliknij żeby dodać nowy produkt.")
            }
            
        });
// --------------------------- dodawanie produktu -----------------------------------

        $('#pd_submit').on('click',function(){
            var pd_k = $('#pd_k').val();
            var pd_p = $('#pd_p').val();
            if (pd_k && pd_p){
                $.ajax({
                    type:'POST',
                    url:'dodajprodukt.php',
                    data:{'pd_k':pd_k, 'pd_p':pd_p},
                    success:function(html){           
                        $('#dodaj_produkt_ajax').html(html);
                        $('#dodaj_produkt_ajax').show('fast');
                    }
                })
            }
        });
// ----------------- dodawanie zapotrzebowania show / hide --------------------------

        $('#dodaj_zapotrzebowanie_b').on('click',function(){
            if ($('#dodaj_zapotrzebowanie').css("display") == "none"){
                $('#dodaj_zapotrzebowanie').show("slow");
                $('#dodaj_zapotrzebowanie_b').html("Kliknij żeby schować.")
            }
            else{
                $('#dodaj_zapotrzebowanie').hide("slow");
                $('#dodaj_zapotrzebowanie_b').html("Kliknij żeby dodać zapotrzebowanie.")
            }    
        });


// -------------- dodawanie zapotrzebowania ------------------------------------------

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
            $('#wew_zapotrzebowanie').show("fast");
            var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field\"/>");
            var kategoria = $('#kategoria').val();
            var produkt = $('#produkt').val();
            var ile = $('#ile').val();
            if (ile === "") {ile = 1;}
            var fprodukt = $("<input type=\"text\" name=\"nazwa_"+i+"\" value=\""+produkt+"\" readonly />");
            var filosc = $("<input type=\"text\" name=\"ilosc_"+i+"\" value=\""+ile+"\" readonly />");
            var removeButton = $("<input type=\"button\" id=\"usun_zapotrzebowanie\" class=\"remove\" value=\"usuń\" />");
            removeButton.click(function() {
                $(this).parent().remove();
            });
            fieldWrapper.append(fprodukt);
            fieldWrapper.append(filosc);
            fieldWrapper.append(removeButton);
            form.append(fieldWrapper);
            $('#ile').val('1');
            i++;
            

        }); 
//------------------------------------------- zabezpieczenie przed wyslaniem pustego zapotrzebowania --------------------------------------------------
        $("#form_1").submit(function(){
            if ($("#usun_zapotrzebowanie").length) {
                return true;
            }
            else{
                alert("Brak produktów w zapotrzebowaniu.")
                return false;
            }
        });
//-------------------------------------------- koniec -----------------------------------------------------------------------------------------
            $('#rola').on('change',function(){
                $('#form_rola').submit();
            });


});