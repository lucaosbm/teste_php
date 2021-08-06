<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html lang="pt">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
			<h3><span id="tipo">Cadastro</span> de Pessoa</h3>
			<form action="<?= base_url("cadastro_pessoa") ?>" method="POST">
				<input type="hidden" name="id" id="id" value="">
				<div class="form-group">
					<label for="">Nome: <small class="text-secondary">(Somente letras)</small></label>
					<input type="text" name="nome" id="nome" class="form-control" required pattern="^[^-\s][a-zA-ZÀ-ú ]*">
				</div>
				<div class="form-group">
					<label for="">CPF:</label>
					<input type="text" name="cpf" id="cpf" class="form-control" minlength="11" maxlength="11" required>
				</div>
				<div class="form-group">
					<label for="">Endereço:</label>
					<input type="text" name="endereco" id="endereco" class="form-control" required>
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
					<th scope="col">Endereço</th>
					<th>Editar</th>
					<th>Remover</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($pessoas as $p) : ?>
					<tr>
						<td><?= $p->nome ?></td>
						<td><?= formata_cpf_cnpj($p->cpf) ?></td>
						<td><?= $p->endereco ?></td>
						<td>
							<button type="button" class="btn btn-success editar" data-nome="<?= $p->nome ?>" data-cpf="<?= formata_cpf_cnpj($p->cpf) ?>" data-endereco="<?= $p->endereco ?>" value="<?= $p->id ?>">
								Editar
							</button>
						</td>
						<td>
							<button type="button" class="btn btn-danger excluir" data-toggle="modal" data-target="#exampleModal" value="<?= $p->id ?>">
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
					<h5 class="modal-title" id="exampleModalLabel">Tem certeza que deseja excluir essa pessoa?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-footer">
					<form action="<?= base_url("index.php/excluir_pessoa") ?>" method="POST">
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
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url("assets/js/plugins/jquery.mask.js") ?>"></script>

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

			let $cpf = $("#cpf");
			$cpf.mask('000.000.000-00', {
				reverse: true
			});

			$(".excluir").click(function() {
				$("#id_pessoa").val(this.value)
			})

			$(".editar").click(function() {
				$("#id").val(this.value)
				$("#nome").val($(this).data("nome"))
				$("#cpf").val($(this).data("cpf"))
				$("#endereco").val($(this).data("endereco"))
				$("#tipo").text("Edição")
			})

			$('#nome').keyup(function(e) {
				$("#nome").val(capitalize($(this).val()))
			})

			function capitalize(str) {
				return str.replace(/\w\S*/g, function(txt) {
					return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
				})
			}
		});
	</script>

</body>

</html>