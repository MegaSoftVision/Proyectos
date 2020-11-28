function ListarValores(){
	var Ruta2 = Routing.generate('load_valores' );
	$(document).ready(function(){   
		
		$.ajax({  
			url:        Ruta2,  
			data: ({}),
			type:       'POST',   
			dataType:   'json',  
			async:      true,  
			
			success: function(data, status) {
				console.log(data);
			javascript: void(0);
			href="javascript: void(0);"
				$('#sidebar').html('');
				$('#encuesta').html('');   
				$('#valores-body').html('');	 

				for(i = 0; i < data['valores'].length; i++) {
					valor = data['valores'][i];
					var card = $('<div class="card"><div class="card-body" id="input-valor-'+i+'"></div><div class="card-footer" id="block-valor-'+valor['id_v']+'-'+i+'"> </div> </div>');
					
					var input = $('<div class="form-group"><input class="form-control form-control-lg border-none" id="valor-'+valor['id_v']+'-'+i+'" value="'+valor['descripcion']+'"></div>');
          var color = $('<div class="form-group"><label class="col-form-label">Color en Graficas</label><input class="form-control border-none" style="height:50px;" type="color" id="valor-color'+valor['id_v']+'-'+i+'" value="'+valor['color']+'"></div>');
          var save = $('<div class="card-footer-item card-footer-item-bordered"><a href="javascript: void(0);" onClick="GuardarValor('+valor['id_v']+','+i+')">Guardar</a></div>');
					var date = $('<p class="text-right card-footer-item card-footer-item-bordered" style="float:right"><small class="text-muted">Creado el: '+valor['date_create']+'</small></p>');
					var duply = $('<a href="javascript: void(0);" class="card-link" onClick="DuplicarValor('+valor['id_v']+')"><i class="far fa-copy fa-2x"></a></div>');
					var remove = $('<div class="card-footer-item card-footer-item-bordered"><a href="javascript: void(0);" class="card-link" onClick="EliminarValor('+valor['id_v']+')"><i class="far fa-trash-alt fa-2x"></a>');
					
					$('#valores-body').append(card);
					$('#input-valor-'+i+'').append(input);
          $('#input-valor-'+i+'').append(color);    
					var options = $('<div class="form-group"><select class="form-control form-control-sm" id="valor_v-'+valor['id_v']+'-'+i+'"><option value="'+valor['categoria_id']+'" selected>'+valor['categoria_d']+'</option></select></div>');
					$('#input-valor-'+i+'').append(options);   
				
					for(ix2 = 0; ix2 < data['categorias'].length; ix2++) {
						categoria = data['categorias'][ix2];
						
						var option = $('<option value="'+categoria['id_c']+'">'+categoria['descripcion']+'</option>');
						$('#valor_v-'+valor['id_v']+'-'+i+'').append(option);  
					} 
					$('#block-valor-'+valor['id_v']+'-'+i).append(duply); 
					$('#block-valor-'+valor['id_v']+'-'+i).append(remove); 
					$('#block-valor-'+valor['id_v']+'-'+i).append(save); 
					$('#block-valor-'+valor['id_v']+'-'+i).append(date); 
					
				}

			},  
			error : function(xhr, textStatus, errorThrown) {  
				alert('Ajax request failed.');  
			}  
		});  
		
	});  
}

function CrearValor(){
	var Ruta = Routing.generate('add_valor');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data: ({}),
		async: true,
		dataType: "json",
		success: function(data){
			
			console.log(data);
			ListarValores();
		},
		error : function(xhr, textStatus, errorThrown) {  
			alert('Ajax request failed.');  
		}  
	})
}

function GuardarValor(id_v, i){
	var descripcion = document.getElementById("valor-"+id_v+'-'+i).value
  var color = document.getElementById("valor-color"+id_v+'-'+i).value
	var id_c = document.getElementById("valor_v-"+id_v+'-'+i).value;
	var Ruta = Routing.generate('save_valor');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data: ({id_v:id_v, descripcion:descripcion, color: color, id_c:id_c}),
		async: true,
		dataType: "json",
		success: function(data){
			
			console.log(data);
			ListarValores();
		},
		error : function(xhr, textStatus, errorThrown) {  
			alert('Ajax request failed.');  
		}  
	})
}

function DuplicarValor(id_v){
	var Ruta = Routing.generate('duply_valor');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data: ({id_v: id_v}),
		async: true,
		dataType: "json",
		success: function(data){
			ListarValores();
			console.log(data);
		},
		error : function(xhr, textStatus, errorThrown) {  
			alert('Ajax request failed.');  
		}  
	})
}
function EliminarValor(id_v){
	var Ruta = Routing.generate('delete_valor');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data: ({id_v:id_v}),
		async: true,
		dataType: "json",
		success: function(data){
			ListarValores();
			if (data['status']) {
				alert('El valor '+data['entidad']+' se elimino con exito.');  
			}
			console.log(data);
		},
		error : function(xhr, textStatus, errorThrown) {  
			alert('Ajax request failed.');  
		}  
	})
}


