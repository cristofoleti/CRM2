$(document).ready(function(){	
    $("#btAtualizarPgtosCEF").click(function () {AtualizarDocsCEF();});
});

function AtualizarDocsCEF(){
       
            var idForm             	= "frmCriarDesafio";            
            var ufile                   = $('#ufileDesafio').val();
             
	//console.log("Enviar arquivo");
	
	if(novoNome==""){novoNome="";}
	if(pagina==""){pagina="altius/cursos/programacaoCursoProfessor.php?u=";}
	
	var fd = new FormData(document.getElementById(idForm));
        var url = path + "altius/arquivo/upload.php";
        
        
	fd.append("novoNome", novoNome);	
	$.ajax({
	  url: url,
	  type: "POST",
	  data: fd,
	  enctype: 'multipart/form-data',
	  processData: false,  // tell jQuery not to process the data
	  contentType: false,   // tell jQuery not to set contentType
	beforeSend: function (load) {
		alert("Enviando arquivo, aguarde...");
		$('#modal-aguarde').modal('show');
	},
	success: function (data)
	{
		data = JSON.parse(data);		
		if(data["status"]=="ERRO"){
			alert("Seu arquivo não pode ser enviado. Contate o administrador. " + data["error"]);
		}else{
			alert("Arquivo enviado com sucesso");
		}
                
                $('#hdGravaRef').val(gravaRef);
		$('#hdArquivo').val(data["idArquivo"]);
		$('#hdArquivo').trigger('salvo');
                
                
                $('#hdRecarregarRedirect').val(pagina);
                $('#hdRecarregar').val('1');
		//$('#hdRecarregar').trigger('recarregar');
		
		
	},
	error: function (request, status, error)
	{
		alert("Seu arquivo não pode ser enviado. Contate o administrador.");
		$('#hdRecarregar').val('1');
		$('#hdRecarregar').trigger('recarregar');
	}
	});

         return false;
         
    }
 