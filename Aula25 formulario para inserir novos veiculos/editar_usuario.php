<?php
	session_start();
	if(isset($_SESSION["numlogin"])){
		$n1=$_GET["num"];
		$n2=$_SESSION["numlogin"];
		if($n1!=$n2){
			echo "<p>Login n�o efetuado</p>";
			exit;
		}
	}else{
		echo "<p>Login n�o efetuado</p>";
		exit;
	}
	include "conexao.inc";
?>
<!doctype html>
<html lang="pt-br">
	<head>
		<title>CFB Ve�culos</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="estilos.css"/> 
	</head>
	<body>
	
		<header>
			<?php
				include "topo.php";
			?>
		</header>

		<section id="main">
		
			<a href="gerenciamento.php?num=<?php echo $n1; ?>" target="_self" class="btmenu">voltar</a>
			<h1>Editar Usu�rio</h1>
			
			<form name="f_sel_colaborador" action="editar_usuario.php" class="f_colaborador" method="get">
				<input type="hidden" name="num" value="<?php echo $n1; ?>">
				<label>Selecione o colaborador</label>
				<select name="f_colaboradores" size="10">
					<?php
						$sql="SELECT * FROM tb_colaboradores";
						$col=mysqli_query($con,$sql);
						$total_col=mysqli_num_rows($col);
						while($exibe=mysqli_fetch_array($col)){
							echo "<option value='".$exibe['id_colaborador']."'>".$exibe['nome']."</option>";
						}
					?>
				</select>
				<input type="submit" name="f_bt_sel_colaborador" class="btmenu" value="editar">
			</form>
			
			<?php
			
				if(isset($_GET["f_colaboradores"])){
					$vid=$_GET["f_colaboradores"];
					$sql="SELECT * FROM tb_colaboradores WHERE id_colaborador=$vid";
					$res=mysqli_query($con,$sql);
					$exibe=mysqli_fetch_array($res);
					if($exibe >= 1){
						echo "
							<form name='f_edita_colaborador' action='editar_usuario.php' class='f_colaborador' method='get'>
								<input type='hidden' name='num' value=$n1>
								<input type='hidden' name='id' value='".$exibe['id_colaborador']."'>
								<label>Nome</label>
								<input type='text' name='f_nome' size='50' maxlength='50' required='required' value='".$exibe['nome']."'>
								<label>Username</label>
								<input type='text' name='f_user' size='50' maxlength='50' required='required' value='".$exibe['username']."'>
								<label>Senha</label>
								<input type='text' name='f_senha' size='50' maxlength='50' required='required' value='".$exibe['senha']."'>
								<label>Acesso</label>
								<input type='text' name='f_acesso' size='50' maxlength='50' required='required' value='".$exibe['acesso']."' pattern='[0-1]+$' placeholder='0 ou 1'>
								<input type='submit' name='f_bt_edita_colaborador' class='btmenu' value='gravar'>
							</form>
						";
					}else{
						echo "<p>Erro ao selecionar colaborador</p>";
					}
				}
				
				if(isset($_GET["f_bt_edita_colaborador"])){
					$vid=$_GET["id"];
					$vnome=$_GET["f_nome"];
					$vuser=$_GET["f_user"];
					$vsenha=$_GET["f_senha"];
					$vacesso=$_GET["f_acesso"];
					
					$sql="UPDATE tb_colaboradores SET nome='$vnome', username='$vuser', senha='$vsenha', acesso='$vacesso' WHERE id_colaborador=$vid";
					$res=mysqli_query($con,$sql);
					$linhas=mysqli_affected_rows($con);
					
					if($linhas >= 1){
						header('Location:editar_usuario.php?num='.$n1);
					}else{
						echo "<p>Erro ao atualizar colaborador</p>";
					}	
				}
			
			?>
				
		</section>
		
	</body>
</html> 