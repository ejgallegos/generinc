var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { alert("submitted!"); }
    });

    $().ready(function() {
        // validate the comment form when it is submitted
        $("#commentForm").validate();

        // validate signup form on keyup and submit
        $("#signupForm").validate({
            rules: {
                firstname: "required",
                lastname: "required",
                documento: {
                    required: true,
                    minlength: 6
                },
                calle_pers: {
                    required: true
                },
                nro_pers: "required",
                barrio_pers: "required"
            },
            messages: {
                firstname: "Por favor ingrese el nombre",
                lastname: "Por favor ingrese el apellido",
                documento: {
                    required: "Por favor ingrese el documento de identidad",
                    minlength: "El documento debe tener al menos 6 dígitos"
                },
                calle_pers: "Debe ingresar el domicilio particular",
                nro_pers: "Debe ingresar el domicilio particular",
                barrio_pers: "Debe ingresar el domicilio particular"
            }
        });

        // propose username by combining first- and lastname
        $("#username").focus(function() {
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            if(firstname && lastname && !this.value) {
                this.value = firstname + "." + lastname;
            }
        });

        //code to hide topic selection, disable for demo
        var newsletter = $("#newsletter");
        // newsletter topics are optional, hide at first
        var inital = newsletter.is(":checked");
        var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
        var topicInputs = topics.find("input").attr("disabled", !inital);
        // show when newsletter is checked
        newsletter.click(function() {
            topics[this.checked ? "removeClass" : "addClass"]("gray");
            topicInputs.attr("disabled", !this.checked);
        });
    });


}();
