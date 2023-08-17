{% extends "base.php" %}

{% block title %}Página inicial{% endblock %}

{% block body %}

{% include "parts/header.php" %}
{% include "parts/right-menu.php" %}

<div class="page-wrapper mt-5" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 ml-5 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="col-md-12 col-lg-10 col-xxl-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <ul class="nav nav-tabs mb-3" id="personalInfoTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="personal-tab" data-bs-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="true">Informações Pessoais</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="bio-tab" data-bs-toggle="tab" href="#bio" role="tab" aria-controls="bio" aria-selected="false">Empresa</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                        <div class="mb-3">
                                            <label for="exampleInputtext1" class="form-label">Nome completo</label>
                                            <input type="text" name="nome" placeholder="Como chamaremos você..." class="form-control" id="exampleInputtext1" aria-describedby="textHelp">
                                        </div>
                                        <!-- ... Mais campos ... -->
                                    </div>
                                    <div class="tab-pane fade" id="bio" role="tabpanel" aria-labelledby="bio-tab">
                                        <div class="mb-3">
                                            <label for="exampleInputtext1" class="form-label">Biografia</label>
                                            <textarea name="bio" placeholder="Conte-nos um pouco sobre você..." class="form-control" id="exampleInputtext1" aria-describedby="textHelp"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- ... Conteúdo do segundo cartão ... -->
                    </div>
                </div>
                <div class="card mb-5 my-5">
                    <div class="card-body">
                        <!-- ... Formulário ... -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% include "parts/footer.php" %}

{% endblock %}
