<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html lang="pt">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheed" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

	<title>Prova PHP IST</title>
</head>

<body>
	<div class="container">
		<?php $this->load->view("template/menu"); ?>
		<hr>
		<?php $this->load->view('template/alert'); ?>
		<div class="col-md-6">
			<h3><span id="tipo">Cadastro</span> de Conta</h3>
			<form action="<?= base_url("cadastro_conta_db") ?>" method="POST">
				<input type="hidden" name="conta_id" id="edit" value="">
				<div class="form-group">
					<select name="pessoa_id" id="pessoa_id" class="form-control" required>
						<option value="">-- Selecione uma pessoa --</option>
						<?php foreach ($pessoas as $p) : ?>
							<option value="<?= $p->id ?>"><?= $p->nome . ' - ' . $p->cpf ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<label for="">Número da conta:</label>
					<input type="number" name="conta" id="conta" class="form-control" required>
				</div>

				<button class="btn btn-lg btn-info">Salvar</button>

			</form>
		</div>
		<hr>

		<table class="table" id="myTable">
			<thead>
				<tr>
					<th scope="col">Nome</th>
					<th scope="col">CPF</th>
					<th scope="col">Número da Conta</th>
					<th>Editar</th>
					<th>Remover</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($contas as $c) : ?>
					<tr>
						<td><?= $c->nome ?></td>
						<td><?= formata_cpf_cnpj($c->cpf) ?></td>
						<td><?= $c->conta ?></td>
						<td>
							<button type="button" class="btn btn-success editar" data-conta="<?= $c->conta ?>" data-pessoa-id="<?= $c->pessoa_id ?>" value="<?= $c->conta_id ?>">
								Editar
							</button>
						</td>
						<td>
							<button type="button" class="btn btn-danger excluir" data-toggle="modal" data-target="#exampleModal" value="<?= $c->conta_id ?>">
								Excluir
							</button>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>

	<!-- Modal Exclusão -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tem certeza que deseja excluir essa conta?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-footer">
					<form action="<?= base_url("excluir_conta") ?>" method="POST">
						<input type="hidden" name="id_pessoa" id="id_pessoa" value="">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
						<button type="submit" class="btn btn-danger">Excluir</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- / Modal Exclusão -->

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#myTable').DataTable({
				"language": {
					"sEmptyTable": "Nenhum registro encontrado",
					"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
					"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
					"sInfoFiltered": "(Filtrados de _MAX_ registros)",
					"sInfoPostFix": "",
					"sInfoThousands": ".",
					"sLengthMenu": "_MENU_ resultados por página",
					"sLoadingRecords": "Carregando...",
					"sProcessing": "Processando...",
					"sZeroRecords": "Nenhum registro encontrado",
					"sSearch": "Pesquisar",
					"oPaginate": {
						"sNext": "Próximo",
						"sPrevious": "Anterior",
						"sFirst": "Primeiro",
						"sLast": "Último"
					}
				}
			})

			$(".excluir").click(function() {
				$("#id_pessoa").val(this.value)
			})

			$(".editar").click(function() {
				$("#edit").val(this.value)
				$("#pessoa_id").val($(this).data("pessoa-id"))
				$("#pessoa_id").attr('readonly', true);
				$("#conta").val($(this).data("conta"))
				$("#tipo").text("Edição")
			})
		});
	</script>

</body>

</html>