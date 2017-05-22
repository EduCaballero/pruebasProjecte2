$(document).ready(function () {
    jQuery.validator.addMethod("regex", function (value, element, regexp) {
        return this.optional(element) || regexp.test(value);
    });
    $(".provincia").change(function () {
        $.ajax({
            type: "POST",
            url: "municipios.php",
            dataType: "json",
            data: {id: $(".provincia").val()},
            success: function (data) {
                $(".ciudad option").remove();
                $.each(data, function () {
                    $(".ciudad").append('<option value="' + this.id + '">' + this.municipio + '</option>');
                });
            }
        });
    });
    $("#reg-user").validate({
        focusCleanup: true,
        rules: {
            email: {
                required: true,
                maxlength: 80,
                email: true,
                remote: {
                    type: "post",
                    url: "validateEmail.php"
                }
            },
            password: {
                required: true,
                maxlength: 32,
                minlength: 4,
                regex: /^[-!$@%/º~ª?&*,.()_+=\w.]+$/
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            },
            usertype: "required"
        },
        messages: {
            email: {
                required: "Este campo es obligatorio",
                maxlength: "Por favor, introduce no más de 80 caracteres",
                email: "Introduce una direccion de email valida",
                remote: "Este correo ya está en uso"
            },
            password: {
                required: "Este campo es obligatorio",
                regex: "La contraseña contiene caracteres no permitidos",
                maxlength: "Por favor, introduce no más de 32 caracteres",
                minlength: "Por favor, introduce por lo menos 4 caracteres"
            },
            confirm_password: {
                equalTo: "Las contraseñas no son iguales",
                required: "Este campo es obligatorio"
            },
            usertype: {
                required: "Este campo es obligatorio"
            }
        }
    });
    $("#user-local").validate({
        focusCleanup: true,
        rules: {
            nombre_local: {
                required: true,
                maxlength: 60,
                regex: /^[-!$@%/º~ª?&*,.()_+=\s\w.]+$/
            },
            ciudad_local: "required",
            dir_local: {
                required: true,
                maxlength: 60,
                regex: /^[-!$@%/º~ª?&*,.()_+=\s\w.]+$/
            },
            aforo: {
                required: true,
                digits: true,
                maxlength: 9
            },
            telefono_local: {
                digits: true,
                minlength: 9,
                maxlength: 9
            },
            web_local: {
                url: true,
                maxlength: 80
            }
        },
        messages: {
            nombre_local: {
                required: "Este campo es obligatorio",
                maxlength: "Por favor, introduce no más de 60 caracteres",
                regex: "El nombre contiene caracteres no permitidos"
            },
            ciudad_local: {
                required: "Este campo es obligatorio"
            },
            dir_local: {
                required: "Este campo es obligatorio",
                maxlength: "Por favor, introduce no más de 60 caracteres",
                regex: "La dirección contiene caracteres no permitidos"
            },
            aforo: {
                required: "Este campo es obligatorio",
                maxlength: "Por favor, introduce no más de 9 caracteres",
                digits: "Por favor, introduce solo digitos"
            },
            telefono_local: {
                minlength: "Por favor, intruduce 9 caracteres como minimo",
                maxlength: "Por favor, introduce no más de 9 caracteres",
                digits: "Por favor, introduce solo digitos"
            },
            web_local: {
                url: "Introduce una url valida",
                maxlength: "Por favor, introduce no más de 80 caracteres"
            }
        }
    });
    $("#user-musico").validate({
        focusCleanup: true,
        rules: {
            nombre_musico: {
                required: true,
                maxlength: 60,
                regex: /^[-!$@%/º~ª?&*,.()_+=\s\w.]+$/
            },
            ciudad_local: "required",
            genero: "required",
            num_miembros: {
                required: true,
                digits: true,
                maxlength: 4
            },
            telefono_musico: {
                digits: true,
                minlength: 9,
                maxlength: 9
            },
            web_musico: {
                url: true,
                maxlength: 80
            }
        },
        messages: {
            nombre_musico: {
                required: "Este campo es obligatorio",
                maxlength: "Por favor, introduce no mas de 60 caracteres",
                regex: "El nombre contiene caracteres no permitidos"
            },
            ciudad_local: {
                required: "Este campo es obligatorio"
            },
            genero: {
                required: "Este campo es obligatorio"
            },
            num_miembros: {
                required: "Este campo es obligatorio",
                maxlength: "Por favor, introduce no mas de 4 caracteres",
                digits: "Por favor, introduce solo digitos"
            },
            telefono_musico: {
                minlength: "Por favor, intruduce 9 caracteres como minimo",
                maxlength: "Por favor, introduce no más de 9 caracteres",
                digits: "Por favor, introduce solo digitos"
            },
            web_musico: {
                url: "Introduce una url valida",
                maxlength: "Por favor, introduce no más de 80 caracteres"
            }
        }
    });
    $("#user-fan").validate({
        focusCleanup: true,
        rules: {
            nombre_fan: {
                required: true,
                maxlength: 60,
                regex: /^[-!$@%/º~ª?&*,.()_+=\s\w.]+$/
            },
            apellidos_fan: {
                required: true,
                maxlength: 60,
                regex: /^[-!$@%/º~ª?&*,.()_+=\s\w.]+$/
            },
            telefono_fan: {
                digits: true,
                minlength: 9,
                maxlength: 9
            },
            ciudad_fan: "required",
            fan_sex: "required",
            day: "required",
            month: "required",
            year: "required",
            web_fan: {
                url: true,
                maxlength: 80
            }
        },
        messages: {
            nombre_fan: {
                required: "Este campo es obligatorio",
                maxlength: "Por favor, introduce no mas de 60 caracteres",
                regex: "El nombre contiene caracteres no permitidos"
            },
            apellidos_fan: {
                required: "Este campo es obligatorio",
                maxlength: "Por favor, introduce no mas de 60 caracteres",
                regex: "Los apellidos contienen caracteres no permitidos"
            },
            telefono_fan: {
                minlength: "Por favor, intruduce 9 caracteres como minimo",
                maxlength: "Por favor, introduce no más de 9 caracteres",
                digits: "Por favor, introduce solo digitos"
            },
            ciudad_fan: {
                required: "Este campo es obligatorio"
            },
            fan_sex: {
                required: "Este campo es obligatorio"
            },
            day: {
                required: "Este campo es obligatorio"
            },
            month: {
                required: "Este campo es obligatorio"
            },
            year: {
                required: "Este campo es obligatorio"
            },
            web_fan: {
                url: "Introduce una url valida",
                maxlength: "Por favor, introduce no más de 80 caracteres"
            }
        }
    });
});