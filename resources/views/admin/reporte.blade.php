<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<style type="text/css">
			* {
				font-family: Helvetica;
			}
			.page-break {
				page-break-after: always;
			}
			body {
				margin:0;
				padding:0;
			}
			h1 {
				text-align: center;
				padding-bottom: -10px;
				padding-top: 20px;
				font-size: 30px;
			}
			p {
				text-align: center;
				padding-bottom: -15px;
				font-size: 14px;
			}
			#datos_encabezado{
				padding-top: 30px;
				padding-bottom: 30px;
				font-size: 24px;
			}
			#datos_encabezado2{
				font-size: 24px;
			}
			.tabla_datos{
				font-size: 11px;
				width: 100%;
				border-collapse: collapse;
				border: 1px solid;
			}
			td {
				padding-top: 1em;
				padding-bottom: 1em;
				padding-left: 15px;
			}
		</style>
	</head>
	<body>
		<h1>HOJA DE VIDA DE ASPIRANTE</h1>
		<p>Universidad Nacional de Colombia - Sede Bogotá<p>
		<p>Facultad de Ingeniería - Concurso Docente 2017<p>
		
		<!-- Sección de perfiles seleccionados, tomados de la variable $perfiles -->
		<h2 id="datos_encabezado">Perfiles</h2>
		<hr>
		<br>
		<table class="tabla_datos">
			@foreach ($perfiles as $perfil)
			<tr>
				<td>
					<strong>Perfil</strong>
				</td>
				<td>
					{{$perfil->identificador}}
				</td>
				<td>
					<strong>Área de desempeño</strong>
				</td>
				<td>
					{{$perfil->area}}
				</td>
			</tr>
			@endforeach
		</table>
		
		<!-- Sección de datos personales, tomados de la variable $aspirante -->
		<h2 id="datos_encabezado">Datos Personales</h2>
		<hr>
		<br>
		<table class="tabla_datos">
			<tr>
				<td>
					<strong>Apellidos</strong>
				</td>
				<td>
					{{$aspirante->apellido}}
				</td>
				<td>
					<strong>Nombres</strong>
				</td>
				<td>
					{{$aspirante->nombre}}
				</td>
			</tr>
		</table>
		<table class="tabla_datos">
			<tr>
				<td>
					<strong>Correo electrónico</strong>
				</td>
				<td>
					{{$aspirante->correo}}
				</td>
			</tr>
		</table>
		<table class="tabla_datos">
			<tr>
				<td>
					<strong>Tipo de documento</strong>
				</td>
				<td>
					{{$aspirante->tipo_documento}}
				</td>
				<td>
					<strong>Número de documento</strong>
				</td>
				<td>
					{{$aspirante->documento}}
				</td>
				<td>
					<strong>Ciudad de expedición</strong>
				</td>
				<td>
					{{$aspirante->ciudad_documento}}
				</td>
			</tr>
			<tr>
				<td>
					<strong>Fecha de nacimiento</strong>
				</td>
				<td>
					{{$aspirante->fecha_nacimiento}}
				</td>
				<td>
					<strong>País de nacimiento</strong>
				</td>
				<td>
					{{$aspirante->pais_nacimiento}}
				</td>
				<td>
					<strong>País de residencia</strong>
				</td>
				<td>
					{{$aspirante->pais_residencia}}
				</td>
			</tr>
			<tr>
				<td>
					<strong>Estado Civil</strong>
				</td>
				<td>
					{{$aspirante->estado_civil}}
				</td>
				<td>
					<strong>Dirección</strong>
				</td>
				<td>
					{{$aspirante->direccion}}
				</td>
				<td>
					<strong>Ciudad desde la cual aplica</strong>
				</td>
				<td>
					{{$aspirante->ciudad_aplicante}}
				</td>
			</tr>
		</table>
		<table class="tabla_datos">
			<tr>
				<td>
					<strong>Teléfono fijo</strong>
				</td>
				<td>
					{{$aspirante->telefono_fijo}}
				</td>
				<td>
					<strong>Teléfono móvil</strong>
				</td>
				<td>
					{{$aspirante->celular}}
				</td>
			</tr>
		</table>
		
		<!-- Sección de estudios, tomados de la variable $estudios -->
		<!-- Declaración de una variable para contar el número de estudios y saber cuando
			 crear una página nueva y otra variable con el número total de estudios -->
		<?php 
			$numero_estudios = 0; 
			$total_estudios = count($estudios);
		?>
		@if ($total_estudios > 0)
			<!-- Nueva página -->
			<div class="page-break"></div>
			<h2 id="datos_encabezado2">Estudios</h2>
			<hr>
			<br>
			@foreach ($estudios as $estudio)
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>Título académico obtenido</strong>
						</td>
						<td>
							{{$estudio->titulo}}
						</td>
					</tr>
					<tr>
						<td>
							<strong>Nombre de la institución</strong>
						</td>
						<td>
							{{$estudio->institucion}}
						</td>
					</tr>
				</table>
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>¿Estudio en curso?</strong>
						</td>
						<td>
							@if ($estudio->en_curso == 1)
								Sí
							@else
								No
							@endif
						</td>
						<td>
							<strong>Fecha de inicio</strong>
						</td>
						<td>
							{{$estudio->fecha_inicio}}
						</td>
						@if ($estudio->en_curso == 0)
							<td>
								<strong>Fecha de finalización</strong>
							</td>
							<td>
								{{$estudio->fecha_finalizacion}}
							</td>
						@endif
					</tr>
				</table>
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>País donde realizó los estudios</strong>
						</td>
						<td>
							{{$estudio->pais}}
						</td>
					</tr>
				</table>
				<br>
				<hr>
				<!-- Aumentamos el número de estudios en 1 y verificamos si ya se han colocado
					 4 estudios en la hoja de vida y si aún quedan más estudios pendientes
					 para agregar una página nueva -->
				<?php $numero_estudios++; ?>
				@if ($numero_estudios % 4 == 0 && $numero_estudios < $total_estudios )
					<!-- Nueva página -->
					<div class="page-break"></div>
					<hr>
				@endif
			@endforeach
		@endif
		
		<!-- Sección de distinciones académicas, tomadas de la variable $distinciones -->
		<!-- Declaración de una variable para contar el número de distinciones y saber cuando
			 crear una página nueva y otra variable con el número total de distinciones -->
		<?php 
			$numero_distinciones = 0; 
			$total_distinciones = count($distinciones);
		?>
		@if ($total_distinciones > 0)
			<!-- Nueva página -->
			<div class="page-break"></div>
			<h2 id="datos_encabezado2">Distinciones académicas</h2>
			<hr>
			<br>
			@foreach ($distinciones as $distincion)
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>Nombre de la distinción</strong>
						</td>
						<td>
							{{$distincion->nombre}}
						</td>
					</tr>
					<tr>
						<td>
							<strong>Nombre de la institución</strong>
						</td>
						<td>
							{{$distincion->institucion}}
						</td>
					</tr>
					<tr>
						<td>
							<strong>Fecha en que se otorgó</strong>
						</td>
						<td>
							{{$distincion->fecha_entrega}}
						</td>
					</tr>
				</table>
				<br>
				<hr>
				<!-- Aumentamos el número de distinciones en 1 y verificamos si ya se han colocado
					 5 distinciones en la hoja de vida y si aún quedan más distinciones pendientes
					 para agregar una página nueva -->
				<?php $numero_distinciones++; ?>
				@if ($numero_distinciones % 5 == 0 && $numero_distinciones < $total_distinciones )
					<!-- Nueva página -->
					<div class="page-break"></div>
					<hr>
				@endif
			@endforeach
		@endif
		
		<!-- Sección de experiencia laboral, tomadas de la variable $experiencia_laboral -->
		<!-- Declaración de una variable para contar el número de experiencias y saber cuando
			 crear una página nueva y otra variable con el número total de experiencias -->
		<?php 
			$numero_experiencias = 0; 
			$total_experiencias = count($experiencia_laboral);
		?>
		@if ($total_experiencias > 0)
			<!-- Nueva página -->
			<div class="page-break"></div>
			<h2 id="datos_encabezado2">Experiencia laboral</h2>
			<hr>
			@foreach ($experiencia_laboral as $laboral)
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>Nombre de la institución o empresa</strong>
						</td>
						<td>
							{{$laboral->institucion}}
						</td>
					</tr>
					<tr>
						<td>
							<strong>Nombre del cargo</strong>
						</td>
						<td>
							{{$laboral->cargo}}
						</td>
					</tr>
					<tr>
						<td>
							<strong>Función principal</strong>
						</td>
						<td>
							{{$laboral->funcion}}
						</td>
					</tr>
					<tr>
						<td>
							<strong>Tipo de vinculación</strong>
						</td>
						<td>
							{{$laboral->tipo_vinculacion}}
						</td>
					</tr>
				</table>
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>¿En curso?</strong>
						</td>
						<td>
							@if ($laboral->en_curso == 1)
								Sí
							@else
								No
							@endif
						</td>
						<td>
							<strong>Fecha de inicio</strong>
						</td>
						<td>
							{{$laboral->fecha_inicio}}
						</td>
						@if ($laboral->en_curso == 0)
							<td>
								<strong>Fecha de finalización</strong>
							</td>
							<td>
								{{$laboral->fecha_finalizacion}}
							</td>
						@endif
					</tr>
				</table>
				<br>
				<hr>
				<!-- Aumentamos el número de experiencias en 1 y verificamos si ya se han colocado
					 4 experiencias en la hoja de vida y si aún quedan más experiencias pendientes
					 para agregar una página nueva -->
				<?php $numero_experiencias++; ?>
				@if ($numero_experiencias % 4 == 0 && $numero_experiencias < $total_experiencias)
					<!-- Nueva página -->
					<div class="page-break"></div>
					<hr>
				@endif
			@endforeach
		@endif
		
		<!-- Sección de experiencia docente, tomadas de la variable $experiencia_docente -->
		<!-- Declaración de una variable para contar el número de experiencias y saber cuando
			 crear una página nueva y otra variable con el número total de experiencias -->
		<?php 
			$numero_experiencias = 0; 
			$total_experiencias = count($experiencia_docente);
		?>
		@if ($total_experiencias > 0)
			<!-- Nueva página -->
			<div class="page-break"></div>
			<h2 id="datos_encabezado2">Experiencia docente</h2>
			<hr>
			<br>
			@foreach ($experiencia_docente as $docente)
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>Nombre de la institución</strong>
						</td>
						<td>
							{{$docente->institucion}}
						</td>
					</tr>
					<tr>
						<td>
							<strong>Dedicación</strong>
						</td>
						<td>
							{{$docente->dedicacion}}
						</td>
					</tr>
					@if (!$docente->area==null)
					<tr>
						<td>
							<strong>Áreas de trabajo</strong>
						</td>
						<td>
							{{$docente->area}}
						</td>
					</tr>
					@endif
				</table>
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>¿En curso?</strong>
						</td>
						<td>
							@if ($docente->en_curso == 1)
								Sí
							@else
								No
							@endif
						</td>
						<td>
							<strong>Fecha de inicio</strong>
						</td>
						<td>
							{{$docente->fecha_inicio}}
						</td>
						@if ($docente->en_curso == 0)
							<td>
								<strong>Fecha de finalización</strong>
							</td>
							<td>
								{{$docente->fecha_finalizacion}}
							</td>
						@endif
					</tr>
				</table>
				<!-- La información de las asignaturas impartidas se almacena en la base de datos en formato
					 JSON, por lo tanto es necesario primero pasarlo a un array asociativo para manipular
					 los datos -->
				<?php $asignaturas = json_decode($docente->asignaturas, true); ?>
				<!-- En base al array $asignaturas se construye una tabla de asignaturas impartidas -->
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>Asignatura</strong>
						</td>
						<td>
							<strong>Intensidad (horas/semana)</strong>
						</td>
					</tr>
					@foreach($asignaturas as $asignatura)
						<tr>
							<td>
								{{$asignatura["nombre"]}}
							</td>
							<td>
								{{$asignatura["intensidad"]}}
							</td>
						</tr>
					@endforeach
				</table>
				<br>
				<hr>
				<!-- Dada la variabilidad en la longitud de la información que puede ser agregada como
					 experiencia docente, se decide que cada experiencia ocupará una página completa.
					 El campo "áreas de trabajo" puede contener mucho texto, así como también el docente
					 pudo haber estado a cargo de 3 o más asignaturas durante su vinculación -->
				<?php $numero_experiencias++; ?>
				@if ($numero_experiencias < $total_experiencias)
					<!-- Nueva página -->
					<div class="page-break"></div>
					<hr>
				@endif
			@endforeach
		@endif
		
		<!-- Sección de experiencia investigativa, tomadas de la variable $experiencia_investigativa -->
		<!-- Declaración de una variable para contar el número de experiencias y saber cuando
			 crear una página nueva y otra variable con el número total de experiencias -->
		<?php 
			$numero_experiencias = 0; 
			$total_experiencias = count($experiencia_investigativa);
		?>
		@if ($total_experiencias > 0)
			<!-- Nueva página -->
			<div class="page-break"></div>
			<h2 id="datos_encabezado2">Experiencia investigativa</h2>
			<hr>
			<br>
			@foreach ($experiencia_investigativa as $investigativa)
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>Nombre del proyecto</strong>
						</td>
						<td>
							{{$investigativa->proyecto}}
						</td>
					</tr>
				</table>
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>Nombre de la institucion</strong>
						</td>
						<td>
							{{$investigativa->institucion}}
						</td>
						<td>
							<strong>País</strong>
						</td>
						<td>
							{{$investigativa->pais}}
						</td>
					</tr>
				</table>
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>Área del proyecto</strong>
						</td>
						<td>
							{{$investigativa->area_proyecto}}
						</td>
					</tr>
					@if(!$investigativa->funcion_principal==null)
						<tr>
							<td>
								<strong>Funciones principales</strong>
							</td>
							<td>
								{{$investigativa->funcion_principal}}
							</td>
						</tr>
					@endif
				</table>
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>¿En curso?</strong>
						</td>
						<td>
							@if ($investigativa->en_curso == 1)
								Sí
							@else
								No
							@endif
						</td>
						<td>
							<strong>Fecha de inicio</strong>
						</td>
						<td>
							{{$investigativa->fecha_inicio}}
						</td>
						@if ($investigativa->en_curso == 0)
							<td>
								<strong>Fecha de finalización</strong>
							</td>
							<td>
								{{$investigativa->fecha_finalizacion}}
							</td>
						@endif
					</tr>
				</table>
				<br>
				<hr>
				<!-- Aumentamos el número de experiencias en 1 y verificamos si ya se han colocado
					 3 experiencias en la hoja de vida y si aún quedan más experiencias pendientes
					 para agregar una página nueva -->
				<?php $numero_experiencias++; ?>
				@if ($numero_experiencias % 3 == 0 && $numero_experiencias < $total_experiencias )
					<!-- Nueva página -->
					<div class="page-break"></div>
					<hr>
				@endif
			@endforeach
		@endif
		
		<!-- Sección de producciones intelectual, tomadas de la variable $produccion_intelectual -->
		<!-- Declaración de una variable para contar el número de producciones y saber cuando
			 crear una página nueva y otra variable con el número total de producciones -->
		<?php 
			$numero_producciones = 0;
			$produccion_pagina_libro_capitulo = 0;
			$produccion_pagina_articulo_patente = 0;
			$total_producciones = count($produccion_intelectual);
		?>
		@if ($total_producciones > 0)
			<!-- Nueva página -->
			<div class="page-break"></div>
			<h2 id="datos_encabezado2">Producción intelectual</h2>
			<hr>
			<br>
			@foreach ($produccion_intelectual as $produccion)
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>Tipo de producción intelectual</strong>
						</td>
						<td>
							{{$produccion->tipo_produccion}}
						</td>
					</tr>
				</table>
				@if($produccion->tipo_produccion=="Artículo en revistas indexadas")
					<table class="tabla_datos">
						<tr>
							<td>
								<strong>Título del artículo</strong>
							</td>
							<td>
								{{$produccion->nombre_produccion}}
							</td>
							<td>
								<strong>Nombre de la revista</strong>
							</td>
							<td>
								{{$produccion->revista}}
							</td>
						</tr>
						<tr>
							<td>
								<strong>Autor(es)</strong>
							</td>
							<td>
								{{$produccion->autor}}
							</td>
							<td>
								<strong>Tipo de artículo</strong>
							</td>
							<td>
								{{$produccion->tipo_articulo}}
							</td>
						</tr>
					</table>
					<table class="tabla_datos">
						<tr>
							<td>
								<strong>Clasificación (Colciencias)</strong>
							</td>
							@if (!$produccion->clasificacion_revista==null)
								<td>
									{{$produccion->clasificacion_revista}}
								</td>
							@else
								<td>
									N/A
								</td>
							@endif
							<td>
								<strong>ISSN</strong>
							</td>
							<td>
								{{$produccion->ISSN}}
							</td>
							<td>
								<strong>Páginas</strong>
							</td>
							<td>
								{{$produccion->paginas}}
							</td>
						</tr>
						<tr>
							<td>
								<strong>Año de publicación</strong>
							</td>
							<td>
								{{$produccion->año}}
							</td>
							<td>
								<strong>Volumen</strong>
							</td>
							@if (!$produccion->volumen_revista==null)
								<td>
									{{$produccion->volumen_revista}}
								</td>
							@else
								<td>
									N/A
								</td>
							@endif
							<td>
								<strong>Idioma</strong>
							</td>
							<td>
								{{$produccion->idioma}}
							</td>
						</tr>
					</table>
					<?php $produccion_pagina_articulo_patente++; ?>
				@elseif($produccion->tipo_produccion=="Libro")
					<table class="tabla_datos">
						<tr>
							<td>
								<strong>Título del libro</strong>
							</td>
							<td>
								{{$produccion->nombre_produccion}}
							</td>
							<td>
								<strong>Editorial</strong>
							</td>
							<td>
								{{$produccion->editorial}}
							</td>
						</tr>
						<tr>
							<td>
								<strong>Autor(es)</strong>
							</td>
							<td>
								{{$produccion->autor}}
							</td>
							<td>
								<strong>ISBN</strong>
							</td>
							@if (!$produccion->ISBN==null)
								<td>
									{{$produccion->ISBN}}
								</td>
							@else
								<td>
									N/A
								</td>
							@endif
						</tr>
					</table>
					<table class="tabla_datos">
						<tr>
							<td>
								<strong>Año de publicación</strong>
							</td>
							<td>
								{{$produccion->año}}
							</td>
							<td>
								<strong>Páginas</strong>
							</td>
							<td>
								{{$produccion->paginas}}
							</td>
							<td>
								<strong>Idioma</strong>
							</td>
							<td>
								{{$produccion->idioma}}
							</td>
						</tr>
					</table>
					<?php $produccion_pagina_libro_capitulo++; ?>
				@elseif($produccion->tipo_produccion=="Capitulo de libro")
					<table class="tabla_datos">
						<tr>
							<td>
								<strong>Título del capítulo</strong>
							</td>
							<td>
								{{$produccion->nombre_produccion}}
							</td>
							<td>
								<strong>Título del libro</strong>
							</td>
							<td>
								{{$produccion->nombre_libro}}
							</td>
						</tr>
						<tr>
							<td>
								<strong>Editorial</strong>
							</td>
							<td>
								{{$produccion->editorial}}
							</td>
							<td>
								<strong>ISBN</strong>
							</td>
							@if (!$produccion->ISBN==null)
								<td>
									{{$produccion->ISBN}}
								</td>
							@else
								<td>
									N/A
								</td>
							@endif
						</tr>
					</table>
					<table class="tabla_datos">
						<tr>
							<td>
								<strong>Año de publicación</strong>
							</td>
							<td>
								{{$produccion->año}}
							</td>
							<td>
								<strong>Páginas</strong>
							</td>
							<td>
								{{$produccion->paginas}}
							</td>
							<td>
								<strong>Idioma</strong>
							</td>
							<td>
								{{$produccion->idioma}}
							</td>
						</tr>
					</table>
					<?php $produccion_pagina_libro_capitulo++; ?>
				@else
					<table class="tabla_datos">
						<tr>
							<td>
								<strong>Nombre de la patente</strong>
							</td>
							<td>
								{{$produccion->nombre_produccion}}
							</td>
							<td>
								<strong>Tipo de patente</strong>
							</td>
							<td>
								{{$produccion->tipo_patente}}
							</td>
						</tr>
					</table>
					<table class="tabla_datos">
						<tr>
							<td>
								<strong>Descripción</strong>
							</td>
							<td>
								{{$produccion->descripcion_patente}}
							</td>
						</tr>
					</table>
					<table class="tabla_datos">
						<tr>
							<td>
								<strong>Número de patente</strong>
							</td>
							<td>
								{{$produccion->numero_patente}}
							</td>
							<td>
								<strong>Entidad que registra</strong>
							</td>
							<td>
								{{$produccion->entidad_patente}}
							</td>
						</tr>
					</table>
					<table class="tabla_datos">
						<tr>
							<td>
								<strong>Año</strong>
							</td>
							<td>
								{{$produccion->año}}
							</td>
							<td>
								<strong>País</strong>
							</td>
							<td>
								{{$produccion->pais}}
							</td>
							<td>
								<strong>Idioma</strong>
							</td>
							<td>
								{{$produccion->idioma}}
							</td>							
						</tr>
					</table>
					<?php $produccion_pagina_articulo_patente++; ?>
				@endif
				<br>
				<hr>
				<!-- Aumentamos el número de producciones en 1. Una página tiene espacio para colocar
					 producciones en alguna de las siguientes distribuciones:
					 - 4 libros/capitulos de libro
					 - 3 artículos de revista/patentes
					 - 3 libros/capitulos de libro y 1 artículos de revista/patentes
					 - 2 artículos de revista/patentes y 2 libros/capitulos
					 Cuando alguna de esas distribuciones se complete, es necesario crear una nueva página -->
				<?php $numero_producciones++; ?>
				@if ($produccion_pagina_articulo_patente == 3 && $numero_producciones < $total_producciones)
					<!-- Nueva página -->
					<div class="page-break"></div>
					<hr>
					<?php 
						$produccion_pagina_articulo_patente = 0;
						$produccion_pagina_libro_capitulo = 0;
					?>
				@elseif ($produccion_pagina_articulo_patente == 1 && $produccion_pagina_libro_capitulo == 3 
				&& $numero_producciones < $total_producciones)
					<!-- Nueva página -->
					<div class="page-break"></div>
					<hr>
					<?php 
						$produccion_pagina_articulo_patente = 0;
						$produccion_pagina_libro_capitulo = 0;
					?>
				@elseif ($produccion_pagina_libro_capitulo == 4 && $numero_producciones < $total_producciones)
					<!-- Nueva página -->
					<div class="page-break"></div>
					<hr>
					<?php 
						$produccion_pagina_articulo_patente = 0;
						$produccion_pagina_libro_capitulo = 0;
					?>
				@elseif ($produccion_pagina_libro_capitulo == 2 && $produccion_pagina_articulo_patente == 2
				&& $numero_producciones < $total_producciones)
					<!-- Nueva página -->
					<div class="page-break"></div>
					<hr>
					<?php 
						$produccion_pagina_articulo_patente = 0;
						$produccion_pagina_libro_capitulo = 0;
					?>	
				@endif
			@endforeach
		@endif
		
		<!-- Sección de certificados de idiomas, tomadas de la variable $idiomas_certificados -->
		<!-- Declaración de una variable para contar el número de certificados y saber cuando
			 crear una página nueva y otra variable con el número total de certificados -->
		<?php 
			$numero_idiomas = 0;
			$total_idiomas = count($idiomas_certificados);
		?>
		@if ($total_idiomas > 0)
			<!-- Nueva página -->
			<div class="page-break"></div>
			<h2 id="datos_encabezado2">Idiomas certificados</h2>
			<hr>
			<br>
			@foreach ($idiomas_certificados as $idioma_certificado)
				<table class="tabla_datos">
					<tr>
						<td>
							<strong>Idioma</strong>
						</td>
						<td>
							{{$idioma_certificado->idioma}}
						</td>
						<td>
							<strong>¿Es su idioma nativo?</strong>
						</td>
						@if ($idioma_certificado->nativo == 1)
						<td>
							Sí
						</td>
						@else
							<td>
								No
							</td>
						@endif
					</tr>
					<tr>
						<td>
							<strong>Nombre del certificado</strong>
						</td>
						@if (!$idioma_certificado->certificado==null)
							<td>
								{{$idioma_certificado->certificado}}
							</td>
						@else
							<td>
								N/A
							</td>
						@endif
						<td>
							<strong>Puntaje</strong>
						</td>
						@if (!$idioma_certificado->puntaje==null)
							<td>
								{{$idioma_certificado->puntaje}}
							</td>
						@else
							<td>
								N/A
							</td>
						@endif
					</tr>
				</table>
				<br>
				<hr>
				<!-- Aumentamos el número de idiomas en 1 y verificamos si ya se han colocado
					 6 idiomas en la hoja de vida y si aún quedan más idiomas pendientes
					 para agregar una página nueva -->
				<?php $numero_idiomas++; ?>
				@if ($numero_idiomas % 6 == 0 && $numero_idiomas < $total_idiomas )
					<!-- Nueva página -->
					<div class="page-break"></div>
					<hr>
				@endif
			@endforeach
		@endif
	</body>
</html>