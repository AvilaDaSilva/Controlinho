<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
	</head>
	<body>
		<h2>Usuários</h2>
		<button onclick="location.href='/usuarios/save'">Novo usuário</button>
		<table>
			<thead>
				<tr>
					<th>Nome</th><th>Email</th><th>Data nascimento</th><th>Perfil</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($usuarios as $usuario){ ?>
					<tr>
						<td><?php echo $usuario['nome']; ?></td>
						<td><?php echo $usuario['email']; ?></td>
						<td><?php echo $usuario['data_nasc']; ?></td>
						<td><?php echo $usuario['perfil']; ?></td>
					</tr>

			<?php } ?>
			</tbody>
		</table>
	</body>
</html>
