@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Информация</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-text">
                                    Информация
                                </h4>
                                <img class="img-thumbnail" src="{{ Auth::user()->avatar }}" alt="">
                                <p class="card-text">{{ Auth::user()->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <h4>
                                    Список кабинетов
                                </h4>
                                <ul class="list-group">
                                    @forelse($cabinets as $cabinet)
                                        <a href="{{ route('cabinets.show', $cabinet) }}">
                                            <li class="list-group list-group-item">
                                                {{ $cabinet->name }}
                                                <div class="float-right">
                                                    <span class="badge badge-pill ">
                                                        role {{ $cabinet->pivot->role }}
                                                    </span>
                                                </div>
                                            </li>
                                        </a>

                                    @empty
                                        <div class="col-md-12">
                                            <p>
                                                Список кабинетов синхронизируются, попробуйте обновить страницу через пару
                                                минут
                                            </p>
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop