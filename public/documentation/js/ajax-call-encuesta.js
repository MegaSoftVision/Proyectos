function ListarPreguntas(id_e){
	var Ruta2 = Routing.generate('load_preguntas' );
	$(document).ready(function(){   
		
		$.ajax({  
			url:        Ruta2,  
			data: ({id_e:id_e}),
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
        encuesta = data['encuesta'];
				var encuesta_id = encuesta['id_e'];
				var encuesta_d = encuesta['descripcion'];
				for(i = 0; i < data['valores'].length; i++) {
					valor = data['valores'][i];
					
          var card = $('<div class="card"><div class="card-body"><div class="list-group" id="text-valor-'+i+'"></div></div><div class="card-footer" id="valor-footer-'+i+'"></div></div>');
          
          if (valor['active'] == true) {
            var button = $('<div class="card-footer-item card-footer-item-bordered"><a href="javascript: void(0);" class="card-link" onClick="AddOrDeleteEncuesta('+valor['id_v']+','+encuesta_id+','+0+')"> Eliminar a la encuesta</div>')					
            var text = $('<div style="background-color:#e9f9ec" class="list-group-item list-group-item-action flex-column align-items-start"><div class="d-flex w-100 justify-content-between"><h5 class="mb-1">'+valor['descripcion']+'</h5><small class="text-muted">'+valor['date_create']+'</small></div><p class="mb-1"><small class="text-muted">'+valor['categoria_d']+'</small></p><span class="mb-1"> <span class="badge-dot" style="background-color:'+valor['color']+'"></span><small class="text-muted">'+valor['color']+'</small></span></div>');
          } else{
            var text = $('<div style="background-color:#f9e9e9" class="list-group-item list-group-item-action flex-column align-items-start"><div class="d-flex w-100 justify-content-between"><h5 class="mb-1">'+valor['descripcion']+'</h5><small class="text-muted">'+valor['date_create']+'</small></div><p class="mb-1"><small class="text-muted">'+valor['categoria_d']+'</small></p><span class="mb-1"> <span class="badge-dot" style="background-color:'+valor['color']+'"></span><small class="text-muted">'+valor['color']+'</small></span></div>');
            var button = $('<div class="card-footer-item card-footer-item-bordered"><a href="javascript: void(0);" class="card-link" onClick="AddOrDeleteEncuesta('+valor['id_v']+','+encuesta_id+','+1+')">  Agregar a la encuesta</div>')					
          }
          
          $('#valores-body').append(card);
					$('#text-valor-'+i+'').append(text);
          $('#valor-footer-'+i+'').append(button);

				}

				for(i = 0; i < data['preguntas'].length; i++) {
						
					pregunta = data['preguntas'][i];
					
					
					var pregunta_id = pregunta['id_p'];
					var pregunta_type = pregunta['type'];
					var remove = $('<a href="javascript: void(0);" class="card-link" onClick="EliminarPregunta(' + pregunta_id + ',' + encuesta_id + ')"><i class="far fa-trash-alt fa-2x"></i></a>');
					var duply = $('<a href="javascript: void(0);" class="card-link" onClick="DuplicarPregunta(' + pregunta_id + ',' + encuesta_id + ')"><i class="far fa-copy fa-2x"></i></a>');
          
					
					var input = $('<input id="pregunta-'+pregunta_id+'" type="text" value="'+pregunta['descripcion']+'" class="form-control border-none font-input">');
					var position = $('<input id="posicion-'+i+'" type="hidden" value="'+i+'">');
					                               
					if (pregunta_type=='simple') {
						var card = $(
							'<div class="section-block" id="block-'+pregunta_id+'" data-id="'+pregunta_id+'"><div class="card"><div class="card-header"><p>Pregunta de Respuesta Simple</p></div><div class="card-body border-top"> <div class="form-group" id="descripcion_p-'+pregunta_id+'"></div> </div> <div class="card-footer"> <div class="card-footer-item card-footer-item-bordered" id="botones-'+pregunta_id+'"></div> <div class="card-footer-item card-footer-item-bordered" id="save-'+pregunta_id+'"></div></div></div></div>'
						);
					}
					if (pregunta_type=='seleccion') {
						var add = $('<a href="javascript: void(0);" onClick="CrearSeleccion(' + pregunta_id + ',' + encuesta_id + ')">Añadir Opción</a>');
						var card = $(
							'<div class="section-block" id="block-'+pregunta_id+'" data-id="'+pregunta_id+'"><div class="card"><div class="card-header"><p>Pregunta de Seleccion Simple</p></div><div class="card-body border-top"> <div class="form-group" id="descripcion_p-'+pregunta_id+'"> </div> <div id="row-selecciones-'+pregunta_id+'"> </div> <div class="row"> <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="añadiropcion-'+pregunta_id+'"> </div> </div> </div> <div class="card-footer"> <div class="card-footer-item card-footer-item-bordered" id="botones-'+pregunta_id+'"> </div> <div class="card-footer-item card-footer-item-bordered" id="save-'+pregunta_id+'"> </div> </div> </div></div>'
						);
					}
					if (pregunta_type=='clasificacion') {
						var add = $('<a href="javascript: void(0);" onClick="CrearGrupo(' + pregunta_id + ',' + encuesta_id + ')">Añadir Opción</a>');
						var card = $(
							'<div class="section-block" id="block-'+pregunta_id+'" data-id="'+pregunta_id+'"><div class="card"><div class="card-header"><p>Pregunta de Clasificación</p></div><div class="card-body border-top"> <div class="form-group" id="descripcion_p-'+pregunta_id+'"> </div> <div id="row-grupos-'+pregunta_id+'"> </div> <div class="row"> <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="añadiropcion-'+pregunta_id+'"> </div> </div> </div> <div class="card-footer"> <div class="card-footer-item card-footer-item-bordered" id="botones-'+pregunta_id+'"> </div> <div class="card-footer-item card-footer-item-bordered" id="save-'+pregunta_id+'"> </div> </div> </div></div>'
						);
					}
					
						var sidebar = $('<li><a href="#block-'+pregunta_id+'" id="descripcion_p-'+pregunta_id+'">'+pregunta['descripcion']+'</a></li>');

						//+'<button onclick="EliminarSeleccion(' + seleccion['id_s'] + ',' + encuesta_id + ')">Eliminar</button>
						
					$('#encuesta').append(card);
					$('#descripcion_p-'+pregunta_id+'').append(input);
					$('#descripcion_p-'+pregunta_id+'').append(position);
					$('#botones-'+pregunta_id+'').append(remove);
					$('#botones-'+pregunta_id+'').append(duply);
					$('#añadiropcion-'+pregunta_id+'').append(add);
					
          $('#sidebar').append(sidebar);
					
					var ix = 0;
					if (pregunta_type=='clasificacion') {
						pregunta['grupos'].forEach(function(grupo){
								var div = $('<div id="row-grupos-'+pregunta_id+'-'+ix+'"></div>')
								var row = $(
									'<div class="form-row"><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2" id="grupos-'+pregunta_id+'-'+ix+'"></div> <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 mb-1"> <div class="row"> <div class="col-6" id="r_grupo-'+pregunta_id+'-'+ix+'"></div> </div> </div> </div>'
								);
								$('#row-grupos-'+pregunta_id+'').append(div);
								$('#row-grupos-'+pregunta_id+'-'+ix+'').append(row);
								var remove_g = $('<a href="javascript: void(0);" class="card-link" onclick="EliminarGrupo(' + grupo['id_g'] + ',' + encuesta_id + ')"><i class="fas fa-times fa-2x"></i></a>');
						 		var u_grupo = $('<input id="grupo_v-'+pregunta_id+'-'+ix+'" type="text" class="form-control form-control-sm" placeholder="Grupo" value="'+grupo['descripcion']+'">');
								$('#grupos-'+pregunta_id+'-'+ix+'').append(u_grupo);
								
								$('#r_grupo-'+pregunta_id+'-'+ix+'').append(remove_g);
								ix++;
						});
						var save = $(
							'<a href="javascript: void(0);" onClick="GuardarPregunta('+pregunta_id+','+encuesta_id+','+ix+');" class="card-link">Guardar Pregunta</a>'
							);
					}
					if (pregunta_type=='seleccion') {
						pregunta['selecciones'].forEach(function(seleccion){
								var div = $('<div id="row-selecciones-'+pregunta_id+'-'+ix+'"></div>')
								var row = $(
									'<div class="form-row"><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2" id="selecciones-'+pregunta_id+'-'+ix+'"> </div> <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 mb-1"> <div class="row"> <div class="col-6" id="valores-'+pregunta_id+'-'+ix+'"> </div> <div class="col-6" id="r_seleccion-'+pregunta_id+'-'+ix+'"> </div> </div> </div> </div>'
								);
								$('#row-selecciones-'+pregunta_id+'').append(div);
								$('#row-selecciones-'+pregunta_id+'-'+ix+'').append(row);
								var remove_s = $('<a href="javascript: void(0);" class="card-link" onclick="EliminarSeleccion(' + seleccion['id_s'] + ',' + encuesta_id + ')"><i class="fas fa-times fa-2x"></i></a>');
						 		var u_seleccion = $('<input id="seleccion_v-'+pregunta_id+'-'+ix+'" type="text" class="form-control form-control-sm" placeholder="Seleccion" value="'+seleccion['descripcion']+'">');
								var valor = $('<select class="form-control form-control-sm" id="valor_v-'+pregunta_id+'-'+ix+'"><option value="'+seleccion['id_v']+'" selected>'+seleccion['valor']+'</option></select>');
								$('#selecciones-'+pregunta_id+'-'+ix+'').append(u_seleccion);
								$('#valores-'+pregunta_id+'-'+ix+'').append(valor);
								for(ix2 = 0; ix2 < data['valores_e'].length; ix2++) {
									valores = data['valores_e'][ix2];
									var options = $('<option value="'+valores['id_v']+'">'+valores['descripcion']+'</option>');
									$('#valor_v-'+pregunta_id+'-'+ix+'').append(options);  
								}
								$('#r_seleccion-'+pregunta_id+'-'+ix+'').append(remove_s);
								ix++;
						});
						var save = $(
							'<a href="javascript: void(0);" onClick="GuardarPregunta('+pregunta_id+','+encuesta_id+','+ix+');" class="card-link">Guardar Pregunta</a>'
							);
					}
					

					
					$('#save-'+pregunta_id+'').append(save);
					//$('#pregunta-'+pregunta_id+'').append(add);
					
				}  
			},  
			error : function(xhr, textStatus, errorThrown) {  
				alert('Ajax request failed.');  
			}  
		});  
		
	});  
}
function AddOrDeleteEncuesta(id_v, id_e, status){
  var Ruta = Routing.generate('addordelete_encuesta');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data:({
			id_v:id_v, id_e:id_e, status:status
		 }),
		async: true,
		dataType: "json",
		success: function(data){
			ListarPreguntas(id_e);
			console.log(data);
		},
		error: function(xhr, textStatus, errorThrown){
			alert('Ajax request failed.');
		}
	})
}
function Posiciones(id_e){
	var posiciones = new Array();
	const orden = localStorage.getItem('lista-preguntas');
	posiciones = orden.split('-');
	
	for (var i = 0; i < posiciones.length; i++) {
		posiciones[i] = {
			"posicion": posiciones[i],
		}
		
	}
	var data = {
		"id_e": id_e,
		"posiciones": posiciones
	}
	var Ruta = Routing.generate('order_encuesta');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data:({
			data:data,
		 }),
		async: true,
		dataType: "json",
		success: function(data){
			ListarPreguntas(id_e);
			console.log(data);
		},
		error: function(xhr, textStatus, errorThrown){
		
		}
	})
}

function GuardarPregunta(id_p, id_e, ix){

	var pregunta_v = {
		"id": id_p,
		"descripcion": document.getElementById("pregunta-"+id_p).value,
	};
	var selecciones = new Array();
	var grupos = new Array();
	try {
		for (var i = 0; i <ix; i++) {
			selecciones[i] = {
					"descripcion_s":document.getElementById("seleccion_v-"+id_p+'-'+i).value,
					"id_v":document.getElementById("valor_v-"+id_p+'-'+i).value,
			};
			
		}
	} catch (e) {
		console.error(e);
	}
	try {
		for (var i = 0; i < ix; i++) {
			grupos[i] = {
					"descripcion_g":document.getElementById("grupo_v-"+id_p+'-'+i).value,
					
			};
		}
	} catch (e) {
		console.error(e);
	}
	
	
	var data = {
		"pregunta": pregunta_v,
		"selecciones": selecciones,
		"grupos": grupos
	}
	var Ruta = Routing.generate('save_pregunta');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data:({
			data:data,
			
		 }),
		async: true,
		dataType: "json",
		success: function(data){
			ListarPreguntas(id_e);
			console.log(data);
		},
		error: function(xhr, textStatus, errorThrown){
			alert('Ajax request failed.');
		}
	})
}  
function CrearSeleccion(id_p, id_e){
	var Ruta = Routing.generate('add_seleccion');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data: ({id_p:id_p,id_e:id_e}),
		async: true,
		dataType: "json",
		success: function(data){
			
			console.log(data);
			ListarPreguntas(id_e);
		},
		error : function(xhr, textStatus, errorThrown) {  
			alert('Ajax request failed.');  
		}  
	})
}
function CrearGrupo(id_p, id_e){
	var Ruta = Routing.generate('add_grupo');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data: ({id_p:id_p,id_e:id_e}),
		async: true,
		dataType: "json",
		success: function(data){
			
			console.log(data);
			ListarPreguntas(id_e);
		},
		error : function(xhr, textStatus, errorThrown) {  
			alert('Ajax request failed.');  
		}  
	})
}
function CrearPregunta(id, type){
	var Ruta = Routing.generate('add_pregunta');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data: ({id:id, type: type}),
		async: true,
		dataType: "json",
		success: function(data){
			
			console.log(data);
			ListarPreguntas(id);
		},
		error : function(xhr, textStatus, errorThrown) {  
			alert('Ajax request failed.');  
		}  
	})
}

function DuplicarPregunta(id_p, id_e){
	var Ruta = Routing.generate('duply_pregunta');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data: ({id_p: id_p, id_e:id_e}),
		async: true,
		dataType: "json",
		success: function(data){
			ListarPreguntas(id_e);
			console.log(data);
		},
		error : function(xhr, textStatus, errorThrown) {  
			alert('Ajax request failed.');  
		}  
	})
}
function EliminarPregunta(id_p, id_e){
	var Ruta = Routing.generate('delete_pregunta');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data: ({id_p:id_p}),
		async: true,
		dataType: "json",
		success: function(data){
			ListarPreguntas(id_e);
			console.log(data);
		},
		error : function(xhr, textStatus, errorThrown) {  
			alert('Ajax request failed.');  
		}  
	})
}

function GuardarEncuesta(id_e){
	var descripcion = document.getElementById("encuesta-descripcion-"+id_e).value
	var instructivo = document.getElementById("encuesta-instructivo-"+id_e).value
  var color = document.getElementById("encuesta-color-"+id_e).value
  var id_c = document.getElementById("encuesta-categoria-"+id_e).value
	var Ruta = Routing.generate('save_encuesta');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data: ({id_e:id_e, descripcion:descripcion, color:color, instructivo:instructivo, id_c:id_c}),
		async: true,
		dataType: "json",
		success: function(data){
			
			console.log(data);
			ListarPreguntas(id_e);
		},
		error : function(xhr, textStatus, errorThrown) {  
			alert('Ajax request failed.');  
		}  
	})
}

function EliminarSeleccion(id_s, id_e){
	var Ruta = Routing.generate('delete_seleccion');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data: ({id_s:id_s}),
		async: true,
		dataType: "json",
		success: function(data){
			ListarPreguntas(id_e);
			console.log(data);
		},
		error : function(xhr, textStatus, errorThrown) {  
			alert('Ajax request failed.');  
		}  
	})
}
function EliminarGrupo(id_g, id_e){
	var Ruta = Routing.generate('delete_grupo');
	$.ajax({
		type: 'POST',
		url: Ruta,
		data: ({id_g:id_g}),
		async: true,
		dataType: "json",
		success: function(data){
			ListarPreguntas(id_e);
			console.log(data);
		},
		error : function(xhr, textStatus, errorThrown) {  
			alert('Ajax request failed.');  
		}  
	})
}
