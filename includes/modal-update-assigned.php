<div id="update-assigned-modal" class="modal">
	<div class="modal-container" tabindex="-1">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Modificar concierto</h3>
				<button type="button" class="fa fa-lg fa-close btn-close close-modal"></button>	
			</div>
			<div class="modal-body">
				<h3>Datos del concierto</h3>
				<table id='update-assigned-table' class='contentTable'>

					<thead>
						<tr>
							<th>Fecha</th>
							<th>Hora</th>
							<th>Género</th>
							<th>Músico/Grupo</th>
							<th>Pago</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
				<form id='update-assigned-concert'>
					<input type="hidden" id="update-assigned-concert-id" name="concert-id">
					<div class="form-crt-row">
						<div class="form-crt-row-sub">
							<label>Fecha</label><input type="text" id="update-assigned-date" name="concert-date" placeholder="dd-mm-aaaa" required/>
						</div><div class="form-crt-row-sub">				
						<label>Hora</label><input type="text" id="update-assigned-time" name="concert-time" placeholder="hh:mm" required/> 
					</div>
				</div><div class="form-crt-row">
				<div class="form-crt-row-sub">
					<label>Género</label><select id="update-assigned-genre" name="genre" required>
					<option value="">Elige un género</option>
					<?php
					$generos = AllGeneros();
					while ($fila = mysqli_fetch_array($generos)) {
						extract($fila);
						echo "<option value='$id_genero'>$nombre</option>";
					}
					?>
				</select>
			</div><div class="form-crt-row-sub">
			<label>Pago</label><input type="text" id="update-assigned-pay" name="pay" placeholder="€" required/></div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button id="submit-update-assigned" class="btn btn-submit">Modificar</button><button class="btn btn-reset close-modal">Cerrar</button>
</div>
</div>
</div>
</div>