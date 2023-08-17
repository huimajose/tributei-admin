<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{% block title %} Criar conta - Tributei{% endblock %}</title>

    {% block stylesheets %}
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    {% endblock%}
</head>
<body>
    {% block body %}
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="assets/images/logos/dark-logo.svg" width="180" alt="">
                </a>
                <p class="text-center">Comece criando a sua conta</p>
                <form>
                  <div class="mb-3">
                    <label for="exampleInputtext1" class="form-label">Nome completo</label>
                    <input type="text" name="nome" placeholder="Como chamaremos você..." class="form-control" id="exampleInputtext1" aria-describedby="textHelp">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" placeholder="Digite o email para acessar a sua conta..." class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" placeholder="Digite a senha para acessar a sua conta..." class="form-control" id="exampleInputPassword1">
                  </div>
                 
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Criar conta</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Já tem uma conta?</p>
                    <a class="text-primary fw-bold ms-2" href="login">Entrar</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {% endblock %}


{% block javascript %}
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sidebarmenu.js"></script>
<script src="assets/js/app.min.js"></script>
<script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="assets/libs/simplebar/dist/simplebar.js"></script>
<script src="assets/js/dashboard.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
{% endblock %}
</body>
</html>
