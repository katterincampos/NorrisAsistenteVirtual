@extends('layouts.sitio')

@section('content')

<div class="container ">
  <div class="mt-5">
        <div style="background-color: #fff; box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);" class="d-style btn btn-brc-tp border-2 bgc-white btn-outline-blue btn-h-outline-blue btn-a-outline-blue w-100 my-2 py-3 shadow-sm">
          <!-- Basic Plan -->
          <div class="row align-items-center">
            <div class="col-12 col-md-4">
              <h4 class="pt-3 text-170 text-600 text-primary-d1 letter-spacing">
                Basico
              </h4>
  
              <div class="text-secondary-d1 text-120">
                <span class="ml-n15 align-text-bottom">$</span><span class="text-180">10</span> / al mes
              </div>
            </div>
  
            <ul class="list-unstyled mb-0 col-12 col-md-4 text-dark-l1 text-90 text-left my-4 my-md-0">

  
              <li class="mt-25">
                <i class="fa fa-check text-success-m2 text-110 mr-2 mt-1"></i>
                <span class="text-110">
                  Acceso a 5
              </span>
              </li>
            </ul>
  
            <div class="col-12 col-md-4 text-center">
              <a href="#" class="f-n-hover btn btn-info btn-raised px-4 py-25 w-75 text-600">Comprar</a>
            </div>
          </div>
  
        </div>
        
        <div style="background-color: #fff; box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1); " class="d-style bgc-white btn btn-brc-tp btn-outline-green btn-h-outline-green btn-a-outline-green w-100 my-2 py-3 shadow-sm border-2">
          <!-- Pro Plan -->
          <div class="row align-items-center">
            <div class="col-12 col-md-4">
              <h4 class="pt-3 text-170 text-600 text-green-d1 letter-spacing">
                Pro Plan
              </h4>
  
              <div class="text-secondary-d2 text-120">
                <div class="text-danger-m3 text-90 mr-1 ml-n4 pos-rel d-inline-block">
                  $<span class="text-150 deleted-text">30</span>
                  <span>
                      <span class="d-block rotate-45 position-l mt-n475 ml-35 fa-2x text-400 border-l-2 h-5 brc-dark-m1"></span>
                  </span>
                </div>
                <span class="align-text-bottom">$</span><span class="text-180">20</span> / month
              </div>
            </div>
  
            <ul class="list-unstyled mb-0 col-12 col-md-4 text-dark-l1 text-90 text-left my-4 my-md-0">
              <li>
                <i class="fa fa-check text-success-m2 text-110 mr-2 mt-1"></i>
                <span>
                  <span class="text-110">Acceso a 10 usuarios</span>
                </span>
              </li>
            </ul>
  
            <div class="col-12 col-md-4 text-center">
              <a href="#" class="f-n-hover btn btn-success btn-raised px-4 py-25 w-75 text-600">Comprar</a>
            </div>
          </div>
  
        </div>
        <div class="text-center">
          <a href="{{ route('loginAsociados') }}">Ya tienes cuenta? Inicia Sesion aqui</a>
        </div>
      </div>
  </div>
@endsection