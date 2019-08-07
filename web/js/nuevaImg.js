//creamos la variable para guardar 
//formato de la imagen
var tiposValidos = 
[
    'image/jpeg',
    'image/png',
]
//validamos que no se entregue otro tipo
//de formato
function validarTipos(file)
{
    for(var i=0; i<tiposValidos.length; i++)
    {
        if(file.type === tiposValidos[i])
        {
            return true
        }
    }
    return false
}
//creamos el evento que nos entregara
//un alerta sobre si cumple con el formato
function onChange(event)
{
    var file = event.target.files[0];
    if (validarTipos(file))
    {
        var platoMiniatura=document.getElementById("platoThumb");
        platoThumb.src=window.URL.createObjectURL();
    }
}