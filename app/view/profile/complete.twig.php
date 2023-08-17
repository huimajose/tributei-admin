{% extends "base.php" %}

{% block title %}Página inicial{% endblock %}

{% block body %}

{% include "parts/header.php" %}
{% include "parts/right-menu.php" %}


<div class="page-wrapper mt-5" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 ml-5 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="col-md-12 col-lg-10  col-xxl-8 ">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Informações Pessoais</h5>
                                <div class="mb-3">
                                    <label for="exampleInputtext1" class="form-label">Nome completo</label>
                                    <input type="text" name="nome" placeholder="Como chamaremos você..." class="form-control" id="exampleInputtext1" aria-describedby="textHelp">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputtext1" class="form-label">Biografia</label>
                                    <textarea name="bio" placeholder="Conte-nos um pouco sobre você..." class="form-control" id="exampleInputtext1" aria-describedby="textHelp"></textarea>
                                </div>
                                <!-- ... Mais campos ... -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Empresa e Atividade</h5>
                                <div class="mb-3">
                                    <label for="exampleInputEmpresa" class="form-label">Designação da empresa</label>
                                    <input type="text" name="empresa" placeholder="Nome da sua empresa..." class="form-control" id="exampleInputEmpresa">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmpresa" class="form-label">Nº contribuinte</label>
                                    <input type="text" name="nif" placeholder="Numero do contribuinte..." class="form-control" id="exampleInputEmpresa">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmpresa" class="form-label">Morada</label>
                                    <input type="text" name="morada" placeholder="Nos diga onde estão localizados..." class="form-control" id="exampleInputEmpresa">
                                </div>
                                <!-- ... Mais campos ... -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-5 my-5">
                    <div class="card-body">
                        <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                            <img src="assets/images/logos/dark-logo.svg" width="180" alt="">
                        </a>
                        <p class="text-center">Comece criando a sua conta</p>
                        <form>
                            <!-- ... Formulário ... -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% include "parts/footer.php" %}

{% endblock %}
