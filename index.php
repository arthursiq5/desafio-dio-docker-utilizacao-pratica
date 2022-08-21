<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exemplo PHP</title>
</head>
<body>

<?php
ini_set("display_errors", 1);
header('Content-Type: text/html; charset=iso-8859-1');

function getConnection() {
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $database = "meubanco";
  
  // Criar conexão
  
  
  $connection = new mysqli($servername, $username, $password, $database);
  
  /* check connection */
  if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
  }
  return $connection;
}

function processForm($connection, $data) {
  $host_name = gethostname();
  
  
  $query = "INSERT INTO dados (id, nome, sobrenome, endereco, cidade, host)";
  $query .= " VALUES (DEFAULT , '" . $data['nome'] . "', '" . $data['sobrenome'] . "', '" . $data['endereco'] . "', '" . $data['cidade'] . "','$host_name')";
  
  
  if ($connection->query($query) === TRUE) {
    echo "New record created successfully<br>";
  } else {
    echo "Error: " . $connection->error;
  }
}

function getData($connection) {
  $sql = 'SELECT id, nome, sobrenome, endereco, cidade FROM dados';
  $result = $connection->query($sql);
  $rows = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
  }
  return $rows;
}

$connection = getConnection();
if (!empty($_POST)) {
  processForm($connection, $_POST);
}


echo 'Versao Atual do PHP: ' . phpversion() . '<br>';

?>

  <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    <div style="margin-bottom: 20px;">
      <label for="nome"></label>
      <input type="text" name="nome" id="nome">
    </div>
    <div style="margin-bottom: 20px;">
      <label for="sobrenome"></label>
      <input type="text" name="sobrenome" id="sobrenome">
    </div>
    <div style="margin-bottom: 20px;">
      <label for="endereco"></label>
      <input type="text" name="endereco" id="endereco">
    </div>
    <div style="margin-bottom: 20px;">
      <label for="cidade"></label>
      <input type="text" name="cidade" id="cidade">
    </div>
    <button style="box-shadow: 0 0 10px 5px green;" type="submit">Enviar</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>id</th>
        <th>nome</th>
        <th>sobrenome</th>
        <th>endere&ccedil;o</th>
        <th>cidade</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach (getData($connection) as $row): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['nome'] ?></td>
          <td><?= $row['sobrenome'] ?></td>
          <td><?= $row['endereco'] ?></td>
          <td><?= $row['cidade'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</body>
</html>

