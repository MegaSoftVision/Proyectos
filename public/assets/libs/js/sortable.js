const encuesta2 = document.getElementById('encuesta');

Sortable.create(encuesta2,{
	animation: 150,
	chosenClass: "seleccionado",
	dragClass: "drag",

	onEnd: () => {
		console.log('Se insertó un elemento');
	},
	group: "lista-preguntas",
	store: {
		set: (sortable) => {
			const orden = sortable.toArray();
			localStorage.setItem(sortable.options.group.name, orden.join('-'));
		},
		get: (sortable) => {
			const orden = localStorage.getItem(sortable.options.group.name);
			return orden ? orden.split('-') : [];
		}
	}
});