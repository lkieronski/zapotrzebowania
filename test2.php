<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    var form = $("#buildyourform");
    $("#add").click(function() {
        
        //var lastField = $("#buildyourform div:last");
        //var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
        var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field\"/>");
        //fieldWrapper.data("idx");
        var fName = $("<input type=\"text\" name=\"nazwa\" />");
        var filosc = $("<input type=\"number\" name=\"ilosc\" />");
        //var fType = $("<select class=\"fieldtype\"><option value=\"checkbox\">Checked</option><option value=\"textbox\">Text</option><option value=\"textarea\">Paragraph</option></select>");
        fieldWrapper.append(fName);
        fieldWrapper.append(filosc);
        //fieldWrapper.append(fType);
        form.append(fieldWrapper);
    });

    $("#remove").click(function() {
        //$("#buildyourform").children().last().remove();
        form.children().last().remove();
    });
});
</script>
<style>
.fieldwrapper{
    margin: 30px 30px;
}

.fieldwrapper input{
    width: 50px;
}

</style>
</head>
<body>

<Form id="buildyourform">
</Form>
<input type="button" value="+" class="add" id="add" />
<input type="button" value="-" class="add" id="remove" />

</body>
</html>