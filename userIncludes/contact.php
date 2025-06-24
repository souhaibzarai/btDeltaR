<div class="contact w-100" id="contact">
  <h1 class="part-title">Contact Us</h1>
  <div class="content">
    <div class="formContent">
      <form method="post" class="p-3">
        <!-- for firstName -->
        <div class="inputs firstName">
          <label for="fName">First Name: </label>
          <input type="text" name="fName" id="fName" value="">
        </div>
        <!-- for email -->
        <div class="inputs email">
          <label for="email">Email: </label>
          <input type="text" name="email" id="email" value="" required>
        </div>
        <!-- for Description -->
        <div class="inputs description">
          <label for="desc">Description: </label>
          <textarea name="desc" id="desc" rows="5" class="description"></textarea>
        </div>
        <div class="submit mt-3">
          <input type="submit" class="buttonContact" value="Contact!" name="submit">
        </div>
      </form>
    </div>
  </div>
</div>
<?php
if (isset($_POST['submit'])) {
  $name = $_POST['fName'];
  $email = $_POST['email'];
  $desc = $_POST['desc'];

  $sql = 'insert into contact(name, email, description) VALUES(?,?,?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $name, $email, $desc);
  $stmt->execute();
  $stmt->close();

  echo '<script>
  alert("The message has sent successfully");
  window.location.href = "./";
  
  
  </script>
  ';


  exit;

}
?>