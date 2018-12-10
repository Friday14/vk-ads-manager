@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Info</div>
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
                                    @foreach($cabinets as $cabinet)
                                        <li class="list-group list-group-item">
                                            <a href="{{ route('cabinets.show', $cabinet) }}">
                                                <span class="text-muted">#{{ $cabinet->id }}</span>
                                                {{ $cabinet->name }}
                                                <div class="float-right">
                                                    <span class="badge badge-pill ">
                                                        role {{ $cabinet->pivot->role }}
                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop