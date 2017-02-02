
<div class="contain">
    <img src="<?php echo base_url()?>/assets/images/profiledefault.png" alt="profile"/>
    <h2>Hello <?php echo ucfirst($this->session->userdata('first_name')); ?></h2> 

  <table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th>My Details</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th>First Name</th>
      <th><?php echo $this->session->userdata('first_name') ?></th>
    </tr>
    <tr>
      <td>Last Name</td>
      <td><?php echo $this->session->userdata('last_name') ?></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><?php echo $this->session->userdata('email') ?></td>
    </tr>
    <tr>
      <td>Password</td>
      <td>*********</td>
    </tr>
  </tbody>
</table>   
</div>

