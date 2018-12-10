@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Информация о выбраном кабинете</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-text">
                                    Кабинет {{ $cabinet->name }}
                                </h4>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <a href="{{ route('cabinets.index') }}">
                                        К списку кабинетов >>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5 class="card-title">Список кампаний</h5>
                        <div class="row">
                            @foreach($cabinet->campaigns as $campaign)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card mb-2">
                                        <div class="card-header">
                                            Кампания <b>{{ $campaign->name }}</b>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>Тип:
                                                    <b>{{ $campaign->type }}</b>
                                                </li>
                                                <li>Дневной лимит:
                                                    <b>{{ $campaign->day_limit }} ₽</b>
                                                </li>
                                                <li>
                                                    Общий лимит:
                                                    <b>{{ $campaign->all_limit }} ₽</b>
                                                </li>
                                                <li>
                                                    Время запуска:
                                                    <b>{{ $campaign->start_time ?? '-' }}</b>
                                                </li>
                                                <li>
                                                    Время остановки:
                                                    <b>{{ $campaign->end_time ?? '-' }}</b>
                                                </li>
                                                <li>
                                                    Объявлений:
                                                    <b>{{ $campaign->ads->count() }}</b>
                                                </li>
                                                <li class="text-muted">
                                                    Синхронизирован:
                                                    <br>
                                                    {{ $campaign->updated_at }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ route('campaigns.show', $campaign) }}"
                                               class="btn btn-sm btn-primary">
                                                Страница кампании
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop