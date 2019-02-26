/*
  Jquery Validation using jqBootstrapValidation
   example is taken from jqBootstrapValidation docs 
  */


    function anzeigen(getShowX, getShowY, id) {
        var showx = getShowX;
        var showy = getShowY;

        showy = showy * (-1);
        showx = showx * (1);

        showx += 17100;
        showy += 4200;

        showx = (showx / 5.9988457503);
        showy = (showy / 5.991452991);

        bpx = (showx - (150 / 2)) * (-1);
        bpy = (showy - (150 / 2)) * (-1);

        $( id ).css("backgroundPosition", bpx + "px " + bpy + "px");
    }