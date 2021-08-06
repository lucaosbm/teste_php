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
		<span id="success"></span>
		<div class="col-md-6">
			<h3><span id="tipo">Cadastro</span> de Movimentação</h3>
			<form name="form" method="POST" action="">
				<input type="hidden" name="conta_id" id="edit" value="">
				<div class="form-group">
					<label for="">Pessoa</label>
					<select name="pessoa_id" id="pessoas" class="form-control" required>
						<option value="">-- Selecione uma pessoa --</option>
						<?php foreach ($pessoas as $p) : ?>
							<option value="<?= $p->id ?>"><?= $p->nome . ' - ' . $p->cpf ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<label for="">Número da Conta</label>
					<select name="conta" id="contas" class="form-control">
					</select>
				</div>
				<div class="form-group">
					<label for="">Valor:</label>
					<input name="valor" id="valor" type="number" class="form-control" min="0" step="1">
				</div>
				<div class="form-group">
					<label for="">Depositar/Retirar:</label>
					<select name="opcao" id="opcao" class="form-control">
						<option value="dep">Depositar</option>
						<option value="ret">Retirar</option>
					</select>
				</div>
				<button class="btn btn-lg btn-info" id="update">Salvar</button>
			</form>
		</div>
		<hr>
		<h4>Extrato</h4>
		<table class="table" id="myTable">
			<thead>
				<tr>
					<th scope="col">Data</th>
					<th scope="col">Valor</th>
				</tr>
			</thead>
			<tbody id="extrato">
			</tbody>
		</table>
		<div id="saldo_div">
		</div>
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

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

	<script>
		$(document).ready(function() {
			/**
			 * Carrega as contas no select via AJAX quando uma pessoa é selecionada
			 */
			$("#pessoas").change(function() {
				$("#contas").empty();
				$("#extrato").text('');
				let opcao = $('<option value="">-- Selecione a conta --</option>');
				$('#contas').append(opcao);
				id = this.value;
				$.ajax({
					type: "GET",
					dataType: 'json',
					url: "<?= base_url('ajax_contas'); ?>/" + id,
					encode: true,
					success: function(data) {
						if (data != '') {
							$(data).each(function(dados) {
								let opcao = $('<option value="' + data[dados].id + '">' + data[dados].conta + ' - Saldo: R$ <span id="saldo-select">' + data[dados].saldo + '</span></option>');
								$('#contas').append(opcao);
							})
						}
					}
				})
			})
			/**
			 * Carrega o extrato, adiciona a nova movimentação e atualiza o saldo
			 */
			$("#contas").change(function() {
				$("#extrato").text('')
				let saldo = 0
				id = this.value;
				$.ajax({
					type: "GET",
					dataType: 'json',
					url: "<?= base_url('ajax_extrato'); ?>/" + id,
					encode: true,
					success: function(data) {
						if (data) {
							$(data).each(function(dados) {
								if (data[dados].tipo === '-')
									var cor = ' class="text-danger"'
								else
									var cor = ''
								let show = '<tr><td>' + data[dados].datetime + '</td><td' + cor + '>' + data[dados].tipo + data[dados].valor + '</td></tr>'
								$("#extrato").append(show)
								if (data[dados].tipo == '+')
									saldo = (parseInt(data[dados].valor) + parseInt(saldo))
								else
									saldo = (parseInt(saldo) - parseInt(data[dados].valor))
							})
							$("#saldo_div").text('')
							$("#saldo_div").append('<b>Saldo: R$ <span id="saldo">' + saldo + '</span>.00</b>')
						}
					}
				})
			})
			/**
			 * Faz o cadastro via AJAX
			 */
			$("#update").click(function(e) {
				e.preventDefault()
				let conta = $("#contas").val()
				valor = $("#valor").val()
				opcao = $("#opcao").val()
				if (!conta || !valor) {
					alert("Todos os campos devem ser preenchidos!")
				} else {
					dataString = 'conta=' + conta + '&valor=' + valor + '&opcao=' + opcao;

					if (opcao == 'ret') {
						$.ajax({
							type: "POST",
							url: '<?= base_url("verifica_saldo") ?>',
							data: {
								'id': conta,
								'valor': valor
							},
							success: function(msg) {
								if (msg) {
									ajaxMovimentacao()
								} else {
									alert("Saldo insuficiente!")
								}
							}
						})
					} else {
						ajaxMovimentacao()
					}
				}
			})
			/**
			 * Usado no método acima em duas situações
			 */
			function ajaxMovimentacao() {
				$.ajax({
					type: 'POST',
					data: dataString,
					url: '<?= base_url("atualiza_saldo") ?>',
					success: function(msg) {
						adicionaMovimentacao(valor, opcao)
						//mostra msg de sucesso caso a transaction retorne true
						if (msg)
							$("#success").append('<div class="alert alert-success alert-dismissible"><b>Movimentação cadastrada com sucesso!</b><button type="button" class="close" data-dismiss="alert">&times;</button></div>')
					}
				})
			}
			/*
			/* Adiciona uma nova linha no extrato com a nova movimentação cadastrada
			*/
			function adicionaMovimentacao(valor, opcao) {
				if (opcao === 'ret') {
					var cor = ' class="text-danger"'
					var op = '-'
					var saldo = parseInt($("#saldo").text()) - parseInt(valor)
					$("#saldo").text(saldo)
					$("#saldo-select").text(saldo + '.00')
				} else {
					var cor = ''
					var op = '+'
					var saldo = parseInt($("#saldo").text()) + parseInt(valor)
					$("#saldo").text(saldo)
					$("#saldo-select").text(saldo + '.00')
				}
				let dt = pegaDataHora()
				let show = '<tr><td>' + dt + '</td><td' + cor + '>' + op + valor + '</td></tr>'
				$("#extrato").append(show)
			}
			/*
			/* Retorna a data/hora atual
			*/
			function pegaDataHora() {
				// Obtém a data/hora atual
				let data = new Date();

				// Guarda cada pedaço em uma variável
				let dia = ("0" + data.getDate()).slice(-2);
				let mes = ("0" + (data.getMonth() + 1)).slice(-2);
				let ano = data.getFullYear();
				let hora = data.getHours();
				let min = data.getMinutes();

				// Formata a data e a hora
				let str_data = dia + '/' + mes + '/' + ano;
				let str_hora = hora + ':' + min

				// Retorna o resultado
				let datetime = str_data + ' ' + str_hora;
				return datetime;
			}

			$('#valor').keyup(function(e) {
				$("#valor").val(removePonto($(this).val()))
			})

			function removePonto(str) {
				return str.replace(".", "")
			}
		})
	</script>

</body>

</html>