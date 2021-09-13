$(document).ready(function(){
    $('#Sucursal_Remitente').on('change',function(){
        var Sucursal_Remitente = $(this).val();
        if(Sucursal_Remitente){
            $.ajax({
                type:'json',
			url:'http://guiasremision/boletasremision/SucursalDestino/$Sucursal_Remitente',
                data:'Sucursal_Remitente='+Sucursal_Remitente,
                success:function(html){
                    $('#Sucursal_Remitente').html(html);
                    $('#Sucursal_Destino').html('<option value="0"></option>'); 
                }
            }); 
        }else{
            $('#Sucursal_Remitente').html('<option value="0">Seleccione</option>');
            $('#Sucursal_Destino').html('<option value="0">Seleccione</option>'); 
        }
    });
});