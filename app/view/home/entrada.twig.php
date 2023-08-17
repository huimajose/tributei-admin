{% extends "base.php" %}

{% block title %}Página inicial{% endblock %}

{% block body %}

{% include "parts/right-menu.php" %}



<div class="body-wrapper">
      <!--  Header Start -->
      {% include "parts/header.php" %}
      <!--  Header End -->
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Lançamentos de entradas</h5>
            <form action="login" method="post">
            <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Valor</label>
                    <input type="number" name="valor" class="form-control" id="exampleInputValor">
                  </div>



                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Registar</button>

                  <div class="d-flex align-items-center justify-content-center">
                    
                  </div>
                </form>

                  
          </div>
        </div>
      </div>
    </div>


    {% include "parts/footer.php" %}

{% endblock %}