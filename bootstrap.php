<?php include "cabecalho.php"; ?> 


 <div class="row">
    <div class="col-4"></div>
    <div class="col-4">  
        
        <div class="alert alert-success" role="alert">
            Cadastrado com sucesso
        </div>

    </div>
    <div class="col-4"></div>
</div>

<div class="row">
    <div class="col-2"></div>
    <div class="col-8">
        <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            </tr>
            <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            </tr>
            <tr>
            <th scope="row">3</th>
            <td colspan="2">Larry the Bird</td>
            <td>@twitter</td>
            </tr>
        </tbody>
        </table>
    </div>
    <div class="col-2"></div>
    </div>

<form>
  <div class="mb-3">
    <label>Email</label>
    <input type="email" class="form-control">
    <div class="form-text">Digite um email para acessar o sistema</div>
  </div>
  <div class="mb-3">
    <label>Senha</label>
    <input type="password" class="form-control">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input">
    <label class="form-check-label"> Deseja receber SMS enchendo o seu saco com promoções ?</label>
  </div>
  <button type="submit" class="btn btn-success">Enviar o cadastro</button>
</form>


<button type="button" class="btn btn-primary">Salvar cadastro</button>
<button type="button" class="btn btn-secondary">Secondary</button>
<button type="button" class="btn btn-success">Success</button>
<button type="button" class="btn btn-danger">Danger</button>
<button type="button" class="btn btn-warning">Warning</button>
<button type="button" class="btn btn-info">Info</button>
<button type="button" class="btn btn-light">Light</button>
<button type="button" class="btn btn-dark">Dark</button>



<button type="button" class="btn btn-link">Link</button>

<a href="www.google.com.br" class="btn btn-primary"> Acesse o Google aqui </a>


</div>
    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>