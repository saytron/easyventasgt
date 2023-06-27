var nombre = '';
scannear_botones( ); //carga la pagina y le digo que sea operativo el funcionamiento de los links...

const form = document.querySelector( 'header form' );
form.addEventListener( 'submit', function( e ){
	nombre = form.querySelector( 'input[type=search]' ).value;
	num = 1;

	//const anterior = document.querySelector( '.actual' );
	//if( anterior ) anterior.classList.remove( 'actual' );
	//document.querySelector('#paginador li:first-child a').classList.add( 'actual' );

	buscar( nombre, num );

	e.preventDefault( );
} );


function scannear_botones( ){
	const botones = document.querySelectorAll( '#paginador a' );
	for( let i = 0; i < botones.length; i++ ){
		botones[i].addEventListener( 'click', function( e ){
			//const anterior = document.querySelector( '.actual' );
			//if( anterior ) anterior.classList.remove( 'actual' );
			//e.target.classList.add( 'actual' );
		
			const num = e.target.dataset.pagina;
			buscar( nombre, num );
			e.preventDefault( );
		} );
	}
}



function buscar( que, num ){
	const fd = new FormData( );
		  fd.append( 'nombre', que );
		  fd.append( 'numero', num );

		fetch( 'cargarProducto.php', { method: 'post', body: fd } )
		.then( function( j ){ return j.json( ); })
		.then( function( d ){
			const publicaciones = document.getElementById('publicaciones');
			const paginador = document.getElementById('paginador');

			//RESETEA EL LISTADO DE RESULTADOS DE ESTA PAGINA....
			publicaciones.innerHTML = '';
			d.resultados.forEach( u => {
				publicaciones.innerHTML += `
					<li>
						<h3>${ u.NOMBRE }</h3>
						<p>${ u.DESCRIPCION }</p>
						<a href='leer.php?id=${ u.ID }'>Ver publicación</a>
					</li>
				`;
			} );
			
			//RESETEAR LA BOTONERA DEL PAGINADOR...
			paginador.innerHTML = '';
			console.log( d );
			for( let i = 1; i <= d.paginas; i++ ){
				let actual = d.actual == i ? " class='actual' " : "";
				paginador.innerHTML += `<li><a href='' ${ actual } data-pagina='${ i }'>${ i }</a></li>`;
			}
			scannear_botones( );
		} );
}
