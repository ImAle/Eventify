@extends('layouts.app')

@section('content')
<div class="container text-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Acceso Denegado</h4>
                <p>No tienes acceso a esta página. Por favor, asegúrate de cumplir con los siguientes requisitos:</p>
                
                <div class="d-flex justify-content-center">
                    <div class="card shadow-sm border-danger" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-danger">Requisitos de Acceso</h5>
                            <p class="card-text"><i class="fas fa-times-circle text-danger"></i> Tu cuenta debe estar <strong>activa</strong>.</p>
                            <p class="card-text"><i class="fas fa-times-circle text-danger"></i> Tu correo debe estar <strong>verificado</strong>.</p>
                        </div>
                    </div>
                </div>

                <hr>

                <p class="mb-0">Si tienes alguna duda, contacta con soporte técnico.</p>
                <a href="{{ url('/') }}" class="btn btn-primary mt-3">Volver a la página principal</a>
            </div>
        </div>
    </div>
</div>
@endsection
