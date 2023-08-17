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
            <h5 class="card-title fw-semibold mb-4">Página de simulação</h5>
            <p class="mb-0">This is a sample page </p>
          </div>
        </div>
      </div>
    </div>


    {% include "parts/footer.php" %}

{% endblock %}