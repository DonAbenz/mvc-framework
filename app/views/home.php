<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>
</head>

<body>
   <h1><?= $message; ?></h1>

   <table>
      <thead>
         <th>name</th>
         <th>email</th>
      </thead>
      <tbody>
         <?php foreach ($users as $user) : ?>
            <tr>
               <td><?= $user['name'] ?></td>
               <td><?= $user['email'] ?></td>
            </tr>
         <?php endforeach ?>
      </tbody>
   </table>
</body>

</html>